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

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class RoomRepository extends EntityRepository
{
    public function findRoom($room, $user)
    {
        $query = $this->createQueryBuilder('room')
            ->select('room')
            ->leftJoin('room.members', 'team')
            ->leftJoin('team.user', 'user')
            ->where('user.id = :user')
            ->andWhere('room.deletedAt IS NULL')
            ->andWhere('room.'.(ctype_digit($room) ? 'id' : 'slug').' = :room')
            ->setParameters(array(
                'room' => $room,
                'user' => $user,
            ))
            ->setMaxResults(1);

        return $query->getQuery()->getSingleResult();
    }

    public function findRooms($user)
    {
        $query = $this->createQueryBuilder('room')
            ->leftJoin('room.members', 'team')
            ->andwhere('team.user  = ?1')
            ->setParameter(1, $user);

        return $query->getQuery()->getResult();
    }
}
