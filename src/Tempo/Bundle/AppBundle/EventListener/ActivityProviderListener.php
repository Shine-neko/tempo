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

use Tempo\Bundle\ResourceExtraBundle\Manager\DomainManager;
use Tempo\Bundle\AppBundle\Event\ActivityProviderEvent;
use Tempo\Bundle\AppBundle\ElephantIO\Client;
use JMS\Serializer\SerializerInterface;

class ActivityProviderListener
{
    /**
     * @var DomainManager
     */
    private $domainManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Client
     */
    private $elephantIoClient;

    /**
     * @param domainManager       $domainManager
     * @param SerializerInterface $serializer
     * @param Client              $elephantIoClient
     */
    public function __construct(DomainManager $domainManager, SerializerInterface $serializer, Client $elephantIoClient)
    {
        $this->domainManager = $domainManager;
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
