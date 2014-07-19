<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class OrganizationManager extends BaseManager
{
   /**
    * return list projects organization
    * @param $id
    * @return array
    */
   public function getStatusProjects($id)
   {
       $counter = $this->repository->countProject($id);

       return array(
           'close' => $counter['prj_close'],
           'open'  => $counter['prj_open']
       );
   }

    public function nbTotalOrganisation()
    {
        return $this->repository->totalOrganisation();
    }
}
