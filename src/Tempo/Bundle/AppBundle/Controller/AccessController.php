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
        $routeRedirect = $this->generateUrl($objectManager['route'], array('slug' => $resource->getSlug()));

        $form = $this->createForm(new AccessType($resource));

        if ($form->handleRequest($request)->isValid()) {

            $formData = $form->getData();
            $user = $this->findUser(array('username' => $formData['username']));

            $event = new AccessEvent($request, $resource, $user, $this->getUser());

            $resource->addAccess($user);
            $this->get('tempo.domain_manager')->create($resource);
            $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

            $this->addFlash('success', 'tempo.team.success_add');

            return $this->redirect($routeRedirect);
        }

        return $this->redirect($routeRedirect);
    }

    /**
     * @param  Request          $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $slug, $user)
    {
        $objectManager = $this->getObjectManager($request->get('_route'), $slug);
        $resource =  $objectManager['model'];
        $resourceName = (new \ReflectionClass($resource))->getShortName();

        $access = $this->getDoctrine()->getRepository('TempoAppBundle:Access')->findOneBy(array(
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
        }

        $objectManager['model'] = $objectManager['manager']->findOneBySlug($slug);

        return $objectManager;
    }

    /**
     * @param $parameters
     * @return \Tempo\Bundle\AppBundle\Model\User
     */
    public function findUser($parameters)
    {
        if(!$user = $this->get('tempo.repository.user')->findOneBy($parameters)) {
           $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
