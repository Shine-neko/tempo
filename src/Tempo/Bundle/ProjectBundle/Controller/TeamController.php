<?php

/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tempo\Bundle\ProjectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Tempo\Bundle\CoreBundle\Controller\BaseController;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;

use Tempo\Bundle\ProjectBundle\Event\TeamEvent;
use Tempo\Bundle\ProjectBundle\TempoProjectEvents;

/*
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class TeamController extends BaseController
{
    /**
     * @param $slug
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request, $slug)
    {
        $form = $this->createForm(new TeamType());

        $objectManager = $this->getSection($request->get('_route'), $slug);
        $routeRedirect = $this->generateUrl($objectManager['route'], array('slug' => $objectManager['model']->getSlug()));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $formData = $form->getData();
            $user = $this->findUser(array('username' => $formData['username']));

            $event = new TeamEvent($request, $objectManager['model']);
            $event->setType('add')
                 ->setUserTo($user)
                 ->setUserFrom($this->getUser());

            $objectManager['model']->addTeam($user);
            $objectManager['manager']->save($objectManager['model']);
            $this->getAclManager()->addObjectPermission($objectManager['model'], MaskBuilder::MASK_VIEW); //set Permission

            $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

            $this->addFlash('success', 'team.success_add', 'TempoProject');

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
        $objectManager = $this->getSection($request->get('_route'), $slug);
        $user = $this->findUser(array('id' => $user));

        $event = new TeamEvent($request, $objectManager['model']);
        $event->setType('delete')
            ->setUserTo($user)
            ->setUserFrom($this->getUser());

        $objectManager['model']->getTeam()->removeElement($user);
        $objectManager['manager']->save($objectManager['model']);
        $this->getAclManager()->revokeAllClassPermissions($objectManager['model']); //remove Permission

        $this->get('event_dispatcher')->dispatch($objectManager['event'], $event);

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    protected function getSection($route, $slug)
    {
        $objectManager = array();

        switch ($route) {
            case 'project_team_add':
            case 'project_team_delete':
                $objectManager['manager'] = $this->getManager('project');
                $objectManager['route'] = 'project_show';
                $objectManager['event'] = TempoProjectEvents::PROJECT_ASSIGNING_USER;

                break;
            case 'organization_team_add':
            case 'organization_team_delete':
                $objectManager['manager'] = $this->getManager('organization');
                $objectManager['route']  = 'organization_show';
                $objectManager['event'] = TempoProjectEvents::ORGANIZATION_ASSIGNING_USER;

                break;
        }

        $objectManager['model'] = $objectManager['manager']->findOneBySlug($slug);

        return $objectManager;
    }

    /**
     * @param $paramters
     * @return \Tempo\Bundle\UserBundle\Entity\User
     */
    public function findUser($paramters)
    {
        $user = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findOneBy($paramters);

        if (!$user) {
           $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
