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
        $masterRequest = $this->get('request_stack')->getMasterRequest();
        $lastEvent = array('internal' => null, 'provider' => null);

        $filter = $parentRequest->get('filter', array('period' => 'month'));
        $activities = array();
        $criteria = array(
            'createdAt' => new \DateTime($this->period[$filter['period']]),
            'user' => $this->getUser()->getId(),
            'activity' => $parentRequest->get('internal'),
            'activity_provider' => $parentRequest->get('provider')
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
            $lastEvent['provider']  = end($activities)->getId();
        }

        $activities = array_merge(
            $activities,
            $this->getManager('activity')->getActivities($criteria)
        );
        $lastEvent['internal']  = end($activities)->getId();

        usort($activities, array($this, 'dateSort'));
        krsort($activities);

        $providers = $this->getManager('project_provider')->getProviders(
            $this->getManager('project')->findAllByUser($this->getUser())
        );

        return $this->render('TempoAppBundle:Activity:list.html.twig', array(
            'type' => $type,
            'filter' => $filter,
            'activities' => $activities,
            'providers' => $providers,
            'masterRequest' => $masterRequest,
            'lastEvent' => $lastEvent,
            'projects' => $this->getManager('project')->findAllByUser($this->getUser()->getId()),
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
