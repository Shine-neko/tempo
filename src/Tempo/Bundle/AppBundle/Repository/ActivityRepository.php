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
    /**
     * @param $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getUserActivites($user)
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.project', 'project')
            ->leftJoin('project.members', 'user')
            ->where('user.user = :user')
            ->setParameter('user', $user);

        return $query;
    }

    /**
     * @param $parent
     * @param $user
     * @return mixed
     */
    public function getProjectActivities($parent, $user)
    {
        $query =  $this->getUserActivites($user);
        if ($parent !== null) {
            $query
                ->andWhere('activity.project = :project')
                ->setParameter(':project', $parent);
        }

        $query
            ->AndWhere('activity.target IN(:target)')
            ->setParameter('target', array('Project', 'Comment'));

        return $query->getQuery()->execute();
    }
}
