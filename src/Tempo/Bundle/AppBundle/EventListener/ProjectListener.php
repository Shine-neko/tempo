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

use Tempo\Bundle\AppBundle\Event\ProjectEvent;
use Tempo\Bundle\AppBundle\Manager\RoomManager;
use Tempo\Bundle\AppBundle\Model\AccessInterface;

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
     * @param ProjectEvent $event
     */
    public function createProject($event)
    {
        $project = $event->getSubject();

        //create room
        $room = $this->roomManager->create($project->getName(), $project);

        foreach($project->getMembers() as $user) {
            $room->addAccess($user->getUser(), AccessInterface::TYPE_OWNER);
        }

        $this->roomManager->save($room);
    }
}
