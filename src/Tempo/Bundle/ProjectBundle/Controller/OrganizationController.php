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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Tempo\Bundle\CoreBundle\Controller\BaseController;
use Tempo\Bundle\ProjectBundle\Entity\Organization;
use Tempo\Bundle\ProjectBundle\Form\Type\OrganizationType;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;
use Tempo\Bundle\ProjectBundle\TempoProjectEvents;
use Tempo\Bundle\ProjectBundle\Event\OrganizationEvent;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationController extends BaseController
{
    private function getBreadcrumb()
    {
        $breadcrumb = $this->get('tempo.main.breadcrumb');
        $breadcrumb->addChild('Organization');

        return $breadcrumb;
    }

    /**
     * @param $slug
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Organization $organization)
    {
        $token = $this->get('form.csrf_provider')->generateCsrfToken('delete-organization');

        if (false === $this->get('security.context')->isGranted('VIEW', $organization) &&
            false === $this->get('security.context')->isGranted('ROLE_ADMIN') ) {
            throw new AccessDeniedException();
        }

        $counter = $this->get('tempo.manager.organization')->getStatusProjects($organization->getId());

        $this->getBreadcrumb()->addChild($organization->getName());

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Organization:show.html.twig', array(
            'organization' => $organization,
            'counter' => $counter,
            'projects' => $organization->getProjects(),
            'teamForm' => $teamForm->createView(),
            'token' => $token
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

        $form = $this->createForm(new OrganizationType(), new Organization());

        return $this->render('TempoProjectBundle:Organization:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Organization $organization)
    {
        if (false === $this->get('security.context')->isGranted('EDIT', $organization)) {
            throw new AccessDeniedException();
        }

        $this->getBreadcrumb()->addChild($organization->getName());
        $this->getBreadcrumb()->addChild('Editer le organization');

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
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, Organization $organization)
    {
        if (false === $this->get('security.context')->isGranted('EDIT', $organization)) {
            throw new AccessDeniedException();
        }

        $editForm = $this->createForm(new OrganizationType(), $organization);

        if ($editForm->handleRequest($request)->isValid()) {
            $event = new OrganizationEvent($request, $organization);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_EDIT_INITIALIZE, $event);

            $this->getManager('organization')->save($organization);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_EDIT_SUCCESS, $event);

            $this->addFlash('success', 'organization.success_update', 'TempoProject');

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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $organization = new Organization();
        $organization->addTeam($this->getUser());

        $form = $this->createForm(new OrganizationType(), $organization);

        if ($form->handleRequest($request)->isValid()) {
            $event = new OrganizationEvent($request, $organization);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_CREATE_INITIALIZE, $event);

            $this->getManager('organization')->save($organization);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_CREATE_SUCCESS, $event);

            $this->getAclManager()->addObjectPermission($organization, MaskBuilder::MASK_OWNER); //set Permission
            $this->addFlash('success', 'organization.success_create','TempoProject');

            return $this->redirectToOrganization($organization);
        }

        return new Response('', 412);
    }

    /**
     * Delete a organization
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, Organization $organization)
    {
        if (false === $this->get('security.context')->isGranted('DELETE', $organization)) {
            throw new AccessDeniedException();
        }

        //check token
        if ($this->tokenIsValid('delete-organization', $request->get('token'))) {
            try {

                $this->getManager('organization')->remove($organization);
                $event = new OrganizationEvent($request, $organization);

                $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ORGANIZATION_DELETE_COMPLETED, $event);
                $this->setFlash('success', 'organization.success_delete', 'TempoProject');

            } catch (\InvalidArgumentException $e) {
                $this->setFlash('error', 'organization.failed_delete', 'TempoProject');

                return $this->redirectToOrganization($organization);
            }
        }
    }

    protected function redirectToOrganization($organization)
    {
        return $this->redirect($this->generateUrl('organization_show', array('slug' => $organization->getSlug())));
    }
}
