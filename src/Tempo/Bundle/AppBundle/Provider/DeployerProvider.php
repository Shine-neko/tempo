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

class DeployerProvider implements ProviderInterface
{
    public function parse(Request $request)
    {
        $request->headers->get('X-provider');
        $payload = $request->get('payload');

        if (is_array($payload)) {
            $payload = (object) $payload;
        }

        if (is_string($payload)) {
            $payload = json_decode($payload);
        }

        $activity = new ActivityProvider();
        $activity->setMessage($payload->message);
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