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

use Doctrine\ORM\EntityRepository;
/**
 * ActivityRepository
 *
 */
class ActivityRepository extends EntityRepository
{
    public function findUserActivites($user)
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.project', 'project')
            ->leftJoin('project.team', 'user')
            ->where('activity.target = :target')
            ->andWhere('user.user = :user')
            ->setParameter('target', 'Project')
            ->setParameter('user', $user);

        return $query->getQuery()->execute();
    }
}
