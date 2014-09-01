<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

abstract class BaseManager
{
    protected $repository;
    protected $em;
    protected $class;

    /**
     * @param EntityManager $em
     * @param $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $this->em->getRepository($this->class);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function findOneBySlug($slug)
    {
        return $this->repository->findOneBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $user
     */
    public function findAllByUser($user)
    {
        return $this->repository->findAllByUser($user);
    }

    public function getRepository($class = null)
    {
        return $this->repository;
    }

    /**
     * Persist the given entity
     *
     * @param mixed $entity  An entity instance
     * @param bool  $doFlush Also flush  entity manager?
     */
    public function save($entity, $doFlush = true)
    {
        $this->em->persist($entity);

        if ($doFlush) {
            $this->em->flush();
        }
    }

    public function remove($entity, $doFlush = true)
    {
        $this->em->remove($entity);

        if ($doFlush) {
            $this->em->flush();
        }
    }
}
