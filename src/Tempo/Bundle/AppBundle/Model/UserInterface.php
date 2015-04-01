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
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface UserInterface extends AdvancedUserInterface, \Serializable, TimestampableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug);

    /**
     * @return string $slug
     */
    public function getSlug();

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email);

    /**
     * @return string $email
     */
    public function getEmail();

    /**
     * @param boolean $enabled
     *
     * @return self
     */
    public function setEnabled($enabled);

    /**
     * @return string $salt
     */
    public function getSalt();

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password);

    /**
     * @return string $password
     */
    public function getPassword();

    /**
     * @param string $plainPassword
     *
     * @return self
     */
    public function setPlainPassword($plainPassword);

    /**
     * @return string $plainPassword
     */
    public function getPlainPassword();

    /**
     * @param \DateTime $lastLogin
     *
     * @return self
     */
    public function setLastLogin(\DateTime $lastLogin = null);

    /**
     * @return \DateTime $lastLogin
     */
    public function getLastLogin();

    /**
     * @param string $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken($confirmationToken);

    /**
     * @return string $confirmationToken
     */
    public function getConfirmationToken();

    /**
     * @param \DateTime $passwordRequestedAt
     *
     * @return self
     */
    public function setPasswordRequestedAt(\DateTime $passwordRequestedAt = null);

    /**
     * @return \DateTime $passwordRequestedAt
     */
    public function getPasswordRequestedAt();

    /**
     * @param GroupInterface $group
     *
     * @return boolean
     */
    public function hasGroup(GroupInterface $group);

    /**
     * @param GroupInterface $group
     *
     * @return self
     */
    public function addGroup(GroupInterface $group);

    /**
     * @param GroupInterface $group
     *
     * @return self
     */
    public function removeGroup(GroupInterface $group);

    /**
     * @return GroupInterface[]|ArrayCollection
     */
    public function getGroups();

    /**
     * @param boolean $locked
     *
     * @return self
     */
    public function setLocked($locked);

    /**
     * @return boolean
     */
    public function isLocked();

    /**
     * @param boolean $expired
     *
     * @return self
     */
    public function setExpired($expired);

    /**
     * @return boolean
     */
    public function isExpired();

    /**
     * @param \DateTime $expiredAt
     *
     * @return self
     */
    public function setExpiresAt(\DateTime $expiredAt = null);

    /**
     * @return \DateTime
     */
    public function getExpiresAt();

    /**
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role);

    /**
     * @param string $role
     *
     * @return self
     */
    public function addRole($role);

    /**
     * @param string $role
     *
     * @return self
     */
    public function removeRole($role);

    /**
     * @return string[]|array
     */
    public function getRoles();

    /**
     * @param boolean $expired
     *
     * @return self
     */
    public function setCredentialsExpired($credentialsExpired);

    /**
     * @return boolean
     */
    public function isCredentialsExpired();

    /**
     * @param \DateTime $credentialsExpiredAt
     *
     * @return self
     */
    public function setCredentialsExpireAt(\DateTime $credentialsExpiredAt);

    /**
     * @return \DateTime
     */
    public function getCredentialsExpireAt();

    /**
     * @param string $token
     *
     * @return self
     */
    public function setToken($token);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $locale
     *
     * @return self
     */
    public function setLocale($locale);

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return string
     */
    public function getFullName();

    /**
     * @param string $gender
     *
     * @return self
     */
    public function setGender($gender);

    /**
     * @return string
     */
    public function getGender();

    /**
     * @param string $company
     *
     * @return self
     */
    public function setCompany($company);

    /**
     * @return string
     */
    public function getCompany();

    /**
     * @param string $jobTitle
     *
     * @return self
     */
    public function setJobTitle($jobTitle);

    /**
     * @return string
     */
    public function getJobTitle();

    /**
     * @param string $phone
     *
     * @return self
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $mobilePhone
     *
     * @return self
     */
    public function setMobilePhone($mobilePhone);

    /**
     * @return string
     */
    public function getMobilePhone();

    /**
     * @param string $avatar
     *
     * @return self
     */
    public function setAvatar($avatar);

    /**
     * @param  int    $size
     * @param  string $default
     *
     * @return string
     */
    public function getAvatar($size = 80, $default = 'mm');

    /**
     * @return bool
     */
    public function hasAvatar();

    /**
     * @return string
     */
    public function hasLocalAvatar();

    /**
     * @return string
     */
    public function hasGravatar();

    /**
     * @return mixed
     */
    public function getGravatarUrl();

    /**
     * @param string $skype
     *
     * @return self
     */
    public function setSkype($skype);

    /**
     * @return string
     */
    public function getSkype();

    /**
     * @param int $googleId
     *
     * @return self
     */
    public function setGoogleId($googleId);

    /**
     * @return int
     */
    public function getGoogleId();

    /**
     * @param string $viadeo
     */
    public function setViadeo($viadeo);

    /**
     * @return string $viadeo
     */
    public function getViadeo();

    /**
     * @param string $linkedin
     *
     * @return self
     */
    public function setLinkedin($linkedin);

    /**
     * @return string
     */
    public function getLinkedin();

    /**
     * @param string $twitter
     *
     * @return self
     */
    public function setTwitter($twitter);

    /**
     * @return string
     */
    public function getTwitter();

    /**
     * @return mixed
     */
    public function getOrganizations();

    /**
     * @param Notification[]|ArrayCollection $notifications
     *
     * @return self
     */
    public function setNotifications(ArrayCollection $notifications);

    /**
     * @return Notification[]|ArrayCollection
     */
    public function getNotifications();

    /**
     * @param Notification $notification
     *
     * @return self
     */
    public function addNotification(Notification $notification);

    /**
     * @return self
     */
    public function eraseCredentials();

    /**
     * @return boolean
     */
    public function isSuperAdmin();

    /**
     * @param $boolean
     *
     * @return self
     */
    public function setSuperAdmin($yes);

    /**
     * @param int $ttl
     *
     * @return boolean
     */
    public function isPasswordRequestNonExpired($ttl);

    /**
     * @param string[]|array $roles
     *
     * @return self
     */
    public function setRoles(array $roles);

    /**
     * @return string
     */
    public function generateToken();

}
