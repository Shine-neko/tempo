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

class Room
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
     * @var string
     */
    protected $slug;

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
    public function getTeam()
    {
        return $this->team;
    }

    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addUser($user, $role = 'ROLE_USER')
    {
        $this->team[] = new RoomUser($this, $user, $role);
    }

    /**
     * {@inheritdoc}
     */
    public function setProject($project)
    {
        $this->project  = $project;

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
