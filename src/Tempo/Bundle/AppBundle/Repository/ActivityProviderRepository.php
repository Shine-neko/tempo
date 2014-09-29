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
use Tempo\Bundle\AppBundle\Model\Project;

/**
 * ActivityRepository
 *
 */
class ActivityProviderRepository extends EntityRepository
{
    /**
     * @param $type
     * @return \Doctrine\ORM\Query
     */
    public function queryLastActivities()
    {
        $query = $this->createQueryBuilder('a');

        return $query;
    }

    public function findByProject(Project $project)
    {
        $query  = $this->queryLastActivities();
        $query->leftJoin('a.provider', 'ap');
        $query->leftJoin('ap.project', 'p');
        $query->AndWhere('p.id = :project');
        $query->setParameter('project', $project->getId());

        return $query->getQuery()->getResult();
    }

    public function findAllWithProvider($type)
    {
        $query  = $this->queryLastActivities($type);
        return $query->getQuery()->getResult();
    }
}
