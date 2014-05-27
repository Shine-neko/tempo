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

use Tempo\Bundle\ProjectBundle\Entity\Organization;
use Tempo\Bundle\ProjectBundle\Entity\Project;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\UserBundle\Entity\User;

class TeamEvent extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Object
     */
    private $model;

    /**
     * @var User
     */
    private $userTo;

    /**
     * @var User
     */
    private $userFrom;

    /**
     * @param Request              $request
     * @param Organization|Project $object
     * @param User                 $userTo
     * @param User                 $userFrom
     */
    public function __construct(Request $request, $object, User $userTo, User $userFrom)
    {
        $this->request = $request;
        $this->model = $object;
        $this->userTo = $userTo;
        $this->userFrom = $userFrom;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Object
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $userFrom
     */
    public function setUserFrom($userFrom)
    {
        $this->userFrom = $userFrom;
    }

    /**
     * @return User
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * @param User $userTo
     * @return $this
     */
    public function setUserTo($userTo)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * @return User
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
}
