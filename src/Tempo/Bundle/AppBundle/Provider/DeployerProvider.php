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

class DeployProvider implements ProviderInterface
{
    public function parse(Request $request)
    {
        $request->headers->get('X-provider');
        $payload = $request->request->get('data');

        $activity = new ActivityProvider();
        $activity->setMessage('Branch '.$payload['release']['branch'].' (at '.$payload['release']['sha'].') deployed as release '.$payload['release']['name'].' by '.$payload['author']['name']);
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    public function getName()
    {
        return 'Deployer';
    }

    public function getCanonicalName()
    {
        return 'deployer';
    }
}