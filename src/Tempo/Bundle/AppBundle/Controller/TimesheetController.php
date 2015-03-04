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
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use CalendR\Period\Week;

use Tempo\Bundle\AppBundle\Form\Type\TimesheetType;
use Tempo\Bundle\AppBundle\Form\Filter\TimesheetFilterType;
use Tempo\Bundle\AppBundle\Form\Type\TimesheetExportType;
use Tempo\Bundle\AppBundle\Export\Excel as ExportCVS;
use Tempo\Bundle\AppBundle\Model\AccessInterface;
use Tempo\Bundle\AppBundle\Model\Timesheet;

/**
 * Timesheet controller.
 *
 */
class TimesheetController extends Controller
{
    /**
     * Lists all Timesheet entities.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function dashboardAction(Request $request)
    {
        $breadcrumb  = $this->get('tempo.breadcrumb');
        $breadcrumb->addChild('Time Management');
        $breadcrumb->addChild('Dashboard');

        return $this->render('TempoAppBundle:Timesheet:dashboard.html.twig', $this->filterData($request));
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

            return $this->redirectToRoute('timesheet');
        }

        return $this->render('TempoAppBundle:Timesheet:update.html.twig', array(
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

        return $this->redirectToRoute('timesheet');
    }

    public function exportPDFAction(Request $request)
    {
        $form = $this->createForm(new TimesheetExportType(), array(
            'to' => (new \DateTime())->format('Y-m-d')
        ));

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {

            $list = $this->getManager('timesheet')->getRepository()->findAllByUser();

            $html = $this->renderView('TempoAppBundle:Timesheet:export/pdf_tpl.html.twig', array(
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

        return $this->render('TempoAppBundle:Timesheet:export/pdf.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @ParamConverter("end", options={"format": "Y-m-d"})
     * @param  \DateTime $date
     * @return Response
     */
    public function showAction($project, \DateTime $date)
    {
        return $this->render('TempoAppBundle:Timesheet:show.html.twig', array(
            'activities' => $this->getManager('timesheet')->findByPeriod($project, $date)
        ));
    }

    /**
     * @param  Request $request
     * @param  $project
     * @return View
     * @Post()
     */
    public function createAction(Request $request, $project)
    {
        $project = $this->getManager('project')->find($project);
        $request->request->remove('project');

        $view = View::create();

        $period = new Timesheet();
        $period->setProject($project);
        $period->setUser($this->getUser());

        $form = $this->createForm(new TimesheetType(), $period, array(
            'method' => 'POST'
        ));

        if ($form->handleRequest($request)->isValid()) {

            $this->getManager('timesheet')->save($period);
            $view
                ->setStatusCode(201)
                ->setData($period)
                ->setFormat('json');

            $this->addFlash('success', 'tempo.timesheets.success_add');

            if (stripos($request->getRequestUri(), 'api') === false) {
                $view->setFormat('html');
                return $this->redirectToRoute('timesheet');
            }

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

        return $this->render('TempoAppBundle:Timesheet:export/excel.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function validationAction(Request $request)
    {
        $userId = $request->query->get('user_id') ?: $this->getUser();

        if ($request->query->has('validate')) {
            $period = $this->getManager('timesheet')->find($request->query->get('id'));
            if ($request->query->has('type') && $request->query->get('type') == 'billable') {
                $period->setBillable(true);
            }
            $period->setState(3);
            $this->getManager('timesheet')->save($period);
        }

        $assignments = $this->getDoctrine()->getRepository('TempoAppBundle:Access')->findAll(array(
            'role' => AccessInterface::TYPE_OWNER
        ));
        $timesheets = $this->getManager('timesheet')->getRepository()->findActivitiesByState($userId);
        $filterForm = $this->createForm(new TimesheetFilterType());


        return $this->render('TempoAppBundle:Timesheet:validation.html.twig', array(
            'timesheets' => $timesheets,
            'assignments' => $assignments,
            'filterForm' =>  $filterForm->createView()
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
        $workDay = $this->container->getParameter('tempo.week');
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
        $processFilter = $this->processFilter($request, $filterFormType, $factoryWeek);

        $projectsActivityReporting = $this->getManager('timesheet')->findActivities(
            $this->getUser()->getId(), $processFilter['from']->format('Y-m-j'), $processFilter['to']->format('Y-m-j')
        );

        $projectList = $this->getManager('project')->getRepository()->findAllByUser($this->getUser()->getId());

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

    private function processFilter(Request $request, $filterForm, $factoryWeek)
    {
        if ($filterForm->isSubmitted()) {

            if ($filterForm->handleRequest($request)->isValid()) {
                $dataFilter = $filterForm->getData();

                $dataFilter['from'] = new \DateTime($dataFilter['from']);
                $dataFilter['to']  = new \DateTime($dataFilter['to']);
            }
        }

        $dataFilter = array(
            'from' => $factoryWeek->getBegin(),
            'to'   => $factoryWeek->getEnd()
        );

        return $dataFilter;

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
