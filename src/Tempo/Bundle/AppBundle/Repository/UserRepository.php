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
use Tempo\Bundle\AppBundle\Model\UserInterface;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
     /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $className = parent::createNew();
        $className->addRole(UserInterface::ROLE_DEFAULT);

        return $className;
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
