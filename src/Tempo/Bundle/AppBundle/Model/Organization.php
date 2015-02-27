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

/**
* @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
*/
class Organization implements OrganizationInterface
{
    use AccessTrait, TimestampTrait;

    /**
     * @var integer $id
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
     * @var string
     */
    protected $avatar;

    /**
     * @var integer
     */
    protected $enabled;

    /**
     * @var integer
     */
    protected $members;

    /**
     * @var string
     */
    protected $contact;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var array
     */
    protected $projects;

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
    protected $deletedAt;

    /**
     * @var ArrayCollection\UserInterface[]
     */
    protected $users;
    protected $team;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
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
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAvatar()
    {
        return $this->hasLocalAvatar() || $this->hasGravatar();
    }

    /**
     * {@inheritdoc}
     */
    public function hasLocalAvatar()
    {
        return (boolean) $this->avatar;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGravatar()
    {
        return (boolean) @fopen($this->getGravatarUrl().'?d=404', 'r');
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatar($size = 80, $default = 'mm')
    {
        if ($this->avatar) {
            return '/uploads/covers/'.$this->avatar;
        }

        return $this->getGravatarUrl().'?s='.$size.'&d='.$default;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    protected function getGravatarUrl()
    {
        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($this->contact)));
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * {@inheritdoc}
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * {@inheritdoc}
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebSite()
    {
        return $this->website;
    }

    /**
     * {@inheritdoc}
     */
    public function addProject($project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setWebSite($website)
    {
        $this->website = $website;

        return $this;
    }
}
