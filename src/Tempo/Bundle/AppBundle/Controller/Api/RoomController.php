<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller\Api;

use Tempo\Bundle\AppBundle\Controller\Controller;

class RoomController extends Controller
{
    /**
     * Get a single room
     */
    public function getRoomAction($slug)
    {
        try {
            $room = $this->getManager('room')->getRepository()->findRoom($slug, $this->getUser()->getId());
        } catch (\Exception $e) {
            throw $this->createNotFoundException();
        }

        return $room;
    }

    public function getRoomsAction()
    {
        $rooms = $this->getManager('room')->getRepository()->findRooms($this->getUser()->getId());

        return $rooms;
    }
}