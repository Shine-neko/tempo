<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ProjectBundle\Entity\ActivityProvider;

class GithubProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $eventName = $request->headers->get('X-Github-Event');
        $payload = $request->request->get('payload');

        $methodName = sprintf('%sEvent', $eventName);

        if (null == $payload) {
            $payload = $request->request->all();
        }

        var_dump($payload); exit;

        try {
            return $this->$methodName($payload);
        } catch (\Exception $e) {
            return $this->pushEvent($payload);
        }
    }

    protected function pushEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage('provider.github.push');
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    protected function pingEvent($payload)
    {
        return $this->pushEvent($payload);
    }

    protected function issuesEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function issue_commentEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function commit_commentEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function pull_requestEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function pull_request_review_commentEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));

    }

    protected function gollumEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function watchEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function releaseEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));

    }

    protected function memberEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function publicEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function team_addEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function statusEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage($payload['description']);
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'Github';
    }

    /**
     * {inheritedDoc}
     */
    public function getCanonicalName()
    {
        return 'github';
    }
}
