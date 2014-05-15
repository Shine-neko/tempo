<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Manager;

use Tempo\Bundle\UserBundle\Entity\Notification;
use Tempo\Bundle\CoreBundle\Manager\BaseManager;

/**
 *
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class NotificationManager extends BaseManager
{

    public function findAllByUserAndState($user, $state)
    {
        return $this->repository->findAllByUserAndState($user, $state);
    }

    public function create($user, $message, $link)
    {
        $room = new Notification();
        $room->setUser($user);
        $room->setLink($link);
        $room->setMessage($message);

        $this->save($room);
    }

    public function clearForUser($user)
    {
        $this->$this->repository->clearForUser($user);
    }
}