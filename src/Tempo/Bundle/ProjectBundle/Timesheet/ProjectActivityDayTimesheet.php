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
     * var integer $hours
     */
    protected  $time;
    protected $day;

    /**
     * @var Collection
     */
    protected $activities;


    public function __construct($day)
    {
        $this->day = $day;
        $this->time = 0;
        $this->activities = array();
    }

    /**
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    public  function addTime($time)
    {
        $this->time = $this->time + $time;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param $activity
     * @return $this
     */
    public function addActivity(TimesheetInterface $activity)
    {
        $this->activities[$this->day][] = $activity;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getActivities($day)
    {
        return $this->activities[$day];
    }

}