<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Model;

interface NotificationInterface
{
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId();

    /**
     * Set user
     *
     * @param  string                $user
     * @return NotificationInterface
     */
    public function setUser($user);

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser();

    /**
     * Set datetime
     *
     * @param  \DateTime             $datetime
     * @return NotificationInterface
     */
    public function setCreatedAt(\DateTime $datetime);

    /**
     * Get datetime
     *
     * @return date $datetime
     */
    public function getCreatedAt();

    /**
     * Set datetime
     *
     * @param  \DateTime             $datetime
     * @return NotificationInterface
     */
    public function setState($state);

    /**
     * Get state
     *
     * @param $datetime
     * @return $state
     */
    public function getState();

    /**
     * Set Link
     *
     * @param  string                $link
     * @return NotificationInterface
     */
    public function setLink($link);

    /**
     * Get Link
     *
     * @return $link
     */
    public function getLink();

    /**
     * Set datetime
     *
     * @param  string                $message
     * @return NotificationInterface
     */
    public function setMessage($message);

    /**
     * Get state
     *
     * @param string $message
     *                        @return $state
     */
    public function getMessage();
}
