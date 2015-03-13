<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Model;

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
     * @param  UserInterface $user
     * @return NotificationInterface
     */
    public function setUser(UserInterface $user);

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser();

    /**
     * Set datetime
     *
     * @param  \DateTime $datetime
     * @return NotificationInterface
     */
    public function setCreatedAt(\DateTime $datetime);

    /**
     * Get datetime
     *
     * @return \DateTime $datetime
     */
    public function getCreatedAt();

    /**
     * Set datetime
     *
     * @param  \DateTime  $state
     * @return NotificationInterface
     */
    public function setState($state);

    /**
     * Get state
     *
     * @return $state
     */
    public function getState();

    /**
     * @param $data
     * @return self
     */
    public function setData($data);

    /**
     * @return string
     */
    public function getData();

    /**
     * Set datetime
     *
     * @param  string $message
     * @return NotificationInterface
     */
    public function setMessage($message);

    /**
     * Get state
     *
     * @return $state
     */
    public function getMessage();
}
