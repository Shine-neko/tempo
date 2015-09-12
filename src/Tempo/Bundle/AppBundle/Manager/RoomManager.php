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
use Tempo\Bundle\AppBundle\Model\AccessInterface;
use Tempo\Bundle\ResourceExtraBundle\Manager\ModelManager;

/**
 *
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class RoomManager extends ModelManager
{
    public function create($name, $members)
    {
        $room = new Room();
        $room->setName($name);

        foreach($members as $user) {
            $room->addAccess($user->getUser(), AccessInterface::TYPE_OWNER);
        }

        return $this->save($room);
    }
}
