<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Manager;

use Tempo\Bundle\MainBundle\Manager\BaseManager;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class UserManager extends BaseManager
{
    public function totalUsers()
    {
        return $this->repository->totalUsers();
    }
}