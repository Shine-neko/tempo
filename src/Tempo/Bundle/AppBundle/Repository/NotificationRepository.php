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
 * NotificationRepository
 */
class NotificationRepository extends EntityRepository
{
    /**
     * @param $user
     * @param $state
     * @return Query
     */
    public function getUserNotifications($user, $state)
    {
        $qb = $this->createQueryBuilder('n')
            ->leftJoin('n.user', 'user')
            ->where('user = :user')
            ->andWhere('n.state = :state')
            ->setParameters(array(
                'state'  => $state,
                'user'   => $user
            ));
        return $qb;
    }

    /**
     * @param $user
     * @param $id
     */
    public function markAsViewed($user, $id = null)
    {
        $qb = $this->createQueryBuilder('n')
            ->update($this->_entityName, 'n')
            ->set('n.state', 1)
            ->where('n.user = :user')
            ->setParameter('user', $user);

        if (null !== $id) {
            $qb
                ->andWhere('n.id = :id')
                ->setParameter('id', $id);
        }

        $qb->getQuery()->execute();
    }
}
