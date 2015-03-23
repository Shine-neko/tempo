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
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Event\ActivityProviderEvent;
use Tempo\Bundle\AppBundle\Model\Project;

class ProviderActivityController extends Controller
{
    /**
     * @param Request $request
     * @param Project $project
     * @param $provider
     * @return Response
     * @throws \Exception
     */
    public function providerAction(Request $request, Project $project, $provider)
    {
        if (!$this->isGranted('VIEW', $project)) {
            throw $this->createAccessDeniedException();
        }

        $projectProvider = $this->getManager('project_provider')->find(array(
            'name' => $provider,
            'project' => $project
        ));

        $provider = $this->getProvider($provider);

        $event = new ActivityProviderEvent($request, $projectProvider);
        $this->get('event_dispatcher')->dispatch(TempoAppEvents::ACTIVITY_PROVIDER_CREATE_INITIALIZE, $event);

        $activity = $provider->parse($request);

        $this->getManager('activity_provider')->addActivity($activity, $projectProvider);

        $this->get('event_dispatcher')->dispatch(TempoAppEvents::ACTIVITY_PROVIDER_CREATE_SUCCESS, $event);

        return new Response('success');
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
