<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Form\Type\ActivityFormType;
use Tempo\Bundle\ProjectBundle\Entity\Project;

class ActivityController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     */
    public function providerAction(Request $request, $id)
    {
        /** @var $manager \Tempo\Bundle\ActivityBundle\Manager\ActivityProviderManager */
        $manager = $this->get('tempo.activity.manager.activity_provider');
        $manager->add($id, $request);
    }

    /**
     * @param $type
     * @param Project $project| null
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($type, Project $project = null)
    {

        if ('all' == $type) {
            $activities = array();

            $lastActivitiesProvider = $this->getDoctrine()->getRepository('TempoActivityBundle:ActivityProvider')->findByProject($project);
            $lastActivitiesInternal = $this->get('tempo.manager.activity')->render('Project');

            foreach($lastActivitiesProvider as $activity) {
                $activities[$activity->getCreated()->getTimestamp()] = $activity;
            }

            foreach($lastActivitiesInternal as $activity) {
                $activities[$activity->getCreatedAt()->getTimestamp()] = $activity;
            }

        } else if('provider' == $type) {
            $activities = $this->getDoctrine()->getRepository('TempoActivityBundle:Activity')->findAllWithProvider();
        } else {
            $activities = $this->get('tempo.manager.activity')->render($type, $this->getUser());
        }

        return $this->render('TempoActivityBundle:Activity:list.html.twig', array(
            'type' => $type,
            'activities' => $activities
        ));
    }

    public function newAction()
    {
        $form = $this->createForm(new ActivityFormType());

        return $this->render('TempoActivityBundle:Activity:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
