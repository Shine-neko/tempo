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

use Tempo\Bundle\AppBundle\Manager\DomainManager;
use Tempo\Bundle\AppBundle\Manager\RoomManager;
use Tempo\Bundle\AppBundle\Model\ProjectProvider;
use Sylius\Component\Resource\Event\ResourceEvent;

class ProjectListener
{
    private $roomManager;
    private $providerRegistry;

    /**
     * @param RoomManager $roomManager
     */
    public function __construct(DomainManager $domainManager, RoomManager $roomManager, $providerRegistry)
    {
        $this->domainManager = $domainManager;
        $this->roomManager = $roomManager;
        $this->providerRegistry = $providerRegistry;
    }

    /**
     * @param ResourceEvent $event
     */
    public function createProject(ResourceEvent $event)
    {
        $project = $event->getSubject();

        //create room
        $this->roomManager->create($project->getName(), $project->getMembers());

        foreach($this->providerRegistry->getProviders() as $service) {
            $service = (new ProjectProvider())
                ->setName($service->getName())
            ;
            $this->domainManager->create($service);
        }

        $this->domainManager->flush();
    }
}
