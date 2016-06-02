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
use Tempo\Bundle\ResourceExtraBundle\Util\ClassUtils;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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
        $resource  = $objectManager['resource'];
        $slug = $objectManager['route'] == 'project_show' ? $resource->getFullSlug() : $resource->getSlug();

        $routeRedirect = $this->generateUrl($objectManager['route'], array('slug' => $slug));
        $form = $this->createForm(new AccessType($resource));

        if ($form->handleRequest($request)->isValid()) {
            $formData = $form->getData();
            $user = $this->getManager('user')->findUserByUsernameOrEmail($formData['login']);

            try {
                $this->get('tempo.repository.access')->findAccess($resource, $formData['login']);
                $this->addFlash('error', 'tempo.team.already_exist');
            } catch(NonUniqueResultException  $e) {
                $this->addFlash('error', 'tempo.team.already_exist');
            } catch(NoResultException  $e) {

                if (null === $user && filter_var($formData['login'], FILTER_VALIDATE_EMAIL)) {
                    $access = (new Access())
                        ->setInviteEmail($formData['login'])
                        ->setInviteToken(sha1(uniqid(rand(), true)))
                        ->setLabel($formData['role'])
                        ->setSource($resource);

                    $this->get('tempo.domain_manager')->create($access);
                    $this->sentEmail($access);
                    $this->addFlash('success', 'tempo.team.success_send_invitation');

                } else {
                    $event = new AccessEvent($request, $resource, $user, $this->getUser());
                    $resource->addAccess($user, $formData['role']);

                    $this->get('tempo.domain_manager')->update($resource);
                    $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);
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
        $resource =  $objectManager['resource'];
        $resourceName = ClassUtils::getShortName($resource);

        $access = $this->get('tempo.repository.access')->findOneBy(array(
            'user' => $user,
            $resourceName => $resource
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
            case 'room_leave':
                $objectManager = array(
                    'manager' => $this->getManager('room'),
                    'route' => 'room_list',
                    'event' => TempoAppEvents::ROOM_ASSIGN_USER
                );
                break;
        }

        $key = is_string($slug) ? 'slug' : 'id';
        $objectManager['resource'] = $objectManager['manager']->findOneBy(array($key => $slug));

        if (null === $objectManager['resource']) {
            throw $this->createNotFoundException();
        }

        return $objectManager;
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
