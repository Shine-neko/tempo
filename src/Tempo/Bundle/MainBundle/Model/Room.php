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

use Doctrine\Common\Collections\ArrayCollection;

abstract class Room
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    protected $team;

    protected $project;

    /**
     * @var Collection
     */
    protected $chatMessages;

    public function __construct()
    {
        $this->chatMessages = new ArrayCollection();
        $this->team = new ArrayCollection();
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

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }
}
