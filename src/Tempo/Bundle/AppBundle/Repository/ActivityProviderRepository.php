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
class ActivityProviderRepository extends EntityRepository
{
    public function findActivities($criteria = [])
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.provider', 'provider')
            ->leftJoin('provider.project', 'project')
            ->leftJoin('project.members', 'access')
            ->where("activity.createdAt > :createdAt")
            ->andWhere('access.user = :user')
            ->andWhere('activity.deletedAt IS NULL')
            ->setParameters([
                'user' => $criteria['user'],
                'createdAt' => $criteria['createdAt']
            ]);

        if (!empty($criteria['project'])) {
            $query
                ->andWhere('project = :project')
                ->setParameter('project', $criteria['project']);
        }

        if (!empty($criteria['provider'])) {
            $query
                ->andWhere('provider.name IN(:provider)')
                ->setParameter('provider', $criteria['provider']);
        }

        if(!empty($criteria['activity_provider'])) {
            $query
                ->andWhere('activity.id < :activity')
                ->setParameter('activity', $criteria['activity_provider']);
        }

        $query->setMaxResults(10);

        return $query->getQuery()->execute();
    }
}
