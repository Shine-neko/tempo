<?php

namespace Tempo\Bundle\ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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
        $query = $this->createQueryBuilder('t');
        $query->leftJoin('t.project', 'p');
        $query->leftJoin('p.team', 'pu');

        $query->where('t.workedDate BETWEEN :begin AND :end');
        $query->AndWhere('pu = :user');
        $query->setParameter('begin', $weekBegin);
        $query->setParameter('end', $weekEnd);
        $query->setParameter('user', $user);

        /*
            SELECT p.id, p.name, p.slug, t.id, t.workedTime, t.billable, t.createdAt, t.description FROM project p
            LEFT JOIN project_user pu ON pu.project_id = p.id
            LEFT JOIN timesheet t ON t.project_id = p.id  WHERE pu.user_id = 1
        */

        return $query->getQuery()->getResult();
    }
}
