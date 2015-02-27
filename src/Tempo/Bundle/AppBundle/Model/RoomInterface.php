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
     * Get has enable chat
     */
    public function getEnableChat();

    /**
     * @param $enableChat
     * @return self
     */
    public function setEnableChat($enableChat);

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
     * @param ProjectInterface $project
     * @return self
     */
    public function setProject(ProjectInterface $project = null);

    /**
     * @return mixed
     */
    public function getProject();
}
