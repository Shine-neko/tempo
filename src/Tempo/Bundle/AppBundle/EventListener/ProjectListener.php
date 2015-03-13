<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\EventListener;

use Tempo\Bundle\AppBundle\Manager\RoomManager;
use Tempo\Bundle\AppBundle\Model\AccessInterface;
use Sylius\Component\Resource\Event\ResourceEvent;

class ProjectListener
{
    private $roomManager;

    /**
     * @param RoomManager $roomManager
     */
    public function __construct(RoomManager $roomManager)
    {
        $this->roomManager = $roomManager;
    }

    /**
     * @param ResourceEvent $event
     */
    public function createProject(ResourceEvent $event)
    {
        $project = $event->getSubject();

        //create room
        $room = $this->roomManager->create($project->getName(), $project->getMembers());
    }
}
