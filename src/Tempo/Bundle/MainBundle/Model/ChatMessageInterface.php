<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Model;

interface ChatMessageInterface
{
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId();

    /**
     * Set content
     *
     * @param  string      $content
     * @return ChatMessage
     */
    public function setContent($content);

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent();

    /**
     * Set user
     *
     * @param  string      $user
     * @return ChatMessage
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
     * @param  DateTime    $datetime
     * @return ChatMessage
     */
    public function setCreated(\DateTime $datetime);

    /**
     * Get datetime
     *
     * @return date $datetime
     */
    public function getCreated();

    /**
     * @param $room
     */
    public function setRoom($room);

    /**
     * @return $room
     */
    public function getRoom();
}
