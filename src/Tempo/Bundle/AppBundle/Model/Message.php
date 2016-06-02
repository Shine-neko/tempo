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

use Tempo\Bundle\AppBundle\Behavior\TimestampTrait;
use Sylius\Component\Resource\Model\ResourceInterface;

class Message implements MessageInterface, ResourceInterface
{
    use TimestampTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var collection
     */
    protected $room;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var Object
     */
    protected $user;

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
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoom(RoomInterface $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->content;
    }
}
