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

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface UserInterface extends BaseUserInterface, TimestampableInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get token
     *
     * @return string
     */
    public function setToken($token);

    /**
     * Set token
     *
     * @param string $token
     */
    public function getToken();

    /**
     * get local
     *
     * @return string $locale
     */
    public function getLocale();

    /**
     * @param string $locale
     */
    public function setLocale($locale);

    /**
     * Alias for parent::getUsernameCanonical()
     * @param $slug
     * @return string $slug
     */
    public function getSlug();

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set firstname.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * @return mixed
     */
    public function getCompany();

    /**
     * @param string $compagny
     */
    public function setCompany($company);

    /**
     * @return mixed
     */
    public function getOrganizations();

    /**
     * Set job_title
     *
     * @param string $jobTitle
     */
    public function setJobTitle($jobTitle);

    /**
     * Get job_title
     *
     * @return string
     */
    public function getJobTitle();

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set mobile Phone
     *
     * @param string $mobilePhone
     */
    public function setMobilePhone($mobilePhone);

    /**
     * Get mobile Phone
     *
     * @return string
     */
    public function getMobilePhone();

    /**
     * Get at avatar
     *
     * @return string
     */
    public function hasAvatar();

    /**
     * Get at avatar
     *
     * @return string
     */
    public function hasLocalAvatar();

    /**
     * Get at gravatar
     *
     * @return string
     */
    public function hasGravatar();

    /**
     * @param  int    $size
     * @param  string $default
     * @return string $avatar
     */
    public function getAvatar($size = 80, $default = 'mm');

    /**
     * Set avatar url
     *
     * @param string $avatar
     */
    public function setAvatar($avatar);

    /**
     * get Gravatar url
     *
     * @return mixed
     */
    public function getGravatarUrl();

    /**
     * Set Google ID
     *
     * @param int $googleId
     */
    public function setGoogleId($googleId);

    /**
     * Get Google ID
     *
     * @return int $googleId
     */
    public function getGoogleId();

    /**
     * set Linkedin ID
     *
     * @param string $linkedin
     */
    public function setLinkedin($linkedin);

    /**
     * Get Linkedin ID
     *
     * @return string $linkedin
     */
    public function getLinkedin();

    /**
     * Set Skype ID
     *
     * @param string $skype
     */
    public function setSkype($skype);

    /**
     * @return string $skype
     */
    public function getSkype();

    /**
     * Set Twitter ID
     *
     * @param string $twitter
     */
    public function setTwitter($twitter);

    /**
     * Get Twitter ID
     *
     * @return string $twitter
     */
    public function getTwitter();

    /**
     * Set Viadeo ID
     *
     * @param string $viadeo
     */
    public function setViadeo($viadeo);

    /**
     * Get Viadeo ID
     *
     * @return string $viadeo
     */
    public function getViadeo();

    /**
     * @return int $gender
     */
    public function getGender();

}
