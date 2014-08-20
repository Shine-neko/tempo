<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Model;

class RoomUser extends Team
{
    protected $room;

    public function __construct($room, $user, $createdAt)
    {
        $this->room = $room;
        $this->user = $user;
        $this->createdAt = $createdAt;
    }
}
