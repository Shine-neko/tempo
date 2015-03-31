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

Class MessageRepository extends EntityRepository
{
    public function getMessages($room)
    {
        return
            $this->createQueryBuilder('r')
                ->where('r.room = :room')
                ->setParameter('room', $room)
            ;
    }
}