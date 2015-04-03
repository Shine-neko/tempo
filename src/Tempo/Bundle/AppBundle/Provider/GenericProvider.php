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

class GenericProvider implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        $get = $request->request->all();
        $post = $request->query->all();

        $payload = array_merge($get, $post);
        unset($payload['access_token']);

        $activity = new ActivityProvider();
        $activity->setMessage($payload['message']);
        $activity->setCreatedAt(new \DateTime());
        $activity->setParameters($payload);

        return $activity;
    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'Generic';

    }

    /**
     * {inheritedDoc}
     */
    public function getCanonicalName()
    {
        return 'generic';
    }
}