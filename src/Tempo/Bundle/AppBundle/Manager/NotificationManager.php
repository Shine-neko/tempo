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

use Tempo\Bundle\AppBundle\Model\Notification;
use Tempo\Bundle\ResourceExtraBundle\Manager\ModelManager;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class NotificationManager extends ModelManager
{
    public function getNotifications($user, $state = Notification::STATE_UNREAD)
    {
        return $this->getRepository()->getUserNotifications($user, $state);
    }

    public function create($user, $message, $data)
    {
        return (new Notification())
            ->setUser($user)
            ->setData($data)
            ->setMessage($message);
    }

    public function clearForUser($user)
    {
        return $this->getRepository()->clearForUser($user);
    }
}
