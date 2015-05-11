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

class GithubProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $eventName = $request->headers->get('X-Github-Event');
        $payload = $request->request->get('payload');

        $methodName = sprintf('%sEvent', Inflector::camelize($eventName));

        if (null == $payload) {
            $payload = $request->request->all();
        }

        try {
            return  $this->$methodName($payload);
        } catch (\Exception $e) {
            return;
        }
    }

    protected function anyEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage('');
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }


    protected function pushEvent($payload)
    {
        $this->anyEvent($payload);
    }

    protected function pingEvent($payload)
    {
        $this->anyEvent($payload);
    }

    protected function issuesEvent($payload)
    {
        $this->anyEvent($payload);
    }

    protected function issue_commentEvent($payload)
    {
        $this->anyEvent($payload);
    }

    protected function commitCommentEvent($payload)
    {
        $this->anyEvent($payload);
    }

    protected function pullRequestEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity->setMessage('Opened pull request #'.$payload['pull_request']['number']. ' '. $payload['pull_request']['title']);
        $activity->setCreatedAt(new \DateTime($payload['pull_request']['created_at']));
        $activity->setParameters($payload);

        return $activity;
    }

    protected function pullRequestReviewCommentEvent($payload)
    {
        $this->anyEvent($payload);
    }

    protected function watchEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function releaseEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function teamAddEvent($payload)
    {
        throw new \Exception(sprintf('Not implemented: %s::%s', __CLASS__, __FUNCTION__));
    }

    protected function deleteEvent($payload)
    {
        $branch = str_replace('refs/heads/Shine', '', $payload['ref']);
        $repository = isset($payload['repository']['html_url']) ? $payload['repository']['html_url'] : $payload['repository']['htmlUrl'];

        $activity = new ActivityProvider();
        $activity->setMessage('Deleted branch '.$branch.' in '.$repository);
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    protected function statusEvent($payload)
    {
        throw new \Exception(sprintf('Not supported: %s::%s', __CLASS__, __FUNCTION__));
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
