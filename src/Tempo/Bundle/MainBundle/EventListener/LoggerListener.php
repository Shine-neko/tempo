<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\EventListener;

use Gedmo\Loggable\LoggableListener as BaseLoggableListener;

/**
 * LoggableListener
 *
 * @author Mlanawo Mbechezi <mlanawo>
 */
class LoggerListener extends BaseLoggableListener
{
    protected $user;

    public function setUsername($username)
    {
        parent::setUsername($username);
        $this->user = $username->getUser();

    }

    protected function prePersistLogEntry($logEntry, $object)
    {
        $logEntry->setUser($this->user);
    }
}
