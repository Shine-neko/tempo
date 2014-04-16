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

interface TimesheetInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param \DateTime $time
     */
    public function getPeriod();

    /**
     * @return \DateTime
     */
    public function getTime();

    /**
     * Set Date
     *
     * @param \DateTime $datetime
     */
    public function setCreated(\DateTime $datetime);

    /**
     * Set time
     *
     * @param \DateTime $time
     */
    public function setTime($time);

    /**
     * @param \DateTime $time
     */
    public function setPeriod($time);

    /**
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * Set state.
     *
     * @param integer $state
     */
    public function setState($state);

    /**
     * Get state.
     *
     * @return integer
     */
    public function getState();

    /**
     * @param boolean $billable
     */
    public function setBillable($billable);

    /**
     * @return Boolean
     */
    public function getBillable();

    /**
     * @return \Tempo\Bundle\ProjectBundle\Model\Project
     */
    public function getProject();

    /**
     * @param integer $user
     */
    public function setUser($user);

    /**
     * @return integer
     */
    public function getUser();

    /**
     * @param ProjectInterface $project
     */
    public function setProject(ProjectInterface $project);
}