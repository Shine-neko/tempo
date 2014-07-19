<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    public function totalUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function autocomplete($slug)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.username')
            ->where('u.username LIKE :slug')
            ->setParameter('slug', '%'.$slug. '%')
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);

    }
}
