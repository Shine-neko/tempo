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
use Tempo\Bundle\AppBundle\Form\Type\ProviderFormType;
use Tempo\Bundle\AppBundle\Model\Project;
use Tempo\Bundle\AppBundle\Model\ProjectProvider;
use Tempo\Bundle\AppBundle\Model\ProjectProviderInterface;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Event\ActivityProviderEvent;

class ProviderController extends Controller
{
    public function listAction(Project $project)
    {
        $providers = array();

        foreach ($project->getProviders() as $provider) {
            $providers[$provider->getName()] = $provider;
        }

        return $this->render('TempoAppBundle:Provider:list.html.twig', array(
            'host' => $this->container->getParameter('tempo.config.host'),
            'project' => $project,
            'project_activated' => $providers,
            'providers' => $this->get('tempo.activity.provider_registry')->getProviders()
        ));
    }

    public function stateAction(Request $request, Project $project, $provider)
    {
        $state = $request->get('state');
        $provider = $this->getProvider($provider);

        $projectProvider = new ProjectProvider();
        $projectProvider
            ->setName($provider->getCanonicalName())
            ->setProject($project);

        if ('on' === $state) {
            $projectProvider->setState(ProjectProviderInterface::STATE_ACTIVE);
            $this->get('tempo.domain_manager')->create($projectProvider);
        } else {
            $projectProvider->setState(ProjectProviderInterface::STATE_UNACTIVE);
            $this->get('tempo.domain_manager')->update($projectProvider);
        }

        return $this->redirectToRoute('project_settings', array('slug' => $project->getFullSlug()));
    }

    public function updateAction(Request $request, $slug, $provider)
    {
        $projectProvider = $this->getManager('project_provider')->getRepository()->findOneByName($provider);
        $form = $this->createForm(new ProviderFormType(), $projectProvider);

        if ($form->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->update($projectProvider);

            return $this->redirectToRoute('project_show', array(
                'slug' => $slug,
            ));
        }

        return $this->render('TempoAppBundle:Provider:update.html.twig', array(
            'form' => $form->createView(),
            'slug' => $slug,
            'provider' => $provider
        ));
    }

    /**
     * @param Request $request
     * @param Project $project
     * @param $provider
     * @return Response
     * @throws \Exception
     */
    public function notifyAction(Request $request, Project $project, $provider)
    {
        if (!$this->isGranted('VIEW', $project)) {
            throw $this->createAccessDeniedException();
        }

        $projectProvider = $this->getManager('project_provider')->getRepository()->findOneBy(array(
            'name' => $provider,
            'project' => $project
        ));

        if (!$projectProvider) {
            throw $this->createNotFoundException('Project provider not found');
        }

        $provider = $this->getProvider($provider);

        $event = new ActivityProviderEvent($request, $projectProvider);
        $this->get('event_dispatcher')->dispatch(TempoAppEvents::ACTIVITY_PROVIDER_CREATE_INITIALIZE, $event);

        $activity = $provider->parse($request);
        $activity->setHeaders($request->header->all());

        $this->getManager('activity_provider')->addActivity($activity, $projectProvider);

        $this->get('event_dispatcher')->dispatch(TempoAppEvents::ACTIVITY_PROVIDER_CREATE_SUCCESS, $event);
        $this->get('logger')->info('register an activity', array('project' => $project));

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
