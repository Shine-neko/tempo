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

class OrganizationManager extends ModelManager
{
   /**
    * return list projects organization
    * @param $id
    * @return array
    */
   public function getStatusProjects($id)
   {
       $counter = $this->getRepository()->countProject($id);

       return array(
           'close' => $counter['prj_close'],
           'open'  => $counter['prj_open']
       );
   }

    public function nbTotalOrganisation()
    {
        return $this->getRepository()->totalOrganisation();
    }
}
