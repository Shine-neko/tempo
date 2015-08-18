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

class ScrutinizerProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $eventName = $request->headers->get('X-Scrutinizer-Event');
        $payload = $request->request->all();

        $repository = str_replace('/api/repositories/g/', '', $payload['Links']['repository']['href']);
        $message =  str_replace('.', ' ', $eventName). ' on '.$repository. ' was ' .$payload['build']['status'];

        $activity = new ActivityProvider();
        $activity->setMessage($message);
        $activity->setCreatedAt(new \DateTime($payload['createdAt']));
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    /**
     * {inheritedDoc}
     */
    public function getCanonicalName()
    {
        return 'scrutinizer';
    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'Scrutinizer';
    }

    /**
     * {inheritedDoc}
     */
    public function getDescription()
    {
        return 'Performs advanced static analysis on PHP code';
    }

}
