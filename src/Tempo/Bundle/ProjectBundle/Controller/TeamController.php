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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;

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
        $form = $this->createForm(new TeamType());

        $objectManager = $this->getSection($request->get('_route'), $slug);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $formData = $form->getData();
            $findUser = $this->findUser(array('username' => $formData['username']));

            $objectManager['model']->addTeam($findUser);
            $objectManager['manager']->save($objectManager['model']);
            $this->getAclManager()->addObjectPermission($objectManager['model'], MaskBuilder::MASK_VIEW); //set Permission

            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('team.success_add', array(), 'TempoProject'));

            return $this->redirect($this->generateUrl($objectManager['route'], array('slug' => $objectManager['model']->getSlug())));
        }

        return $this->redirect($this->generateUrl($objectManager['route'], array('slug' => $objectManager['model']->getSlug() )));
    }

    /**
     * @param  Request          $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $slug, $user)
    {
        $objectManager = $this->getSection($request->get('_route'), $slug);
        $user = $this->findUser(array('id' => $user));

        $objectManager['model']->getTeam()->removeElement($user);
        $objectManager['manager']->save($objectManager['model']);
        $this->getAclManager()->revokeAllClassPermissions($objectManager['model']); //remove Permission

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    protected function getSection($route, $slug)
    {
        switch ($route) {
            case 'project_team_add':
            case 'project_team_delete':
                $manager = $this->get('tempo_project.manager.project');
                $routeSuccess = 'project_show';
            break;
            case 'organization_team_add':
            case 'organization_team_delete':
                $manager = $this->get('tempo_project.manager.organization');
                $routeSuccess = 'organization_show';
            break;
        }

        return array(
            'route' => $routeSuccess,
            'model' => $manager->findOneBySlug($slug),
            'manager' => $manager
        );
    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\TeamManager
     * @return mixed
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Get translator.
     *
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }

    /**
     * @return object
     */
    protected function getAclManager()
    {
        return $this->get('problematic.acl_manager');
    }

    public function findUser($paramters)
    {
        $user = $this->getDoctrine()->getRepository('TempoUserBundle:User')->findOneBy($paramters);

        if (!$user) {
           $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
