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

class UserEmail implements ResourceInterface
{
    const STATUS_PRIVATE = 'STATUS_PRIVATE';
    const STATUS_PUBLIC = 'STATUS_PUBLIC';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $user;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * @var bool
     */
    protected $main;

    /**
     * @var string
     */
    protected $status;

    public function __construct($email = '')
    {
        $this->createdAt = new \DateTime();
        $this->main = false;
        $this->status = self::STATUS_PRIVATE;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function getMain()
    {
        return $this->main;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    public function isMain()
    {
        return (bool) $this->main;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }
}
