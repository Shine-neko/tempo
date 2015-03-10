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

class ProjectRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {
        if (isset($criteria['slug']) && is_string($criteria['slug']) && strpos($criteria['slug'], '/') !== false) {

            list($organization, $project) = explode('/', $criteria['slug']);

            $query = $this
                ->createQueryBuilder('project')
                    ->select()
                    ->leftJoin('project.organization', 'org')
                    ->where('project.slug = ?1')
                    ->andWhere('org.slug = ?2')
                    ->setParameters(array(
                        1 => $project,
                        2 => $organization
                    ))
                ->setMaxResults(1);

            return $query->getQuery()->getSingleResult();
        }

        return parent::findOneBy($criteria);
    }

    /**
     * @param $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findProjectByUser($user)
    {
        $query = $this
            ->createQueryBuilder('project')
                ->leftJoin('project.members', 'team')
                ->leftJoin('team.user', 'user')
        ;

        if (null !== $user) {
            $query->where('user.id  = ?1')
                ->setParameter(1, $user);
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

    public function resort()
    {
        foreach ($this->findAllOrderByPriority() as $priority => $project) {
            $project->setPriority($priority);
        }
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
     * @return mixed
     */
    public function findAllOrderByCreatedAt()
    {
        return $this->createQueryBuilder('p')
                ->orderBy('p.createdAt', 'DESC')
                ->getQuery()
                ->execute();
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

    public function totalProject()
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
