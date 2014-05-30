<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Controller\Frontend;

use FOS\RestBundle\Controller\FOSRestController;
use Tempo\Bundle\MainBundle\Entity\Room;

class RoomController extends FOSRestController
{
    /**
     * Get a single Board
     */
    public function getRoomAction(Room $room)
    {
        return $room;
    }

    public function getRoomsAction()
    {
        $data = array();
        $rooms = array(
            'Room1',
            'Room2',
            'Room3'
        );

        foreach ($rooms as $room) {
            $data[] = $room;
        }

        return $data;
    }
}
