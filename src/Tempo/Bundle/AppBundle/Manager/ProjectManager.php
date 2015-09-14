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

use Tempo\Bundle\ResourceExtraBundle\Manager\ModelManager;

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
        if ((int) $key === 0) {
            $project = $this->getRepository()->findOneBy(array(
                'slug' => $key,
            ));
        } else {
            $project = $this->getRepository()->find($key);
        }

        return $project;
    }

    public function nbTotalProject()
    {
        return $this->getRepository()->totalProject();
    }
}
