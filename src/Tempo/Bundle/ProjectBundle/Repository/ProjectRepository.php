<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{

    public function findProjectByUser($user)
    {
        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.equipe', 'pu');

        if (null !== $user) {
            $query->where('pu.id  = ?1');
            $query->setParameter(1, $user);
        }

        return $query;
    }

    /**
     * @param $user
     * @return array
     */
    public function findAllByUser($user)
    {
        $query = $this->findProjectByUser($user);

        return $query->getQuery()->getResult();
    }

    /**
     * @param $user
     * @param $weekbegin
     * @param $weekend
     * @return array
     */
    public function findAllTimeSheet($user, $weekbegin, $weekend)
    {
        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.equipe', 'pu');
        $query->leftJoin('p.timesheets', 't');

        /*
            SELECT p.id, p.name, p.slug, t.id, t.time, t.billable, t.created, t.description FROM project p
            LEFT JOIN project_user pu ON pu.project_id = p.id
            LEFT JOIN timesheet t ON t.project_id = p.id  WHERE pu.user_id = 1
        */

        return $query->getQuery()->getResult();
    }

    /**
     *
     */
    public function resort()
    {
        foreach ($this->findAllOrderByPriority() as $priority => $project) {
            $project->setPriority($priority);
        }
    }

    /**
     * Return all projects sorted by interest, indexed by id
     *
     * @return Associative array of Project
     */
    public function findAllIndexedById()
    {
        $projects = $this->getOrderByPriorityQuery()->execute();

        // TODO: find how to INDEX BY id
        $projectsIndexed = array();
        foreach ($projects as $project) {
            $projectsIndexed[$project->getId()] = $project;
        }

        return $projectsIndexed;
    }

    /**
     * Return all projects sorted by priority.
     * Lower value is more important
     *
     * @return Array of Project
     */
    public function findAllOrderByPriority()
    {
        return $this->getOrderByPriorityQuery()->execute();
    }

    /**
     * Return a project. Any project.
     *
     * @return Project
     */
    public function findDummyProject()
    {
        return $this->createQueryBuilder('p')
                ->getQuery()
                ->setMaxResults(1)
                ->getSingleResult();
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    protected function getOrderByPriorityQuery()
    {
        return $this->createQueryBuilder('p')
                ->orderBy('p.priority', 'ASC')
                ->getQuery()
        ;
    }

    /**
     * @return mixed
     */
    public function findAllOrderByCreatedAt()
    {
        return $this->createQueryBuilder('p')->orderBy('p.createdAt', 'DESC')->getQuery()->execute();
    }

    /**
     * @param array $ids
     */
    public function sort(array $ids)
    {
        foreach ($ids as $priority => $id) {
            $this->find($id)->setPriority($priority);
        }
    }
}
