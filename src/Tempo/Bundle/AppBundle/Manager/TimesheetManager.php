<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Tempo\Bundle\AppBundle\Timesheet\ProjectTimesheet;
use Tempo\Bundle\AppBundle\Timesheet\ProjectActivityDayTimesheet;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class TimesheetManager extends BaseManager
{
    /**
     * @param $user
     * @param $weekBegin
     * @param $weekEnd
     */
    public function findActivities($user, $weekBegin, $weekEnd)
    {
        return $this->getRepository()->findActivities($user, $weekBegin, $weekEnd);
    }

    /**
     * @param  $project
     * @param  \DateTime $date
     * @return array
     */
    public function findByPeriod($project, \DateTime $date)
    {
        return $this->getRepository()->findBy(array(
            'project' => $project,
            'workedDate' => $date
        ));
    }

    /**
     * @param $activitiesReport
     * @param $projectsList
     * @return array
     */
     public function getActivitiesForPeriod($activitiesReport, $projectsList)
     {
        $data = array( );
        $activities = array();

         foreach ($projectsList as $projectData) {
             $projectTimesheet = new ProjectTimesheet();
             $projectTimesheet->setProject($projectData);
             $data[$projectTimesheet->getProject()->getId()] = $projectTimesheet;
         }

         foreach ($activitiesReport as $activity) {
             $day  = $activity->getWorkedDate()->format('j');
             $project = $activity->getProject()->getId();

             if (!isset($activities[$project])) {
                 $activities[$project] = new ProjectActivityDayTimesheet($day);
             }

              $activities[$project]
                 ->addActivity($activity)
                 ->addTime($activity->getWorkedTime());

         }

         foreach ($activities as $key => $activityDay) {
             $data[$key]->addDay($activityDay);
         }

         return $data;
    }

    /**
     * @param $currentWeek
     * @return array
     */
    public function getDaysInWeek($currentWeek)
    {
        $i = 1;
        foreach ($currentWeek as $day) {
            $this->daysInWeek[$i] = $day;
            $i++;
        }

        return $this->daysInWeek;
    }

    /**
     * @param $workDay
     * @param $daysInWeek
     * @return array
     */
    public function getWorkday($workDay, $daysInWeek)
    {
        foreach ($workDay as $key => $week) {
            $key++;
            $this->workday[$key] = $week . ' ' . $daysInWeek[$key]->format('d');
        }

        return $this->workday;
    }
}
