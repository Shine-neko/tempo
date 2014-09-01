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

use Tempo\Bundle\MainBundle\Manager\BaseManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class TeamManager extends BaseManager
{
    public function getRepository($class)
    {
        $this->repository = $this->em->getRepository($this->class);

        return $this->repository;
    }
}
