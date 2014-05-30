<?php

namespace Tempo\Bundle\ProjectBundle\Model;

use Tempo\Bundle\ProjectBundle\Model\ProjectInterface;

interface ProjectProviderInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get appId
     *
     * @return integer
     */
    public function getAppId();

    /**
     * Set appId
     *
     * @return integer
     */
    public function setAppId($appId);

    /**
     * Get secret
     *
     * @return integer
     */
    public function getSecret();

    /**
     * Set secret
     *
     * @return integer
     */
    public function setSecret($secret);

    /**
     * Get Token
     *
     * @return integer
     */
    public function getToken();

    /**
     * Set Token
     *
     * @return integer
     */
    public function setToken($secret);

    /**
     * Set provider
     *
     * @param string $names
     * @return ActivityProvider
     */
    public function setName($name);

    /**
     * Get provider
     *
     * @return string
     */
    public function getName();

    /**
     * Set url
     *
     * @param string $url
     * @return ActivityProvider
     */
    public function setUrl($url);

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set project
     *
     * @param Project $project
     * @return ActivityProvider
     */
    public function setProject(ProjectInterface $project);

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject();

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return ActivityProvider
     */
    public function setCreatedAt(\Datetime $datetime);

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getCreatedAt();
}
