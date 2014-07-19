<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrganizationRepository extends EntityRepository
{
    public function findOrganizationByUser($user)
    {
        $query = $this->createQueryBuilder('p')
                ->leftJoin('p.team', 'pu');

        if (null !== $user) {
            $query->where('pu.id  = ?1')
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
        $query = $this->findOrganizationByUser($user);

        return $query->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function countProject($id)
    {
        $stmt = $this->getEntityManager()
        ->getConnection()
        ->prepare('SELECT (SELECT COUNT(p1.id) FROM tempo_project p1 WHERE p1.organization_id = :organization AND is_active = 1) as prj_close, (SELECT COUNT(id) FROM tempo_project p2 WHERE p2.organization_id = :organization AND is_active = 0) as prj_open');
        $stmt->bindParam('organization', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $counter =  $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $counter[0];
    }
    public function totalOrganisation()
    {
        return $this->createQueryBuilder('o')
        ->select('COUNT(o)')
        ->getQuery()
        ->getSingleScalarResult();
    }

}
