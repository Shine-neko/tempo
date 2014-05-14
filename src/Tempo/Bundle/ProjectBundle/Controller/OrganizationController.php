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

use Tempo\Bundle\ProjectBundle\Entity\Organization;
use Tempo\Bundle\ProjectBundle\Form\Type\OrganizationType;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;
use Tempo\Bundle\ProjectBundle\TempoProjectEvents;
use Tempo\Bundle\ProjectBundle\Event\ProjectEvent;
use Tempo\Bundle\ProjectBundle\Event\OrganizationEvent;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationController extends Controller
{
    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $organization = $this->findOrganization($slug);
        $csrfToken = $this->get('form.csrf_provider')->generateCsrfToken('delete-organization');

        if (false === $this->get('security.context')->isGranted('VIEW', $organization) &&
            false === $this->get('security.context')->isGranted('ROLE_ADMIN') ) {
            throw new AccessDeniedException();
        }

        $manager = $this->get('tempo.manager.organization');
        $counter = $manager->getStatusProjects($organization->getId());

        $breadcrumb = $this->get('tempo.main.breadcrumb');
        $breadcrumb->addChild('Organization');
        $breadcrumb->addChild($organization->getName());

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Organization:show.html.twig', array(
            'organization' => $organization,
            'counter' => $counter,
            'projects' => $organization->getProjects(),
            'teamForm' => $teamForm->createView(),
            'csrfToken' => $csrfToken
        ));
    }

    /**
     * Create new organization
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new OrganizationType(), new Organization(), array('is_new' => true));

        return $this->render('TempoProjectBundle:Organization:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($slug)
    {
        $organization = $this->findOrganization($slug);

        if (false === $this->get('security.context')->isGranted('EDIT', $organization)) {
            throw new AccessDeniedException();
        }

        $breadcrumb = $this->get('tempo.main.breadcrumb');
        $breadcrumb->addChild('Organization');
        $breadcrumb->addChild($organization->getName());
        $breadcrumb->addChild('Editer le organization');

        $editForm = $this->createForm(new OrganizationType(), $organization);

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Organization:edit.html.twig', array(
            'organization' => $organization,
            'form' => $editForm->createView(),
            'teamForm' => $teamForm->createView(),
        ));
    }

    /**
     * Edits an existing Organization entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->get('tempo.manager.organization');

        $organization = $manager->find($id);

        if (false === $this->get('security.context')->isGranted('EDIT', $organization)) {
            throw new AccessDeniedException();
        }

        $editForm = $this->createForm(new OrganizationType(), $organization);

        if ($request->isMethod('POST') && $editForm->submit($request)->isValid()) {
            $event = new OrganizationEvent($organization, $request);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_EDIT_INITIALIZE, $event);

            $manager->save($organization);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_EDIT_SUCCESS, $event);

            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('organization.success_deleted', array(), 'TempoProject'));

            return $this->redirectToOrganization($organization);
        }

        return $this->render('TempoProjectBundle:Organization:edit.html.twig', array(
            'organization' => $organization,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Create a organization
     * @return array
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $organization = new Organization();
        $organization->addTeam($this->getUser());

        $form = $this->createForm(new OrganizationType(), $organization);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $event = new OrganizationEvent($organization, $request);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_CREATE_INITIALIZE, $event);

            $this->getManager()->save($organization);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_CREATE_SUCCESS, $event);

            $this->getAclManager()->addObjectPermission($organization, MaskBuilder::MASK_OWNER); //set Permission
            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('organization.success_create', array(), 'TempoProject'));

            return $this->redirectToOrganization($organization);
        }
    }

    /**
     * Delete a organization
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $slug)
    {
        $organization = $this->findOrganization($slug);

        if (false === $this->get('security.context')->isGranted('DELETE', $organization)) {
            throw new AccessDeniedException();
        }

        //check CSRF token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid('delete-organization', $request->get('token'))) {
            throw new AccessDeniedException('Invalid CSRF token.');
        }

        try {

            $this->getManager()->remove($organization);
            $event = new ProjectEvent($organization, $request);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_DELETE_COMPLETED, $event);
            $request->getSession()->getFlashBag()->set('success', $this->getTranslator()->trans('organization.success_delete', array(), 'TempoProject'));

        } catch (\InvalidArgumentException $e) {
            $request->getSession()->getFlashBag()->set('error', $this->getTranslator()->trans('organization.failed_delete', array(), 'TempoProject'));

            return $this->redirectToOrganization($organization);
        }

    }

    /**
     * return Tempo\Bundle\ProjectBundle\Manager\OrganizationManager
     * @return mixed
     */
    protected function getManager()
    {
        return $this->get('tempo.manager.organization');
    }

    /**
     * @param $slug
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findOrganization($slug)
    {
        return $this->getManager()->findOneBySlug($slug);
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }

    /**
     * @return \Problematic\AclManagerBundle\Domain\AclManager
     */
    protected function getAclManager()
    {
        return $this->get('problematic.acl_manager');
    }

    protected function redirectToOrganization($organization)
    {
        return $this->redirect($this->generateUrl('organization_show', array('slug' => $organization->getSlug())));
    }
}
