<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Model;

use Tempo\Bundle\AppBundle\Model\Team;

class ProjectUser extends Team
{
    protected $project;

    public function __construct($project, $user, $role)
    {
        $this->project = $project;
        $this->user = $user;
        $this->role = $role;
        $this->createdAt = new \DateTime();
    }
}
