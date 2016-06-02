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

use Doctrine\ORM\Query;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param array $infos
     * @return mixed
     */
    public function findUserBy($infos)
    {
        $key = key($infos);

        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder
            ->leftJoin('u.emails', 'emails')
            ->where(sprintf('u.%s = :user', $key))
            ->setParameter('user', $infos[$key]);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findUserByEmails($values)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.emails', 'emails')
            ->where('emails.email IN (:emails)')
            ->setParameter('emails', $values)
            ->getQuery()
            ->getSingleResult(Query::HYDRATE_OBJECT);
    }

    public function totalUser()
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
            ->andWhere('u.deletedAt IS NULL')
            ->setParameter('slug', '%'.$slug. '%')
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT);
    }
}
