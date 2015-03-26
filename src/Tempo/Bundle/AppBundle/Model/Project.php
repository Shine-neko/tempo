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
use Tempo\Bundle\AppBundle\Behavior\AccessTrait;
use Tempo\Bundle\AppBundle\Behavior\TimestampTrait;

/**
 * Project Model
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class Project implements ProjectInterface
{
    use AccessTrait, TimestampTrait;

    const STATUS_CREATED = 10;
    const STATUS_OPENING = 20;
    const STATUS_FINISHED = 50;
    const STATUS_DELETED = -10;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Boolean
     */
    protected $active;

    /**
     * @var string
     */
    protected $organization;

    /**
     * @var integer
     */
    protected $parent;

    /**
     * @var Collection
     */
    protected $children;

    /**
     * @var Collection
     */
    protected $timesheets;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     */
    protected $lastActivity;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var \DateTime
     */
    protected $beginning;

    /**
     * @var \DateTime
     */
    protected $ending;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @var integer
     */
    protected $advancement;

    /**
     * @var integer
     */
    protected $priority;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var integer
     */
    protected $budget_estimated;

    /**
     * @var integer
     */
    protected $parents;

    /**
     * @var Collection
     */
    protected $providers;

    /**
     * @var Collection
     */
    protected $comments;

    /**
     * @var Collection
     */
    protected $members;

    public function __construct()
    {
        $this->active = true;
        $this->advancement = 0;
        $this->timesheets = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->providers = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->getName();
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
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * return full slug({organization}/{project})
     */
    public function getFullSlug()
    {
        return $this->organization->getSlug() . '/' . $this->slug ;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastActivity(\DateTime $lastActivity)
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrganization(OrganizationInterface $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setActive($isActive)
    {
        $this->active = $isActive;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     */
    public function setBeginning(\DateTime $beginning)
    {
        $this->beginning = $beginning;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBeginning()
    {
        return $this->beginning;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnding(\DateTime $ending)
    {
        $this->ending = $ending;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnding()
    {
        return $this->ending;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(ProjectTypeInterface $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function addTimesheet(TimesheetInterface $timesheet)
    {
        $this->timesheets[] = $timesheet;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimesheets($timesheets)
    {
        $this->timesheets = $timesheets;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimesheets()
    {
        return $this->timesheets;
    }

    /**
     * {@inheritdoc}
     */
    public function addChildren(ProjectInterface $children)
    {
        $this->children[] = $children;

        $children->setParent($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(ProjectInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent($level = -1)
    {
        if (-1 === $level) {
            return $this->parent;
        }

        $parents = $this->getParents();

        if ($level < 0) {
            $level = count($parents) + $level;
        }

        return isset($parents[$level]) ? $parents[$level] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getParents()
    {
        if (!$this->parents) {
            $project    = $this;
            $parents = array();

            while ($project->getParent()) {
                $project      = $project->getParent();
                $parents[] = $project;
            }

            $this->setParents(array_reverse($parents));
        }

        return $this->parents;
    }

    /**
     * {@inheritdoc}
     */
    public function addProvider(ProjectProviderInterface $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * {@inheritdoc}
     */
    public function setProviders($provider)
    {
        $this->providers = $provider;

        return $this;
    }
}
