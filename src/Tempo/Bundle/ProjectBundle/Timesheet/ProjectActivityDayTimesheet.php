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
use Tempo\Bundle\ProjectBundle\Model\TimesheetInterface;

class ProjectActivityDayTimesheet
{
    /**
     * var integer $time
     */
    protected $workedDate = array();

    /**
     * @var integer $day
     */
    protected $day;

    /**
     * @var array
     */
    protected $activities;

    public function __construct($day)
    {
        $this->day = $day;
        $this->workedTime = 0;
        $this->activities = array();
    }

    /**
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param integer $time
     */
    public function addTime($time)
    {
        $this->workedTime = $this->workedTime + $time;
    }

    /**
     * @return integer $workedDate
     */
    public function getTime()
    {
        return $this->workedTime;
    }

    /**
     * @param TimesheetInterface $activity
     * @return $this
     */
    public function addActivity(TimesheetInterface $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * @return array
     */
    public function getActivities()
    {
        return $this->activities;
    }
}
