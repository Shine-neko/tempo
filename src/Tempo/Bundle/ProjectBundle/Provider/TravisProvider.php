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

class TravisProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $payload = $request->request->all();

        $activity = new ActivityProvider();
        $activity->setMessage('Build 1 of '.$payload['repository']['owner_name'].'/'. $payload['repository']['name']. ' '. $payload['status_message']);
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);
    }

    /**
     * {inheritedDoc}
     */
    public function getCanonicalName()
    {
        return 'travis';
    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'Travis';
    }

}