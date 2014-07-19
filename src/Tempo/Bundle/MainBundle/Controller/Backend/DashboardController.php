<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Controller\Backend;
use Tempo\Bundle\CoreBundle\Controller\BaseController;

/**
 * Dashboard Controller
 *
 * @author: Mlanawo.mbechezi@ikimea.com
 */
class DashboardController extends BaseController
{
    public function mainAction()
    {

        return $this->render('TempoMainBundle:Backend:Dashboard/main.html.twig', array(
            'nbOrganizations' => $this->getManager('organization')->nbTotalOrganisation(),
            'nbProjects' => $this->getManager('organization')->nbTotalOrganisation(),
            'nbUsers' => $this->getManager('organization')->nbTotalOrganisation(),
        ));
    }
}