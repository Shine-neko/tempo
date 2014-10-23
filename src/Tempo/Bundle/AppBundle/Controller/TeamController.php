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
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Tempo\Bundle\AppBundle\Controller\Controller;
use Tempo\Bundle\AppBundle\Form\Type\TeamType;
use Tempo\Bundle\AppBundle\Event\TeamEvent;
use Tempo\Bundle\AppBundle\TempoProjectEvents;

/*
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class TeamController extends Controller
{
    /**
     * @param $slug
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request, $slug)
    {
        $objectManager = $this->getObjectManager($request->get('_route'), $slug);
        $routeRedirect = $this->generateUrl($objectManager['route'], array('slug' => $objectManager['model']->getSlug()));

        $form = $this->createForm(new TeamType($objectManager['model']));

        if ($form->handleRequest($request)->isValid()) {

            $formData = $form->getData();
            $user = $this->findUser(array('username' => $formData['username']));

            $event = new TeamEvent($request, $objectManager['model'], $user, $this->getUser());

            $objectManager['model']->addUser($user);
            $objectManager['manager']->save($objectManager['model']);
            $this->getAclManager()->addObjectPermission($objectManager['model'], MaskBuilder::MASK_VIEW); //set Permission

            $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

            $this->addFlash('success', 'tempo.team.success_add', 'TempoProject');

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
        $user = $this->findUser(array('id' => $user));

        $event = new TeamEvent($request, $objectManager['model'], $user, $this->getUser());

        $objectManager['model']->getTeam()->removeElement($user);
        $objectManager['manager']->save($objectManager['model']);
        $this->getAclManager()->revokeAllClassPermissions($objectManager['model']); //remove Permission

        $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    protected function getObjectManager($route, $slug)
    {
        $objectManager = array();

        switch ($route) {
            case 'project_team_add':
            case 'project_team_delete':
                $objectManager['manager'] = $this->getManager('project');
                $objectManager['route'] = 'project_show';
                $objectManager['event'] = TempoProjectEvents::PROJECT_ASSIGN_USER;

                break;
            case 'organization_team_add':
            case 'organization_team_delete':
                $objectManager['manager'] = $this->getManager('organization');
                $objectManager['route']  = 'organization_show';
                $objectManager['event'] = TempoProjectEvents::ORGANIZATION_ASSIGN_USER;

                break;
        }

        $objectManager['model'] = $objectManager['manager']->findOneBySlug($slug);

        return $objectManager;
    }

    /**
     * @param $paramters
     * @return \Tempo\Bundle\AppBundle\Model\User
     */
    public function findUser($parameters)
    {
        $user = $this->getDoctrine()->getRepository('TempoAppBundle:User')->findOneBy($parameters);

        if (!$user) {
           $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
