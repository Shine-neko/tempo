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
use Tempo\Bundle\AppBundle\Behavior\EnabledTrait;

class Room implements RoomInterface
{
    use AccessTrait, TimestampTrait, EnabledTrait;

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
     * @var Collections
     */
    protected $members;
    /**
     * @var ProjectInterface
     */
    protected $project;

    /**
     * @var Collection
     */
    protected $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->members = new ArrayCollection();
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
    public function addMessage(MessageInterface $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage($id)
    {
        foreach ($this->messages as $message) {
            /** @var Message $message */
            if ($id == $message->getId()) {
                return $message;
            }
        }

        return;
    }

    public function __toString()
    {
        return $this->name;
    }
}
