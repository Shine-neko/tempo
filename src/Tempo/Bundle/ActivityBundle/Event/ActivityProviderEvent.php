<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

use Tempo\Bundle\ActivityBundle\Model\ActivityProviderInterface;

class ActivityProviderEvent extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Tempo\Bundle\ActivityBundle\Model\ActivityProviderInterface
     */
    private $activityProvider;

    /**
     * @param Request                   $request
     * @param ActivityProviderInterface $activityProvider
     */
    public function __construct(Request $request, $activityProvider)
    {
        $this->request = $request;
        $this->activityProvider = $activityProvider;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ActivityProviderInterface
     */
    public function getActivityProvider()
    {
        return $this->activityProvider;
    }
}
