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
class ActivityProviderRepository extends EntityRepository
{
    public function findActivities($project, $user, $provider = null)
    {
        $query = $this->createQueryBuilder('activity');
        $query
            ->leftJoin('activity.provider', 'provider')
            ->leftJoin('provider.project', 'project');

        if(null === $project ) {
            $query
                ->leftJoin('project.members', 'access')
                ->where('access.user = :user')
                ->setParameter('user', $user);
        } else {
            $query
                ->where('project = :project')
                ->setParameter('project', $project);
        }

        return $query->getQuery()->execute();
    }
}
