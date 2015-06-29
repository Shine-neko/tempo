<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Tempo\Bundle\AppBundle\Model\AccessInterface;

/**
 * TimesheetRepository
 *
 */
class TimesheetRepository extends EntityRepository
{
    /**
     * @param $user
     * @param $weekbegin
     * @param $weekend
     * @return array
     */
    public function findActivities($user, $weekBegin, $weekEnd)
    {
        $query = $this
            ->createQueryBuilder('timesheet')
                ->leftJoin('timesheet.project', 'project')
                ->leftJoin('project.members', 'team')
                ->leftJoin('team.user', 'user')
                ->where('timesheet.workedDate BETWEEN :begin AND :end')
                ->andWhere('user = :user')
                ->andWhere('timesheet.user = :user')
                ->andWhere('project.deletedAt IS NULL')
                ->setParameters(array(
                    'begin' => $weekBegin,
                    'end'   => $weekEnd,
                    'user'  => $user
                ));
        /*
            SELECT p.id, p.name, p.slug, t.id, t.worked_time, t.billable, t.created_at, t.description FROM tempo_project p
            LEFT JOIN tempo_project_user pu ON pu.project_id = p.id
            LEFT JOIN tempo_timesheet t ON t.project_id = p.id  WHERE pu.user_id = 1
        */

        return $query->getQuery()->getResult();
    }

    public function findActivitiesByState($user)
    {
        $query = $this
            ->createQueryBuilder('timesheet')
                ->leftJoin('timesheet.project', 'project')
                ->leftJoin('project.members', 'team')
                ->leftJoin('team.user', 'user');

        if (!is_object($user)) {
            $query
                ->andWhere('timesheet.user = :user')
                ->andWhere('team.label = :role' )
                ->setParameters(array('user' => $user, 'role' => AccessInterface::TYPE_OWNER));
        }

        return $query->getQuery()->getResult();
    }
}
