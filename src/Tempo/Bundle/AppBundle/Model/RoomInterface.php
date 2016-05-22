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

use Doctrine\Common\Collections\ArrayCollection;

interface RoomInterface
{
    /**
     * Get ID
     */
    public function getId();

    /**
     * Get Room name
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return Room
     */
    public function setName($name);

    /**
     * Add message
     *
     * @param MessageInterface $message
     */
    public function addMessage(MessageInterface $message);

    /**
     * Get messages
     *
     * @return ArrayCollection $messages
     */
    public function getMessages();

    /**
     * Get a specfic chat message
     *
     * @param  integer     $id
     * @return Message
     */
    public function getMessage($id);
}
