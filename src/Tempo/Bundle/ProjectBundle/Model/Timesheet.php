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

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

abstract class Timesheet implements TimesheetInterface
{

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
    protected $period;

    /**
     * @var \DateTime
     */
    protected $time;

    /**
     * @var integer
     * @param int $created
     */
    protected $created;

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
        return $this->state = 0;
    }


    public function __toString()
    {
        return $this->time;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * {@inheritdoc}
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * {@inheritdoc}
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    }

    /**
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
    }

    /**
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
    }

    /**
     * Get project
     *
     * @return \Tempo\Bundle\ProjectBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user
     *
     * @param integer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
