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
use Tempo\Bundle\AppBundle\Manager\RoomManager;
use Sylius\Component\Resource\Event\ResourceEvent;

class OrganizationListener
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
    public function createOrganization(ResourceEvent $event)
    {
        $organization = $event->getSubject();

        $this->roomManager->create($organization->getName(), $organization->getMembers());
        $this->domainManager->flush();
    }
}
