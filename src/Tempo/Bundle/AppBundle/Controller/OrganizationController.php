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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tempo\Bundle\AppBundle\Model\Organization;
use Tempo\Bundle\AppBundle\Form\Type\OrganizationType;
use Tempo\Bundle\AppBundle\Form\Type\AccessType;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationController extends Controller
{
    private function getBreadcrumb()
    {
        $breadcrumb = $this->get('tempo.breadcrumb');
        $breadcrumb->addChild('Organization');

        return $breadcrumb;
    }

    /**
     * @param Organization $organization
     * @return Response|AccessDeniedException
     */
    public function showAction(Organization $organization)
    {
        $token = $this->get('form.csrf_provider')->generateCsrfToken('delete-organization');

        if (false === $this->isGranted('VIEW', $organization)) {
            return $this->createAccessDeniedException();
        }

        $counter = $this->getManager('organization')->getStatusProjects($organization->getId());

        $this->getBreadcrumb()->addChild($organization->getName());

        $teamForm = $this->createForm(new AccessType($organization));

        return $this->render('TempoAppBundle:Organization:show.html.twig', array(
            'organization' => $organization,
            'counter' => $counter,
            'projects' => $organization->getProjects(),
            'teamForm' => $teamForm->createView(),
            'token' => $token
        ));
    }

    /**
     * Edits an existing Organization entity.
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, Organization $organization)
    {
        if (false === $this->isGranted('EDIT', $organization)) {
            return $this->createAccessDeniedException();
        }

        $editForm = $this->createForm(new OrganizationType(), $organization);
        $teamForm = $this->createForm(new AccessType($organization));

        if ($editForm->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->update($organization);

            $this->addFlash('success', 'organization.success_update');

            return $this->redirectToOrganization($organization);
        }

        return $this->render('TempoAppBundle:Organization:update.html.twig', array(
            'organization' => $organization,
            'form' => $editForm->createView(),
            'teamForm' => $teamForm->createView(),
        ));
    }

    /**
     * Create a organization
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function createAction(Request $request)
    {
        $role = $this->get('sylius.settings.manager')->loadSettings('project')->get('right_create_orga');

        if (false === $this->isGranted($role)) {
            return $this->createAccessDeniedException();
        }

        $organization = new Organization();
        $organization->addAccess($this->getUser());

        $form = $this->createForm(new OrganizationType(), $organization);

        if ($form->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->create($organization);

            $this->addFlash('success', 'organization.success_create');

            return $this->redirectToOrganization($organization);
        }

        return $this->render('TempoAppBundle:Organization:create.html.twig', array(
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
        if (false === $this->isGranted('DELETE', $organization)) {
            return $this->createAccessDeniedException();
        }

        //check token
        if ($this->tokenIsValid('delete-organization', $request->get('token'))) {
            try {

                $this->get('tempo.domain_manager')->delete($organization);
                $this->addFlash('success', 'organization.success_delete');

            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', 'organization.failed_delete');

                return $this->redirectToOrganization($organization);
            }
        }
    }

    protected function redirectToOrganization($organization)
    {
        return $this->redirectToRoute('organization_show', array('slug' => $organization->getSlug()));
    }
}
