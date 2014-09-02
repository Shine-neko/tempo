<?php

namespace Tempo\Bundle\AppBundle\Model;

class ProjectProvider implements ProjectProviderInterface
{
    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $appId;

    /**
     * @var string
     *
     */
    protected $secret;

    /**
     * @var string
     *
     */
    protected $token;

    /**
     * @var string
     *
     */
    protected $name;

    /**
     * @var \DateTime
     *
     */
    protected $createdAt;

    /**
     * @var string
     *
     */
    protected $url;

    /**
     * @var Project
     *
     */
    protected $project;

    /**
     * @var
     */
    protected $activities;

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
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

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
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $created)
    {
        $this->createdAt = $created;

        return $this;
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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $activities
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivities()
    {
        return $this->activities;
    }
}
