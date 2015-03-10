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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Model\UserInterface;

class UserEvent extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Tempo\Bundle\AppBundle\Model\UserInterface
     */
    private $user;

    /**
     * @param Request       $request
     * @param UserInterface $user
     */
    public function __construct(Request $request, UserInterface $user)
    {
        $this->request = $request;
        $this->$user = $user;
    }


    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}
