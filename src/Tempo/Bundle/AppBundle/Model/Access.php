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
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     * @return self
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @param $source
     * @return self
     */
    function setSource($source)
    {
        $className = (new \ReflectionClass($source))->getShortName();
        $this->{'set'.$className}($source);
        $this->source = $className;

        return $this;
    }

    /**
     * @param \DateTime $createdAt
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
     * @param User $user
     * @return self
     */
    public function setUser(User $user)
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
     * @param Project $project
     * @return Project
     */
    public function setProject(Project $project)
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
     * @param Room $room
     * @return self
     */
    public function setRoom(Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @param $room
     * @return Room
     */
    public function getRoom($room)
    {
        return $this->room;
    }
}
