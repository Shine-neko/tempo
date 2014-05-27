<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Repository;

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
}
