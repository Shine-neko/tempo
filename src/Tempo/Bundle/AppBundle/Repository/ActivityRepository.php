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

/**
 * ActivityRepository
 *
 */
class ActivityRepository extends EntityRepository
{
    /**
     * @param $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getUserActivities($user)
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.project', 'project')
            ->leftJoin('project.members', 'user')
            ->where('user.user = :user')
            ->andWhere('activity.deletedAt IS NULL')
            ->setParameter('user', $user);

        return $query;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getProjectActivities($criteria)
    {
        $query =  $this->getUserActivities($criteria['user']);
        if (!empty($criteria['project'])) {
            $query
                ->andWhere('activity.project = :project')
                ->setParameter(':project', $criteria['project']);
        }

        if(!empty($criteria['activity'])) {
            $query
                ->andWhere('activity.id < :activity')
                ->setParameter('activity', $criteria['activity']);
        }

        $query
            ->AndWhere('activity.target IN(:target)')
            ->setParameter('target', array('Project', 'Comment'))
            ->setMaxResults(10);

        return $query->getQuery()->execute();
    }
}
