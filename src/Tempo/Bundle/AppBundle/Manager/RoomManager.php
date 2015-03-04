<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Tempo\Bundle\AppBundle\Model\Room;
/**
 *
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class RoomManager extends ModelManager
{
    public function create($name, $project)
    {
        $room = new Room();
        $room->setName($name);
        $room->setProject($project);

        return $this->save($room);
    }

    public function findRoomWithProject($project)
    {
        return $this->getRepository()->findRoomWithProject($project);
    }
}
