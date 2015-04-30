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
            ->where("activity.createdAt > :createdAt")
            ->leftJoin('project.members', 'access')
            ->andWhere('access.user = :user')
            ->setParameters([
                'user' => $criteria['user'],
                'createdAt' => $criteria['createdAt']
            ]);

        if (!empty($criteria['project'])) {
            $query
                ->andWhere('project = :project')
                ->setParameter('project', $criteria['project']);
        }

        return $query->getQuery()->execute();
    }
}
