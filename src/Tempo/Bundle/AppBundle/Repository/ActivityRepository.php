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
use Tempo\Bundle\AppBundle\Entity\Activity;

/**
 * ActivityRepository
 *
 */
class ActivityRepository extends EntityRepository
{
    /**
     * @param $type
     * @param $user
     * @return array
     */
    public function findLastActivities($type, $user)
    {
        $query = $this->queryLastActivities($type, $user);
        return $query->getResult();
    }
    public function queryLastActivities($type, $user)
    {
        $query = $this->createQueryBuilder('e');
        $query->leftJoin('e.author', 'a');

        if (null !== $type) {
            $query->where('e.targetType = :type');
            $query->setParameter('type', $type);
        }

        if (null !== $user) {
            $query->AndWhere('a.id  = ?1');
            $query->setParameter(1, $user->getId());
        }

        return $query->getQuery();
    }
}
