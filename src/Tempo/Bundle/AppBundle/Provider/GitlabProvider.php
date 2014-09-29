<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Model\ActivityProvider;
use Doctrine\Common\Inflector\Inflector;

class GitlabProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        if ($request->request->has('object_kind')) {
            $methodName = sprintf('%sEvent', Inflector::camelize($request->request->get('object_kind')));
            return $this->$methodName($request->request->all()['object_attributes']);
        }

        return $this->pushEvent($request->request->all());
    }

    public function pushEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage('Pushed to '. str_replace('refs/heads/', '', $payload['ref']). ' '.$payload['repository']['name']);
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    public function mergeRequest($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage('Opened pull request #'.$payload['pull_request']['number']. ' '. $payload['pull_request']['title']);
        $activity->setCreatedAt($payload['created_at']);
        $activity->setParameters($payload);

        return $activity;
    }

    public function issueEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage($payload['action']. ' issue '. $payload['title']);
        $activity->setCreatedAt($payload['created_at']);
        $activity->setParameters($payload);

        return $activity;
    }

    /**
     * {inheritedDoc}
     */
    public function getCanonicalName()
    {
        return 'gitlab';
    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'GitLab';
    }

}
