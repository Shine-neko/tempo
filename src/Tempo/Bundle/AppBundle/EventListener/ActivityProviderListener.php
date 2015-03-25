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
use Tempo\Bundle\AppBundle\Event\ActivityProviderEvent;
use Tempo\Bundle\AppBundle\ElephantIO\Client;
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

        $this->elephantIoClient->send('providerEvent', array(
            'project' => $project
        ));
    }
}
