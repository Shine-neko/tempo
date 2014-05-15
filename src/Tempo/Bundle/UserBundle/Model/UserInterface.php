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
     * @return string
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
     * @return mixed
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

    public function hasAvatar();

    public function hasLocalAvatar();

    public function hasGravatar();

    public function getAvatar($size = 80, $default = 'mm');

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar);

    public function getGravatarUrl();

    /**
     * @param mixed $googleId
     */
    public function setGoogleId($googleId);

    /**
     * @return mixed
     */
    public function getGoogleId();

    /**
     * @param mixed $linkedin
     */
    public function setLinkedin($linkedin);

    /**
     * @return mixed
     */
    public function getLinkedin();
    /**
     * @param mixed $skype
     */
    public function setSkype($skype);

    /**
     * @return mixed
     */
    public function getSkype();

    /**
     * @param mixed $twitter
     */
    public function setTwitter($twitter);

    /**
     * @return mixed
     */
    public function getTwitter();

    /**
     * @param mixed $viadeo
     */
    public function setViadeo($viadeo);

    /**
     * @return mixed
     */
    public function getViadeo();

    public function getGender();

}
