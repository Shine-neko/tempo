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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Tempo\Bundle\CoreBundle\Controller\BaseController;
use Tempo\Bundle\ProjectBundle\Entity\Project;
use Tempo\Bundle\ProjectBundle\Form\Type\ProjectType;
use Tempo\Bundle\ProjectBundle\Form\Type\TeamType;
use Tempo\Bundle\ProjectBundle\TempoProjectEvents;
use Tempo\Bundle\ProjectBundle\Event\ProjectEvent;

/**
 * Project controller.
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class ProjectController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        /* set breadcrumb */
        $breadcrumb  = $this->get('tempo.main.breadcrumb');
        $breadcrumb->addChild('Project');

        $manager = $this->container->get('tempo.manager.organization');
        $organizations = $manager->findAllByUser($this->getUser()->getId());

        return $this->render('TempoProjectBundle:Project:dashboard.html.twig', array(
            'organizations' => $organizations
        ));
    }

    /**
     * Lists all organization projects.
     * @param $organization
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($slug)
    {
        //find info organization
        $manageOrganization = $this->getManager('organization');
        $organization = $manageOrganization->findOneBySlug($slug);

        if (!$organization) {
            throw new NotFoundHttpException(sprintf("organization with slug '%s' could not be found.", $organization));
        }

        $projects = $organization->getProjects();   //List Project
        $organizations = $manageOrganization->findAll();  // List Organization

        return $this->render('TempoProjectBundle:Project:list.html.twig', array(
            'organization' => $organization,
            'organizations' => $organizations,
            'projects' => $projects
        ));
    }

    /**
     * Finds and displays a Project entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($slug)
    {
        $csrfToken = $this->get('form.csrf_provider')->generateCsrfToken('delete-project');

        $project  = $this->getProject($slug, 'VIEW');

        $teamForm = $this->createForm(new TeamType());

        return $this->render('TempoProjectBundle:Project:show.html.twig', array(
            'teamForm'      => $teamForm->createView(),
            'project'       => $project,
            'csrfToken'     => $csrfToken,
            'tabProvidersRegistry'   => $this->get('tempo.project.tabProvidersRegistry')
        ));
    }

    /**
     * Displays a form to create a new Project entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $project = new Project();
        $this->getParent($project);

        $form   = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));

        return $this->render('TempoProjectBundle:Project:new.html.twig',array(
            'entity' => $project,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Project entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $project  = new Project();
        $project->addTeam($this->getUser());
        $project = $this->getParent($project);

        $form  = $this->createForm(new ProjectType(), $project, array('user_id' => $this->getUser()->getId() ));

        if ($form->submit($request)->isValid()) {
            $event = new ProjectEvent($project, $request);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::PROJECT_CREATE_INITIALIZE, $event);

            $this->getManager('project')->save($project);
            $this->getAclManager()->addObjectPermission($project, MaskBuilder::MASK_OWNER); //set Permission
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::PROJECT_CREATE_SUCCESS, $event);
            $this->addFlash('success', 'project.success_create', 'TempoProject');

            return $this->redirect($this->generateUrl('project_show', array('slug' => $project->getSlug())));
        }

        return $this->render('TempoProjectBundle:Project:new.html.twig', array(
            'entity' => $project,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     * @param $slug string
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($slug)
    {
        $project = $this->getManager('project')->getProject($slug, 'EDIT');
        $editForm = $this->createForm(new ProjectType(), $project);

        return $this->render('TempoProjectBundle:Project:edit.html.twig', array(
            'project'      => $project,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Project entity.
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $slug)
    {
        $project = $this->getProject($slug, 'EDIT');
        $editForm   = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST') && $editForm->submit($request)->isValid()) {
            $event = new ProjectEvent($project, $request);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::PROJECT_EDIT_INITIALIZE, $event);

            $this->getManager('project')->save($project);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::PROJECT_EDIT_SUCCESS, $event);


            $this->setFlash('success', 'project.success_updated', 'TempoProject');
            return $this->redirect($this->generateUrl('project_edit', array('slug' => $project->getSlug() )));
        }

        return $this->render('TempoProjectBundle:Project:edit.html.twig', array(
            'project'     =>  $project,
            'edit_form'   =>  $editForm->createView(),
        ));
    }

    /**
     * Deletes a Project entity.
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $slug)
    {
        //check CSRF token
        if ($this->isTokenValid('delete-organization', $request->get('token'))) {

            $project = $this->getProject($slug, 'DELETE');

            $this->getManager('project')->remove($project);
            $event = new ProjectEvent($project, $request);
            $this->get('event_dispatcher')->dispatch(TempoProjectEvents::PROJECT_DELETE_COMPLETED, $event);

            $this->setFlash('success', 'project.success_delete', 'TempoProject');

            return $this->redirect($this->generateUrl('project_home'));
        }
    }

    protected function getProject($key, $right = 'VIEW')
    {
        $project = $this->getManager('project')->getProject($key);

        if(!$project) {
            $this->createNotFoundException();
        }
        if (
            false === $this->get('security.context')->isGranted($right, $project) &&
            !$this->get('security.context')->isGranted('ROLE_ADMIN', $project)
        ) {
            throw new AccessDeniedException();
        }

        return $project;
    }

    /**
     * @param  \Tempo\Bundle\ProjectBundle\Entity\Project $project
     * @return \Tempo\Bundle\ProjectBundle\Entity\Project
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
