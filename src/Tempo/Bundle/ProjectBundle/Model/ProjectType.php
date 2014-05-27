<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class ProjectType implements ProjectTypeInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection
     */
    protected $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
        $this->name;
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
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * {@inheritdoc}
     */
    public function addProject($project)
    {
        $this->projects[] = $project;

        return $this;
    }
}
