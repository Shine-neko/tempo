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
        $filter = $parentRequest->get('filter');
        $activities = array();
        $criteria = array(
            'createdAt' => new \DateTime($this->period[(!empty($filter['period']) ? $filter['period'] : 'month')]),
            'user' => $this->getUser()->getId()
        );

        if (!empty($filter['project'])) {
            $project = $this->get('tempo.repository.project')->findOneBy(array('slug' => $filter['project']));

            if (!$project) {
                $criteria['project'] = $project;
            }
        }

        if(!empty($filter['provider'])) {
            $criteria['provider'] = $filter['provider'];
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
        $providers = $this->getManager('project_provider')->getProviders(
            $this->getManager('project')->findAllByUser($this->getUser())
        );

        return $this->render('TempoAppBundle:Activity:list.html.twig', array(
            'filter' => $filter,
            'type' => $type,
            'activities' => $activities,
            'projects' => $this->getManager('project')->findAllByUser($this->getUser()->getId()),
            'providers' => $providers,
        ));
    }

    private function dateSort($a, $b)
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
