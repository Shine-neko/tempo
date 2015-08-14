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

use Tempo\Bundle\AppBundle\Util\ClassUtils;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class AccessRepository extends EntityRepository
{
    public function findAccess($resource, $user)
    {
        $className = ClassUtils::getShortName($resource);

        $query = $this->createQueryBuilder('access');
        $query->where(sprintf('access.%s = :%s', $className, $className));

        if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
            $query
                ->andWhere('access.inviteEmail = :user')
                ->andWhere('access.inviteEmail IS NOT NULL');
        } else {
            $query
                ->andWhere('access.user = :user')
                ->andWhere('access.user IS NOT NULL');
        }

        $query
            ->orWhere('access.user = :user')
            ->setParameters(array(
                $className => $resource,
                'user' => $user
            ))
        ;

        return $query->getQuery()->getSingleResult();
    }
}