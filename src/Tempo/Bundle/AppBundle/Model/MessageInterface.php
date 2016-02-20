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

use Sylius\Component\Resource\Model\ResourceInterface;

interface MessageInterface extends ResourceInterface
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
     * @return Message
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
     * @return Message
     */
    public function setUser($user);

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser();

    /**
     * Set createdAt
     *
     * @param  \DateTime   $datetime
     * @return self
     */
    public function setCreatedAt(\DateTime $datetime);

    /**
     * Get createdAt
     *
     * @return \DateTime $datetime
     */
    public function getCreatedAt();

    /**
     * Set updatedAt
     *
     * @param  \DateTime   $datetime
     * @return Message
     */
    public function setUpdatedAt(\DateTime $datetime);

    /**
     * Get updatedAt
     *
     * @return \DateTime $datetime
     */
    public function getUpdatedAt();

    /**
     * @param $room
     */
    public function setRoom($room);

    /**
     * @return $room
     */
    public function getRoom();
}
