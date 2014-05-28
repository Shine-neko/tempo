<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

class User extends BaseUser implements UserInterface
{
    protected $id;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var int
     */
    protected $googleId;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $jobTitle;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $mobilePhone;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @var string
     */
    protected $skype;

    /**
     * @var string
     */
    protected $viadeo;

    /**
     * @var string
     */
    protected $linkedin;

    /**
     * @var string
     */
    protected $twitter;

    /**
     * @var Collection
     */
    protected $organizations;
    protected $notifications;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->organizations = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        parent::__construct();
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
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->getUsernameCanonical();
    }

    /**
     * {@inheritdoc}
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->firstName .' '. strtoupper($this->lastName);
    }

    /**
     * {@inheritdoc}
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * {@inheritdoc}
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
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
        return (boolean) @fopen($this->getGravatarUrl() . '?d=404', 'r');
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatar($size = 80, $default = 'mm')
    {
        if ($this->avatar) {
            return '/uploads/avatars/' . $this->avatar;
        }

        return $this->getGravatarUrl() . '?s=' . $size . '&d=' . $default;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGravatarUrl()
    {
        return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

    /**
     * {@inheritdoc}
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * {@inheritdoc}
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * {@inheritdoc}
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * {@inheritdoc}
     */
    public function setViadeo($viadeo)
    {
        $this->viadeo = $viadeo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getViadeo()
    {
        return $this->viadeo;
    }

    /**
     * {@inheritdoc}
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addNotification($notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
