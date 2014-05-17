<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\ActivityProvider;

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

        return $this->$methodName($payload);
    }

    protected function pushEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage('provider.github.commit');
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    protected function issuesEvent($payload)
    {
        // TODO
        return array();
    }

    protected function issue_commentEvent($payload)
    {
        // TODO
        return array();
    }

    protected function commit_commentEvent($payload)
    {
        // TODO
        return array();
    }

    protected function pull_requestEvent($payload)
    {
        // TODO
        return array();
    }

    protected function pull_request_review_commentEvent($payload)
    {
        // TODO
        return array();
    }

    protected function gollumEvent($payload)
    {
        // TODO
        return array();
    }

    protected function watchEvent($payload)
    {
        // TODO
        return array();
    }

    protected function releaseEvent($payload)
    {
        // TODO
        return array();
    }

    protected function memberEvent($payload)
    {
        // TODO
        return array();
    }

    protected function publicEvent($payload)
    {
        // TODO
        return array();
    }

    protected function team_addEvent($payload)
    {
        // TODO
        return array();
    }

    protected function statusEvent($payload)
    {
        // TODO
        return array();
    }

    public function getName()
    {
        return 'Github';
    }
}
