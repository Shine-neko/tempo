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
/**
 * ActivityRepository
 *
 */
class ActivityRepository extends EntityRepository
{
    public function getUserActivites($user)
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.project', 'project')
            ->leftJoin('project.members', 'user')
            ->where('activity.target IN(:target)')
            ->andWhere('user.user = :user')
            ->setParameter('target', array('Project', 'Comment'))
            ->setParameter('user', $user);

        return $query->getQuery()->execute();
    }
}
