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

use Tempo\Bundle\CoreBundle\Controller\BaseController;
use Tempo\Bundle\MainBundle\Entity\Room;

class RoomController extends BaseController
{
    /**
     * Get a single room
     */
    public function getRoomAction($slug)
    {
        try {
            $room = $this->getManager('room')->repository->getRoom($slug, $this->getUser()->getId());
        } catch (\Exception $e) {
            throw $this->createNotFoundException();
        }

        return $room;
    }

    public function getRoomsAction()
    {
        $rooms = $this->getManager('room')->repository->getRooms($this->getUser()->getId());

        return $rooms;
    }
}
