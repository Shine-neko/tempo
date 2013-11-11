<?php

namespace Tempo\Bundle\ActivityBundle\Entity;

use Tempo\Bundle\ProjectBundle\Entity\ProjectInterface;
use Tempo\Bundle\ActivityBundle\Model\ActivityProviderInterface;

class ActivityProvider implements  ActivityProviderInterface
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
    protected $provider;

    /**
     * @var \DateTime
     *
     */
    protected $created;

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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider()
    {
        return $this->provider;
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
    public function setProject(ProjectInterface $project = null)
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
}