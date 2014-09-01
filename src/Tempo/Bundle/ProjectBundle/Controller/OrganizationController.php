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

use Tempo\Bundle\MainBundle\Controller\Controller;
use Tempo\Bundle\ProjectBundle\Entity\Organization;
use Tempo\Bundle\ProjectBundle\Form\Type\OrganizationType;
use Tempo\Bundle\ProjectBundle\TempoProjectEvents;
use Tempo\Bundle\ProjectBundle\Event\OrganizationEvent;
use Tempo\Bundle\MainBundle\Form\Type\TeamType;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationController extends Controller
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
    public function showAction(Organization $organization, $_format)
    {
        $token = $this->get('form.csrf_provider')->generateCsrfToken('delete-organization');

        if (false === $this->get('security.context')->isGranted('VIEW', $organization) &&
            false === $this->get('security.context')->isGranted('ROLE_ADMIN') ) {
            throw new AccessDeniedException();
        }

        $counter = $this->get('tempo.manager.organization')->getStatusProjects($organization->getId());

        $this->getBreadcrumb()->addChild($organization->getName());

        $teamForm = $this->createForm(new TeamType());

        $data =  array(
            'organization' => $organization,
            'counter' => $counter,
            'projects' => $organization->getProjects(),
            'teamForm' => $teamForm->createView(),
            'token' => $token
        );

        if ($_format == 'json') {
           $data = array('organization' => $organization);
        }

        $view = $this->view($data, 200)
            ->setTemplate('TempoProjectBundle:Organization:show.html.twig')
        ;

        return $this->handleView($view);
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

        return $this->render('TempoProjectBundle:Organization:update.html.twig', array(
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

        return $this->render('TempoProjectBundle:Organization:create.html.twig', array(
            'form' => $form->createView(),
        ));
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
        return $this->redirectRoute('organization_show', array('slug' => $organization->getSlug()));
    }
}
