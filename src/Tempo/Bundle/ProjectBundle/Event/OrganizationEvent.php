<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Event;

use Tempo\Bundle\ProjectBundle\Model\OrganizationInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class OrganizationEvent extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Tempo\Bundle\ProjectBundle\Model\OrganizationInterface
     */
    private $organization;

    /**
     * @param OrganizationInterface $organization
     * @param Request               $request
     */
    public function __construct(Request $request, OrganizationInterface $organization)
    {
        $this->request = $request;
        $this->organization = $organization;
    }

    /**
     * @return OrganizationInterface
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}
