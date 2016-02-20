<?php

namespace Tempo\Bundle\AppBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ProjectProviderInterface extends ResourceInterface
{
    const STATE_ACTIVE = 'on';
    const STATE_UNACTIVE = 'off';

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Get appId.
     *
     * @return int
     */
    public function getAppId();

    /**
     * Set appId.
     *
     * @return int
     */
    public function setAppId($appId);

    /**
     * Get secret.
     *
     * @return int
     */
    public function getSecret();

    /**
     * Set secret.
     *
     * @return int
     */
    public function setSecret($secret);

    /**
     * Get Token.
     *
     * @return int
     */
    public function getToken();

    /**
     * Set Token.
     *
     * @return int
     */
    public function setToken($secret);

    /**
     * Set provider.
     *
     * @param string $name
     *
     * @return ActivityProvider
     */
    public function setName($name);

    /**
     * Get provider.
     *
     * @return string
     */
    public function getName();

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return ActivityProvider
     */
    public function setUrl($url);

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set project.
     *
     * @param ProjectInterface $project
     *
     * @return ActivityProvider
     */
    public function setProject(ProjectInterface $project);

    /**
     * Get project.
     *
     * @return Project
     */
    public function getProject();

    /**
     * Set datetime.
     *
     * @param \DateTime $createdAt
     *
     * @return ActivityProvider
     */
    public function setCreatedAt(\Datetime $createdAt);

    /**
     * Get datetime.
     *
     * @return \DateTime
     */
    public function getCreatedAt();
}
