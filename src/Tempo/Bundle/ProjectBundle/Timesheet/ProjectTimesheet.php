<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Timesheet;
use Tempo\Bundle\ProjectBundle\Model\ProjectInterface;

class ProjectTimesheet
{
    /**
     * @var ProjectInterface $project
     */
    private $project;

    /**
     * var array $days
     */
    private $days;

    public function __construct()
    {
        $this->hours = 0;
        $this->days = array();
    }

    /**
     * @param ProjectInterface $project
     * @return $this;
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get Project
     * @return ProjectInterface $project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param ProjectActivityDayTimesheet $day
     *                                         @return $this
     */
    public function addDay(ProjectActivityDayTimesheet $day)
    {
        $this->days[$day->getDay()] = $day;

        return $this;
    }

    /**
     * get Day
     * @param $day
     * @return null
     */
    public function getDay($day)
    {
        if (isset($this->days[$day])) {
            return $this->days[$day];
        }

        return null;
    }

    /**
     * @return Collection $days
     */
    public function getDays()
    {
        return $this->days;
    }
}
