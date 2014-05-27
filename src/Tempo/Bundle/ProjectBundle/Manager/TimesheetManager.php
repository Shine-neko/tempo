<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\ProjectBundle\Timesheet\ProjectTimesheet;
use Tempo\Bundle\ProjectBundle\Timesheet\ProjectActivityDayTimesheet;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class TimesheetManager extends BaseManager
{
    public function findActivities($user, $weekBegin, $weekEnd)
    {
        return $this->repository->findActivities($user, $weekBegin, $weekEnd);
    }

    /**
     * @param  \DateTime $date
     * @return array
     */
    public function findByPeriod(\DateTime $date)
    {
        return $this->repository->findBy(array('workedDate' => $date));
    }

    /**
     * @param $activities
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

             if (!isset($activities[$day])) {
                 $activities[$day] = new ProjectActivityDayTimesheet($day);
             }

             $activityReport = $activities[$day];
             $activityReport
                 ->addActivity($activity)
                 ->addTime($activity->getWorkedTime());
         }

         foreach ($activities as $activityDay) {             $data[$activityDay->getActivities()[0]->getProject()->getId()]->addDay($activityDay);
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
