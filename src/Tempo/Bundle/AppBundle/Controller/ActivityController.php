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
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;


class ActivityController extends Controller
{
    private $period = array(
        'today' => '-1day',
        'week' => '-1week',
        'month' => '-1month'
    );

    /**
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $parentRequest, $type = 'all')
    {
        $activities = array();
        $criteria = array(
            'createdAt' => new \DateTime($this->period[$parentRequest->query->get('date', 'month')]),
            'user' => $this->getUser()->getId()
        );

        if (null !== $project = $parentRequest->query->get('project', null)) {
            $project = $this->get('tempo.repository.project')->findOneBy(array('slug' => $project));
            $criteria['project'] = $project;
        }

        if ('all' === $type) {
            $activities = array_merge(
                $activities,
                $this->getManager('activity_provider')->getActivities($criteria)
            );
        }

        $activities = array_merge(
            $activities,
            $this->getManager('activity')->getActivities($criteria)
        );

        usort($activities, array($this, 'dateSort'));
        krsort($activities);

        $adapter = new ArrayAdapter($activities);
        $activities = new Pagerfanta($adapter);

        return $this->render('TempoAppBundle:Activity:list.html.twig', array(
            'type' => $type,
            'activities' => $activities,
            'projects' => $this->getManager('project')->findAllByUser($this->getUser()->getId()),
        ));
    }

    private function dateSort($a,$b)
    {
        $val1 = $a->getCreatedAt()->format('Y-m-d H:i:s');
        $val2 = $b->getCreatedAt()->format('Y-m-d H:i:s');

        if ($val1 == $val2) {
            return 0;
        }

        $dateA = strtotime($val1);
        $dateB = strtotime($val2);
        return ($dateA-$dateB);
    }
}
