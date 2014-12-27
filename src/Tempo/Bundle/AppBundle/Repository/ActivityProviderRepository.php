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
use Tempo\Bundle\AppBundle\Model\Project;

/**
 * ActivityRepository
 *
 */
class ActivityProviderRepository extends EntityRepository
{
    public function findUserActivites($user)
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.provider', 'provider')
            ->leftJoin('provider.project', 'project')
            ->leftJoin('project.team', 'user')
            ->andWhere('user.user = :user')
            ->setParameter('user', $user);

        return $query->getQuery()->execute();
    }
}
