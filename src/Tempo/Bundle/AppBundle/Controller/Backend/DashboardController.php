<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller\Backend;

use Tempo\Bundle\AppBundle\Controller\Controller;

/**
 * Dashboard Controller
 *
 * @author: Mlanawo.mbechezi@ikimea.com
 */
class DashboardController extends Controller
{
    public function mainAction()
    {
        return $this->render('TempoAppBundle:Backend:Dashboard/main.html.twig', array(
            'nbOrganizations'   => $this->getManager('organization')->nbTotalOrganisation(),
            'nbProjects'        => $this->getManager('project')->nbTotalProject(),
            'nbUsers'           => $this->getManager('user')->nbTotalUser(),
        ));
    }
}