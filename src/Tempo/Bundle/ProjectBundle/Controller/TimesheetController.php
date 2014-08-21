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
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use CalendR\Period\Week;

use Tempo\Bundle\CoreBundle\Controller\BaseController;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetType;
use Tempo\Bundle\ProjectBundle\Filter\Type\TimesheetFilterType;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetExportType;
use Tempo\Bundle\ProjectBundle\Export\Excel as ExportCVS;
use Tempo\Bundle\ProjectBundle\Entity\Timesheet;

/**
 * Timesheet controller.
 *
 */
class TimesheetController extends BaseController
{
    /**
     * Lists all Timesheet entities.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function dashboardAction(Request $request)
    {
        $breadcrumb  = $this->get('tempo.main.breadcrumb');
        $breadcrumb->addChild('Time Management');
        $breadcrumb->addChild('Dashboard');

        return $this->render('TempoProjectBundle:Timesheet:dashboard.html.twig', $this->filterData($request));
    }

    /**
     * Edits an existing activity.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, Timesheet $timesheet)
    {
        $editForm = $this->createForm(new TimesheetType(), $timesheet);

        if ($editForm->handleRequest($request)->isValid()) {
            $this->getManager('timesheet')->save($timesheet);
            
            return $this->redirectRoute('timesheet');
        }

        return $this->render('TempoProjectBundle:Timesheet:update.html.twig', array(
            'timesheet'      => $timesheet,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Activity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);

        if ($form->submit($request)->isValid()) {
            $entity = $this->getManager('timesheet')->find($id);
            $this->getManager('timesheet')->remove($entity);
        }

        return $this->redirectRoute('timesheet');
    }

    public function exportPDFAction(Request $request)
    {
        $form = $this->createForm(new TimesheetExportType(), array(
            'to' => (new \DateTime())->format('Y-m-d')
        ));

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $list = $this->getManager('timesheet')->repository->findAllByUser();

            $html = $this->renderView('TempoProjectBundle:Timesheet:export/pdf_tpl.html.twig', array(
                'list'  => $list
            ));

            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="file.pdf"'
                )
            );
        }

        return $this->render('TempoProjectBundle:Timesheet:export/pdf.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @ParamConverter("end", options={"format": "Y-m-d"})
     * @param  \DateTime $date
     * @return Response
     */
    public function showAction(\DateTime $date)
    {
        return $this->render('TempoProjectBundle:Timesheet:show.html.twig', array(
            'activities' => $this->getManager('timesheet')->findByPeriod($date)
        ));
    }

    /**
     * @param Request $request
     * @param  $project
     * @return View
     * @Post()
     */
    public function createAction(Request $request, $project)
    {
        $project = $this->getManager('project')->find($project);

        $view = View::create();

        $period = new Timesheet();
        $period->setProject($project);
        $period->setUser($this->getUser());

        $form = $this->createForm(new TimesheetType(), $period);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getManager('timesheet')->save($period);
            $view->setStatusCode(201);
            $view->setData($period);
            $view->setFormat('json');

            $this->addFlash('success', 'tempo.timesheets.success_add', 'TempoProject');

        } else {
            $view->setData($form);
        }

        return $view;
    }

    public function exportCSVAction(Request $request)
    {
        $form = $this->createForm(new TimesheetExportType(), array(
            'from' => (new \DateTime())->format('Y-m-d')
        ));

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $file = (new ExportCVS($this->filterData($request) ))->save(sys_get_temp_dir() );

            return $this->downloadFile($file);
        }

        return $this->render('TempoProjectBundle:Timesheet:export/excel.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    private function filterData(Request $request)
    {
        $locale = $this->container->getParameter('locale');
        $workDay = $this->container->getParameter('tempo_project.week');
        $currentYear = $request->query->get('year', date('Y'));
        $currentWeek = $request->query->get('week', date('W'));

        $week = (new \DateTime())->setISOdate($currentYear, $currentWeek);
        $factoryWeek = new Week($week);

        $weekPagination = array(
            'next' => date("W", strtotime("+1 week", $week->getTimestamp())),
            'current' => $currentWeek ,
            'prev' => date("W", strtotime("-1 week", $week->getTimestamp())),
            'year' => $currentYear
        );

        $filterFormType = $this->createForm(new TimesheetFilterType());
        $processFilter = $this->processFilter($filterFormType, $request);

        if (empty($processFilter)) {
            $processFilter['from'] = $factoryWeek->getBegin();
            $processFilter['to'] = $factoryWeek->getEnd();
        }

        $projectsActivityReporting = $this->get('tempo.manager.timesheet')->findActivities(
            $this->getUser()->getId(), $processFilter['from']->format('Y-m-j'), $processFilter['to']->format('Y-m-j')
        );

        $projectList = $this->getManager('project')->repository->findAllByUser($this->getUser()->getId());

        $proxiesProject = $this->getManager('timesheet')->getActivitiesForPeriod(
            $projectsActivityReporting,
            $projectList
        );

        $daysInWeek = $this->getManager('timesheet')->getDaysInWeek($factoryWeek);

        return array(
            'daysInWeek' => $daysInWeek,
            'week' => $this->getManager('timesheet')->getWorkday($workDay[$locale], $daysInWeek),
            'currentWeek' => $week,
            'proxiesProject' => $proxiesProject,
            'weekPagination' => $weekPagination,
            'filter' => $filterFormType->createView()
        );
    }

    private function processFilter($filterForm, Request $request)
    {
        if ($filterForm->isSubmitted()) {

            if ($filterForm->handleRequest($request)->isValid()) {
                $dataFilter = $filterForm->getData();

                $dataFilter['from'] = new \DateTime($dataFilter['from']);
                $dataFilter['to']  = new \DateTime($dataFilter['to']);

                return $dataFilter;
            }
        }

        return array();
    }

    private function downloadFile($filePath)
    {

        $filename = pathinfo($filePath)['basename'];

        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
}
