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

use Tempo\Bundle\AppBundle\Behavior\TimestampTrait;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class Timesheet implements TimesheetInterface
{
    use TimestampTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $project;

    /**
     * @var integer
     */
    protected $user;

    /**
     * @var \DateTime
     */
    protected $workedTime;

    /**
     * @var \DateTime
     */
    protected $workedDate;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var integer
     */
    protected $billable;

    /**
     * @var integer
     */
    protected $state;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->state = 0;
    }

    public function __toString()
    {
        return $this->workedDate;
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
    public function setWorkedTime($time)
    {
        $this->workedTime = $time;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkedTime()
    {
        return $this->workedTime;
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkedDate($time)
    {
        $this->workedDate = $time;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkedDate()
    {
        return $this->workedDate;
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
    public function setBillable($billable)
    {
        $this->billable = $billable;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillable()
    {
        return $this->billable;
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
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
     * Get project
     *
     * @return \Tempo\Bundle\AppBundle\Model\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user
     *
     * @param UserInterface $user
     * @return $this
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }
}
