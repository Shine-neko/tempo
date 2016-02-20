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
use Tempo\Bundle\AppBundle\Behavior\TimestampTrait;
use Tempo\Bundle\AppBundle\Behavior\EnabledTrait;

class User implements UserInterface
{
    use TimestampTrait, EnabledTrait;

    const AVATAR_DEFAULT  = '/bundles/tempoapp/images/avatar-defaut.png';

    /** @var int */
    protected $id;

    /** @var string */
    protected $username;

    /** @var string */
    protected $slug;

    /** @var string */
    protected $email;
    
    /** @var UserEmail[]|ArrayCollection */
    protected $emails;

    /** @var string */
    protected $salt;

    /** @var string */
    protected $password;

    /** @var string */
    protected $plainPassword;

    /** @var \DateTime */
    protected $lastLogin;

    /** @var string */
    protected $confirmationToken;

    /** @var \DateTime */
    protected $passwordRequestedAt;

    /** @var bool */
    protected $locked;

    /** @var bool */
    protected $expired;

    /** @var \DateTime */
    protected $expiresAt;

    /** @var array */
    protected $roles;

    /** @var bool */
    protected $credentialsExpired;

    /** @var \DateTime */
    protected $credentialsExpireAt;

    /** @var string */
    protected $token;

    /** @var string */
    protected $locale;

    /** @var string */
    protected $timeZone;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $gender;

    /** @var string */
    protected $company;

    /** @var string */
    protected $jobTitle;

    /** @var string */
    protected $phones;

    /** @var string */
    protected $avatar;

    /** @var string */
    protected $skype;

    /** @var int */
    protected $googleId;

    /** @var string */
    protected $viadeo;

    /** @var string */
    protected $linkedin;

    /** @var string */
    protected $twitter;

    /** @var Organization[]|ArrayCollection */
    protected $organizations;

    /** @var Notification[]|ArrayCollection */
    protected $notifications;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->organizations = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->emails = new ArrayCollection();

        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->enabled = false;
        $this->locked = false;
        $this->expired = false;
        $this->roles = array();
        $this->credentialsExpired = false;
        $this->avatar = self::AVATAR_DEFAULT;
    }

    public function __toString()
    {
        return (string) $this->getUsername();
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
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getEmails()
    {
        return $this->emails;
    }
    
    public function addEmail(UserEmail $email)
    {
        if($this->emails->count() == 0){
            $email->setMain(true);
        }
        $this->emails[] = $email;
        
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
    public function setEmail($email)
    {
        @trigger_error('The'.__METHOD__.' method is deprecated since version 0.5 and will be removed in 0.6');
        
        $this->addEmail(new UserEmail($email));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($boolean)
    {
        $this->enabled = (boolean) $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordRequestedAt(\DateTime $passwordRequestedAt = null)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocked($boolean)
    {
        $this->locked = $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isLocked()
    {
        return !$this->isAccountNonLocked();
    }

    /**
     * {@inheritdoc}
     */
    public function setExpired($boolean)
    {
        $this->expired = $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired()
    {
        return !$this->isAccountNonExpired();
    }

    /**
     * {@inheritdoc}
     */
    public function setExpiresAt(\DateTime $expiredAt = null)
    {
        $this->expiresAt = $expiredAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsExpired()
    {
        return !$this->isCredentialsNonExpired();
    }

    /**
     * {@inheritdoc}
     */
    public function setCredentialsExpireAt(\DateTime $credentialsExpiredAt = null)
    {
        $this->credentialsExpireAt = $credentialsExpiredAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->token;
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
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeZone()
    {
        return $this->timeZone;
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
        $fullName = $this->firstName.' '.strtoupper($this->lastName);
        return empty($fullName) ? $this->username : $fullName;
    }

    /**
     * {@inheritdoc}
     */
    public function setGender($gender)
    {
        return $this->gender;
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
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
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

    public function addPhone($phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
        return $this->phones;
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
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatar()
    {
        if(null === $this->avatar ) {
            return self::AVATAR_DEFAULT;
        }

        if (strpos($this->avatar, 'http') === false && strpos($this->avatar, 'bundle') === false ) {
            return '/uploads/avatars/'.$this->avatar;
        }

        return $this->avatar;
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
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * {@inheritdoc}
     */
    public function setNotifications(ArrayCollection $notifications)
    {
        $this->notifications = $notifications;

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
    public function addNotification(NotificationInterface $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(static::ROLE_SUPER_ADMIN);
    }

    /**
     * {@inheritdoc}
     */
    public function setSuperAdmin($yes)
    {
        if ($yes) {
            $this->addRole(static::ROLE_SUPER_ADMIN);
        } else {
            $this->removeRole(static::ROLE_SUPER_ADMIN);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordRequestNonExpired($ttl)
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
        $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * {@inheritdoc}
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();
        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function generateToken()
    {
        return base_convert(bin2hex(hash('sha256', uniqid(mt_rand(), true), true)), 16, 36);
    }

    public function isAccountNonExpired()
    {
        if (true === $this->expired) {
            return false;
        }
        if (null !== $this->expiresAt && $this->expiresAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    public function isCredentialsNonExpired()
    {
        if (true === $this->credentialsExpired) {
            return false;
        }
        if (null !== $this->credentialsExpireAt && $this->credentialsExpireAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    /**
     * Serializes the user.
     *
     * The serialized data have to contain the fields used by the equals method and the username.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->password,
            $this->salt,
            $this->slug,
            $this->username,
            $this->avatar,
            $this->expired,
            $this->locked,
            $this->credentialsExpired,
            $this->enabled,
            $this->id,
        ));
    }

    /**
     * Unserializes the user.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        // add a few extra elements in the array to ensure that we have enough keys when unserializing
        // older data which does not include all properties.
        $data = array_merge($data, array_fill(0, 2, null));
        list(
            $this->password,
            $this->salt,
            $this->slug,
            $this->username,
            $this->avatar,
            $this->expired,
            $this->locked,
            $this->credentialsExpired,
            $this->enabled,
            $this->id
            ) = $data;
    }
}
