<?php

/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tempo\Bundle\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Form\Type\AccessType;
use Tempo\Bundle\AppBundle\Event\AccessEvent;
use Tempo\Bundle\AppBundle\Model\Access;
use Tempo\Bundle\AppBundle\TempoAppEvents;

/*
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class AccessController extends Controller
{
    /**
     * @param $slug
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request, $slug)
    {
        $objectManager = $this->getObjectManager($request->get('_route'), $slug);
        $resource  = $objectManager['model'];
        $slug = $objectManager['route'] == 'project_show' ? $resource->getFullSlug() : $resource->getSlug();

        $routeRedirect = $this->generateUrl($objectManager['route'], array('slug' => $slug));

        $form = $this->createForm(new AccessType($resource));

        if ($form->handleRequest($request)->isValid()) {

            $formData = $form->getData();

            if (filter_var($formData['username'], FILTER_VALIDATE_EMAIL)) {
                $access = (new Access())
                    ->setInviteEmail($formData['username'])
                    ->setInviteToken(sha1(uniqid(rand(), true)))
                    ->setLabel($formData['role'])
                    ->setSource($resource);
                
                $this->get('tempo.domain_manager')->create($access);
                $this->sentEmail($access);

                $this->addFlash('success', 'tempo.team.success_send_invitation');
            } else {
                $user = $this->findUser(array('username' => $formData['username']));
                $event = new AccessEvent($request, $resource, $user, $this->getUser());
                                
                if ($resource->getMemberByUser($user) == '') {
                    $resource->addAccess($user, $formData['role']);

                    $this->get('tempo.domain_manager')->create($resource);
                    $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

                    $this->addFlash('success', 'tempo.team.success_add');
                }  else {
                    $this->addFlash('error', 'tempo.team.already_exist');                
                }
            }
        }
        return $this->redirect($routeRedirect);
    }
    
    /**
     * 
     * @param Request $request
     * @param Access $access
     * @return type
     */
    public function inviteAction(Request $request, Access $access)
    {
        if ($this->isGranted('EDIT', $access->getResource())) {
            $this->sentEmail($access);
            $this->addFlash('success', 'tempo.team.invite_again_success');
        } else {
            $this->addFlash('error', 'tempo.team.not_allowed');
        }
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * @param  Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $slug, $user)
    {
        $objectManager = $this->getObjectManager($request->get('_route'), $slug);
        $resource =  $objectManager['model'];
        $resourceName = (new \ReflectionClass($resource))->getShortName();

        $access = $this->get('tempo.repository.access')->findOneBy(array(
            'user' => $user,
            strtolower($resourceName) => $resource
        ));

        $event = new AccessEvent($request, $resource, $access->getUser(), $this->getUser());
        
        $this->get('tempo.domain_manager')->delete($access);
        $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

        return $this->redirect($request->headers->get('referer'));
    }

    private function getObjectManager($route, $slug)
    {
        switch ($route) {
            case 'project_team_add':
            case 'project_team_delete':
                $objectManager = array(
                    'manager' => $this->getManager('project'),
                    'route' => 'project_show',
                    'event' => TempoAppEvents::PROJECT_ASSIGN_USER
                );
                break;
            case 'organization_team_add':
            case 'organization_team_delete':
                $objectManager = array(
                    'manager' => $this->getManager('organization'),
                    'route' => 'organization_show',
                    'event' => TempoAppEvents::ORGANIZATION_ASSIGN_USER
                );
                break;
            case 'room_team_add':
            case 'room_team_delete':
                $objectManager = array(
                    'manager' => $this->getManager('room'),
                    'route' => 'room_list',
                    'event' => TempoAppEvents::ROOM_ASSIGN_USER
                );
                break;
        }

        $objectManager['model'] = $objectManager['manager']->findOneBySlug($slug);

        return $objectManager;
    }

    /**
     * @param $parameters
     * @return \Tempo\Bundle\AppBundle\Model\User
     */
    private function findUser($parameters)
    {
        if(!$user = $this->get('tempo.repository.user')->findOneBy($parameters)) {
           $this->createNotFoundException('User not found');
        }

        return $user;
    }
    
    /**
     * 
     * @param Access $access
     */
    private function sentEmail(Access $access)
    { 
        $this->get('tempo.mailer.sender')->sender('TempoAppBundle:Mail:Access/invitation.html.twig', array(
            'resource' => $access->getResource(),
            'access' => $access,
            'user' => $this->getUser(),
            'emails' => $access->getInviteEmail()
        ));
    }
}
