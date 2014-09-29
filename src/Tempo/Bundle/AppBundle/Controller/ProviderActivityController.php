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
use Tempo\Bundle\AppBundle\Form\Type\ActivityFormType;
use Tempo\Bundle\AppBundle\Controller\Controller;
use Tempo\Bundle\AppBundle\Model\Project;
use Tempo\Bundle\AppBundle\TempoProjectEvents;
use Tempo\Bundle\AppBundle\Event\ActivityProviderEvent;

class ProviderActivityController extends Controller
{
    /**
     * @param Request $request
     * @param $token
     */
    public function providerAction(Request $request, $id)
    {
        $manager = $this->getManager('activity_provider');
        $projectProvider = $this->getManager('project_provider')->find($id);
        $provider = $this->getProvider(strtoupper($projectProvider->getName()));

        $event = new ActivityProviderEvent($request, $projectProvider);
        $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ACTIVITY_PROVIDER_CREATE_INITIALIZE, $event);

        $activity = $provider->parse($request);

        $manager->addActivity($activity, $projectProvider);

        $this->get('event_dispatcher')->dispatch(TempoProjectEvents::ACTIVITY_PROVIDER_CREATE_SUCCESS, $event);

        return new Response('ok');
    }

    /**
     * @param $type
     * @param  Project  $project| null
     * @return Response
     */
    public function listAction($type, Project $project = null)
    {
        $activityManager = $this->getManager('activity');

        if ('all' == $type) {
            $lastActivitiesProvider = $this->getManager('activity_provider')->getRepository()->findByProject($project);
            $lastActivitiesInternal = $activityManager->findByUser('Project');

            $activities = array_merge(
                $this->formatActivities($lastActivitiesProvider) ,
                $this->formatActivities($lastActivitiesInternal)
            );

        } elseif ('provider' == $type) {
            $activities = $activityManager->getRepository()->findAllWithProvider();
        } else {
            $activities = $activityManager->findByUser($type, $this->getUser());
        }

        return $this->render('TempoAppBundle:Provider/Activity:list.html.twig', array(
            'type' => $type,
            'activities' => $activities
        ));
    }

    public function newAction()
    {
        $form = $this->createForm(new ActivityFormType());

        return $this->render('TempoAppBundle:Provider/Activity:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $activitiesProvider
     */
    private function formatActivities($activitiesProvider)
    {
        $activities = array();

        foreach ($activitiesProvider as $activity) {
            $activities[$activity->getCreatedAt()->getTimestamp()] = $activity;
        }

        return $activities;
    }

    /**
     * @param $providerName
     * @return \Tempo\Bundle\AppBundle\Provider\ProviderInterface
     * @throws \Exception
     */
    protected function getProvider($providerName)
    {
        $serviceName = sprintf('tempo.activity.provider.%s', $providerName);

        if (!$this->has($serviceName)) {
            throw new \Exception(sprintf('Provider "%s" does not exists', $providerName));
        }

        return $this->get($serviceName);
    }
}
