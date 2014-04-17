<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace Tempo\Bundle\ProjectBundle\Controller\Api\Rest;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Tempo\Bundle\ProjectBundle\Entity\Project;
use Tempo\Bundle\ProjectBundle\Entity\Timesheet;
use Tempo\Bundle\ProjectBundle\Form\Type\TimesheetType;

class TimesheetController extends FOSRestController
{
    public function getTimesheetsAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository('TempoProjectBundle:Timesheet')->findAll();
        $data = $this->get('jms_serializer')->serialize($data, 'json');

        return $data;
    }

    public function postPeriodAction(Project $project, Request $request)
    {
        $view = View::create();

        $period = new Timesheet();
        $period->setProject($project);
        $period->setUser($this->getUser());

        $form = $this->createForm(new TimesheetType(), $period);
        $form->submit($request);


        if ($form->isValid()) {
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($period);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($period);

            $request->getSession()->getFlashBag()->set('success', $this->get('translator')->trans('timesheets.success_add', array(), 'TempoProject'));

        } else {
            $view->setData($form);
        }
        return $view;
    }
}