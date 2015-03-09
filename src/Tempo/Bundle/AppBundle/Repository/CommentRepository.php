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

class CommentRepository extends EntityRepository
{
    public function findAllWithType($parent, $type)
    {
        $query = $this->createQueryBuilder('comment')
            ->select('comment');

        switch ($type) {
            case 'project':
                $query
                    ->leftJoin('comment.project', 'project')
                    ->where('project = :project')
                    ->setParameter('project', $parent);
                break;
        }

        return $query->getQuery();
    }
}
