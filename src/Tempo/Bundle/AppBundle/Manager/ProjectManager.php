<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Tempo\Bundle\AppBundle\Manager\ModelManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class ProjectManager extends ModelManager
{
    /**
     * @param $key
     * @return mixed
     */
    public function getProject($key)
    {
        if (is_int($key)) {
            $project = $this->getRepository()->find($key);
        } else {
            $project = $this->getRepository()->findOneBy(array(
                'slug' => $key,
            ));
        }

        return $project;
    }

    public function nbTotalProject()
    {
        return $this->getRepository()->totalProject();
    }
}