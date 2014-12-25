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
use Doctrine\ORM\Query;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class RoomRepository extends EntityRepository
{
    public function findRoomWithProject($project)
    {
        return
            $this->createQueryBuilder('r')
                ->where('r.project = :project')
                ->setParameter('project', $project)
                ->getQuery()->getSingleResult()
            ;
    }

    public function findRoom($key, $user)
    {
        $query = $this->createQueryBuilder('room')
            ->select('room, project')
            ->leftJoin('room.team', 'team')
            ->leftJoin('room.project', 'project')
            ->leftJoin('team.user', 'user')
            ->where('user.id  = :key');

        if (is_integer($key)) {
            $query->andWhere('room.id  = :user');
        } else {
            $query->andWhere('room.slug  = :user');
        }

        $query->setParameter('user', $key)
            ->setParameter(':key', $user)
            ->setMaxResults(1);

        return $query->getQuery()->getSingleResult();
    }

    public function findRooms($user)
    {
        $query = $this->createQueryBuilder('room')
            ->leftJoin('room.team', 'team')
            ->leftJoin('room.project', 'project')
            ->andwhere('team.user  = ?1')
            ->setParameter(1, $user);

        return $query->getQuery()->getResult();
    }
}
