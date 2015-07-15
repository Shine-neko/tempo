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

class Access implements AccessInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $inviteEmail;

    /**
     * @var string
     */
    protected $inviteToken;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var Organization
     */
    protected $organization;

    /**
     * @var Room
     */
    protected $room;

    /**
     * @var \DateTime
     */
    protected $createdAt;
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $source
     *
     * @return self
     */
    public function setSource($source)
    {
        $className = (new \ReflectionClass($source))->getShortName();
        $this->{'set'.$className}($source);
        $this->source = $className;

        return $this;
    }

    public function getResource()
    {
        if (null !== $this->project) {
            return $this->project;
        }
        if (null !== $this->organization) {
            return $this->organization;
        }
        if (null !== $this->room) {
            return $this->room;
        }
    }
    /**
     * @return string
     */
    public function getInviteToken()
    {
        return $this->inviteToken;
    }

    /**
     * @param type $inviteToken
     *
     * @return self
     */
    public function setInviteToken($inviteToken)
    {
        $this->inviteToken = $inviteToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getInviteEmail()
    {
        return $this->inviteEmail;
    }

    /**
     * @param type $inviteEmail
     *
     * @return self
     */
    public function setInviteEmail($inviteEmail)
    {
        $this->inviteEmail = $inviteEmail;

        return $this;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param UserInterface $user
     *
     * @return self
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param OrganizationInterface $organization
     *
     * @return self
     */
    public function setOrganization(OrganizationInterface $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @param ProjectInterface $project
     *
     * @return self
     */
    public function setProject(ProjectInterface $project = null)
    {
        $this->project = $project;

        return $project;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param RoomInterface $room
     *
     * @return self
     */
    public function setRoom(RoomInterface $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }
}
