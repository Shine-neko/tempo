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
use Tempo\Bundle\AppBundle\Behavior\AccessTrait;
use Tempo\Bundle\AppBundle\Behavior\TimestampTrait;

class Room implements RoomInterface
{
    use AccessTrait, TimestampTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var integer
     */
    protected $enableChat;

    /**
     * @var integer
     */
    protected $enabled;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     */
    protected $deleteAt;

    /**
     * @var Collection
     */
    protected $members;
    /**
     * @var ProjectInterface
     */
    protected $project;

    /**
     * @var Collection
     */
    protected $chatMessages;

    public function __construct()
    {
        $this->chatMessages = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->enableChat = true;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnableChat()
    {
        return $this->enableChat;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnableChat($enableChat)
    {
        $this->enableChat = $enableChat;
    }

    /**
     * {@inheritdoc}
     */
    public function addChatMessage(ChatMessage $chatMessage)
    {
        $this->chatMessages[] = $chatMessage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChatMessages()
    {
        return $this->chatMessages;
    }

    /**
     * {@inheritdoc}
     */
    public function getChatMessage($id)
    {
        foreach ($this->chatMessages as $message) {
            /** @var ChatMessage $message */
            if ($id == $message->getId()) {
                return $message;
            }
        }

        return;
    }
}
