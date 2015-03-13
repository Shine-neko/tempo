<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Event;

use Tempo\Bundle\AppBundle\Model\Organization;
use Tempo\Bundle\AppBundle\Model\Project;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Model\User;

class AccessEvent extends Event
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $type;

    /**
     * @var object
     */
    private $subject;

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
     * @param Organization|Project $subject
     * @param User                 $userTo
     * @param User                 $userFrom
     */
    public function __construct(Request $request, $subject, User $userTo, User $userFrom)
    {
        $this->request = $request;
        $this->subject = $subject;
        $this->userTo = $userTo;
        $this->userFrom = $userFrom;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param $type
     * @return self
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
    public function getSubject()
    {
        return $this->subject;
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
