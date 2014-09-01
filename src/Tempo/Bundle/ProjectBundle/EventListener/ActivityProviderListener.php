<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\EventListener;

use Tempo\Bundle\MainBundle\Manager\RoomManager;
use Tempo\Bundle\ProjectBundle\Event\ActivityProviderEvent;
use Tempo\Bundle\MainBundle\ElephantIO\Client;
use JMS\Serializer\SerializerInterface;

class ActivityProviderListener
{
    private $roomManager;
    private $serializer;
    private $elephantIoClient;

    /**
     * @param RoomManager         $roomManager
     * @param SerializerInterface $serializer
     * @param Client              $elephantIoClient
     */
    public function __construct(RoomManager $roomManager, SerializerInterface $serializer, Client $elephantIoClient)
    {
        $this->roomManager = $roomManager;
        $this->serializer = $serializer;
        $this->elephantIoClient = $elephantIoClient;
    }

    /**
     * @param ActivityProviderEvent $event
     */
    public function pingActivityRoom(ActivityProviderEvent $event)
    {
        $projectProvider = $event->getActivityProvider();

        $project = $this->serializer->serialize($projectProvider->getProject(), 'json');

        $room = $this->roomManager->findRoomWithProject($projectProvider->getProject());
        $room = $this->serializer->serialize($room, 'json');

        $this->elephantIoClient->send('ProviderEvent', array(
            'room' => $room,
            'project' => $project
        ));
    }
}
