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
     * Add chatMessage
     *
     * @param ChatMessage $chatMessage
     */
    public function addChatMessage(ChatMessage $chatMessage);

    /**
     * Get chatMessages
     *
     * @return ArrayCollection $chatMessages
     */
    public function getChatMessages();

    /**
     * Get a specfic chat message
     *
     * @param  integer     $id
     * @return ChatMessage
     */
    public function getChatMessage($id);

    /**
     * @param mixed $project
     */
    public function setProject($project);

    /**
     * @return mixed
     */
    public function getProject();
}
