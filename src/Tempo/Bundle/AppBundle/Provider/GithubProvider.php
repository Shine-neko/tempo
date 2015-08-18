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

        if (null === $payload) {
            $payload = $request->request->all();
        }

        try {
            return $this->$methodName($payload);
        } catch (\Exception $e) {
            return;
        }
    }

    protected function anyEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity
            ->setCreatedAt(new \DateTime())
            ->setParameters($payload);

        return $activity;
    }

    protected function pushEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity
            ->setMessage(sprintf('Pushed to %s %s',
                str_replace('refs/heads/', '', $payload['ref']),
                $this->getRepository($payload)
            ))
            ->setParameters($payload);

        return $activity;
    }

    protected function pingEvent($payload)
    {
        return $this->anyEvent($payload);
    }

    protected function issuesEvent($payload)
    {
        $activity = new ActivityProvider();
        $activity
            ->setMessage(sprintf('%s issue #%d in %s',
                $payload['action'],
                $payload['issue']['id'],
                $this->getRepository($payload)
            ))
            ->setCreatedAt(new \DateTime($payload['issue']['createdAt']))
            ->setParameters($payload);

        return $activity;
    }

    protected function issueCommentEvent($payload)
    {
        return $this->anyEvent($payload);
    }


    protected function commitCommentEvent($payload)
    {
        return $this->anyEvent($payload);
    }

    protected function pullRequestEvent($payload)
    {
        $createdAt = isset($payload['pullRequest']['createdAt']) ? $payload['pullRequest']['createdAt'] : $payload['pullRequest']['create_at'];

        $activity = new ActivityProvider();
        $activity
            ->setMessage(sprintf('%s pull request #%d %s',$payload['action'], $payload['pullRequest']['number'], $payload['pullRequest']['title']))
            ->setCreatedAt(new \DateTime($createdAt))
            ->setParameters($payload);
        return $activity;
    }

    protected function pullRequestReviewCommentEvent($payload)
    {
        return $this->anyEvent($payload);
    }

    protected function createEvent($payload)
    {
        $branch = str_replace('refs/heads', '', $payload['ref']);
        $activity = new ActivityProvider();
        $activity
            ->setMessage(sprintf('Create branch %s in %', $branch, $this->getRepository($payload)))
            ->setCreatedAt(new \DateTime())
            ->setParameters($payload);
    }

    protected function watchEvent($payload)
    {
        return $this->anyEvent($payload);
    }

    protected function releaseEvent($payload)
    {
        return $this->anyEvent($payload);
    }

    protected function teamAddEvent($payload)
    {
        return $this->anyEvent($payload);
    }

    protected function deleteEvent($payload)
    {
        $branch = str_replace('refs/heads', '', $payload['ref']);

        $activity = new ActivityProvider();
        $activity
            ->setMessage(sprintf('Deleted branch %s in %s', $branch, $this->getRepository($payload)))
            ->setCreatedAt(new \DateTime())
            ->setParameters($payload);

        return $activity;
    }

    protected function statusEvent($payload)
    {
        throw new \Exception(sprintf('Not supported: %s::%s', __CLASS__, __FUNCTION__));
    }

    /**
     * @param $payload
     * @return string
     */
    private function getRepository($payload)
    {
        return isset($payload['repository']['html_url']) ? $payload['repository']['html_url'] : $payload['repository']['htmlUrl'];
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

    /**
     * {inheritedDoc}
     */
    public function getDescription()
    {
        return 'GitHub notifications (commits, pushes, issues, pull requests, and more)';
    }
}
