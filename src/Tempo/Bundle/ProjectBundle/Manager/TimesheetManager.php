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

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class TimesheetManager extends BaseManager
{

    /**
     * @param  null  $weekbegin
     * @param $weekLang
     * @param $userId
     * @param  null  $weekend
     * @return array
     */
     public function getTimeForPeriod($filter, $curentWeek, $weekLang, $userId)
     {
        $data = array(
            'date' => array(),
            'week' => array(),
            'projects' => array(),
        );

        //date of the week
        $i = 1;
        foreach ($curentWeek as $day) {
            $data['date'][$i] = $day;
            $i++;
        }

        //weekday
        foreach ($weekLang as $key => $week) {
           $key++;
           $data['week'][$key] = $week . ' ' . $data['date'][$key]->format('d');
        }

        $projectsList = $this->em->getRepository('TempoProjectBundle:Project')->findAllByUser($userId);


        if(!empty($filter)) {
            $projectsTracList = $this->em->getRepository('TempoProjectBundle:Project')->findTimeEntry(
                $userId, $filter['from']->format('Y-m-j'), $filter['from']->format('Y-m-j')
            );
        }else {
             $projectsTracList = $this->em->getRepository('TempoProjectBundle:Project')->findTimeEntry(
                 $userId, $curentWeek->getBegin()->format('Y-m-j'), $curentWeek->getEnd()->format('Y-m-j')
             );
         }

        foreach($projectsList as $project) {
            $projectName = $project->getName();

            $data['projects'][$projectName]['id'] = $project->getId();
            $data['projects'][$projectName]['name'] = $project->getName();
            $data['projects'][$projectName]['slug'] = $project->getSlug();
            $data['projects'][$projectName]['cras'][] = array();
        }

        foreach ($projectsTracList as $project) {

            $projectName = $project->getName();


            foreach ($project->getTimesheets() as $timesheet) {

                $dateFormat =  $timesheet->getPeriod()->format('j');

                if (empty($data['projects'][$projectName]['cras'][$dateFormat]['total'])) {
                    $data['projects'][$projectName]['cras'][$dateFormat]['total'] = 0;
                }

                if (empty($data['projects'][$projectName]['cras'][$dateFormat]['hours'])) {
                    $data['projects'][$projectName]['cras'][$dateFormat]['hours'] = 0;
                }

                $data['projects'][$projectName]['cras'][$dateFormat]['hours'] += $timesheet->getTime();
                $data['projects'][$projectName]['cras'][$dateFormat]['day'] = $dateFormat;
                $data['projects'][$projectName]['cras'][$dateFormat]['list'][] = $timesheet;
                asort($data['projects'][$projectName]['cras'][$dateFormat]['list']);

                $data['projects'][$projectName]['cras'][$dateFormat]['total']++;
            }

             unset($data['projects'][$projectName]['cras'][0]);     // @TODO fix bug indexe 0
        }

        return $data;
    }
}
