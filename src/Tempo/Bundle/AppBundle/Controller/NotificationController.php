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
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tempo\Bundle\AppBundle\Controller\Controller;
use Pagerfanta\Exception\NotValidCurrentPageException;

class NotificationController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction(Request $request)
    {
        $page  = $request->query->get('page', 1);
        $state  = $request->query->get('all', 0);

        $query = $this->getManager('notification')->getNotifications($this->getUser()->getId(), $state);
        $notifications = $this->get('tempo.repository.notification')->getPaginator($query);

        try {
            $notifications->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('TempoAppBundle:Notification:dashboard.html.twig', array('notifications' => $notifications));
    }

    public function clearAction()
    {
        $this->get('tempo.repository.notification')->markAsViewed($this->getUser()->getId());

        return $this->redirectToRoute('notification_dashboard');
    }
}
