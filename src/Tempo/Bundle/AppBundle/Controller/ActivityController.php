<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class ActivityController extends Controller
{
    /**
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($type, $parent)
    {
        $activitiesInternal = $this->getManager('activity')->getActivityActions($this->getUser());
        $activitiesProvider = $this->getManager('activityProvider')->getActivityActions($this->getUser());

        $activities =  array_merge($activitiesInternal, $activitiesProvider);

        return $this->render('TempoAppBundle:Activity:list.html.twig', array(
            'type' => $type,
            'activities' => $activities
        ));
    }
}
