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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

use Tempo\Bundle\AppBundle\Model\Project;
use Tempo\Bundle\AppBundle\Model\Organization;
use Tempo\Bundle\AppBundle\Form\Type\ProjectType;
use Tempo\Bundle\AppBundle\Form\Type\AccessType;

/**
 * Project controller.
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class ProjectController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        $manager = $this->container->get('tempo.manager.organization');
        $organizations = $manager->findAllByUser($this->getUser()->getId());

        return $this->render('TempoAppBundle:Project:dashboard.html.twig', array(
            'organizations' => $organizations
        ));
    }

    /**
     * Lists all organization projects.
     * @param $organization
     * @return Response
     */
    public function listAction(Organization $organization)
    {
        $projects = $organization->getProjects();
        $organizations = $this->getManager('organization')->findAll();

        return $this->render('TempoAppBundle:Project:list.html.twig', array(
            'organization' => $organization,
            'organizations' => $organizations,
            'projects' => $projects
        ));
    }

    /**
     * Finds and displays a Project entity.
     * @return Response
     */
    public function showAction(Request $request, Project $project)
    {
        $page = $request->query->get('page', 1);
        $token = $this->get('form.csrf_provider')->generateCsrfToken('delete-project');
        $project  = $this->getProject($project, 'VIEW');
        $organization = $project->getOrganization();

        if (null !== $project->getParent() && null !==  $project->getParent()->getName()) {
            $organization = $project->getParent(-1)->getOrganization();
        }

        $teamForm = $this->createForm(new AccessType($project));

        return $this->render('TempoAppBundle:Project:show.html.twig', array(
            'teamForm' => $teamForm->createView(),
            'organization' => $organization,
            'csrfToken' => $token,
            'tabProvidersRegistry' => $this->get('tempo.project.tabProvidersRegistry'),
            'page' => $page,
            'project' => $project
        ));
    }

    /**
     * Creates a new Project entity.
     * @return Response
     */
    public function createAction(Request $request, $organization)
    {
        if (false === $this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $organization = $this->getOrganizaton($organization);

        $project  = new Project();
        $project->setOrganization($organization);
        $project = $this->getParent($project);

        $form  = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));

        if ($form->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->create($project);
            $this->addFlash('success', 'project.success_create');

            return $this->redirectToRoute('project_show', array('slug' => $project->getSlug()));
        }

        return $this->render('TempoAppBundle:Project:create.html.twig', array(
            'form'   => $form->createView(),
            'organization' => $organization
        ));
    }

    /**
     * shortcuts redirection
     * Edits an existing Project entity.
     * @param $slug
     * @return Response
     */
    public function updateAction(Request $request, Project $project)
    {
        $project = $this->getProject($project, 'EDIT');
        $editForm   = $this->createForm(new ProjectType(), $project);

        if ($editForm->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->update($project);

            $this->addFlash('success', 'project.success_updated');

            return $this->redirectToRoute('project_upgrade', array('slug' => $project->getSlug()));
        }

        return $this->render('TempoAppBundle:Project:update.html.twig', array(
            'project'     =>  $project,
            'form'   =>  $editForm->createView(),
        ));
    }

    /**
     * Deletes a Project entity.
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, Project $project)
    {
        //check CSRF token
        if ($this->tokenIsValid('delete-organization', $request->get('token'))) {

            $project = $this->getProject($project, 'DELETE');

            $this->get('tempo.domain_manager')->delete($project);

            $this->addFlash('success', 'project.success_delete');

            return $this->redirectToRoute('project_home');
        }
    }

    public function versionAction(Request $request, Project $project)
    {
        $project = $this->getProject($project, 'EDIT');

        $repo = $this->getDoctrine()->getRepository('Tempo\Bundle\AppBundle\Model\LogEntry');
        $logs = $repo->getLogEntries($project);

        return $this->render('TempoAppBundle:Project:versions.html.twig', array(
            'project'      => $project,
            'logs'      => $logs,
        ));
    }

    protected function getProject($project, $right = 'VIEW')
    {
        if (is_string($project)) {
            $project = $this->getManager('project')->getProject($project);

            if(!$project) {
                $this->createNotFoundException();
            }
        }
        if (false === $this->isGranted($right, $project) && !$this->isGranted('ROLE_ADMIN', $project)) {
            throw new AccessDeniedException();
        }

        return $project;
    }
    protected function getOrganizaton($slug)
    {
        $organisation = $this->getManager('organization')->findOneBySlug($slug);
        if(!$organisation) {
            $this->createNotFoundException();
        }

        return $organisation;
    }

    /**
     * @param  Project $project
     * @return Project
     */
    protected function getParent(Project $project)
    {
        $parent = $this->get('request_stack')->getCurrentRequest()->query->get('parent');

        if (!empty($parent)) {
            $parent = $this->getManager('project')->getProject(intval($parent));
            if ($parent) {
                $project->setParent($parent);
            }
        }

        return $project;
    }
}
