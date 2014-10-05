<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Controller;

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

        $query = $this->get('tempo.manager.notification')->findAllByUserAndState(
            $this->getUser()->getId(),
            $state
        );

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagerfanta->setMaxPerPage(25);

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('TempoUserBundle:Notification:dashboard.html.twig', array('notifications' => $pagerfanta));
    }

    public function clearAction()
    {
        $this->get('tempo.manager.notification')->clearForUser($this->getUser()->getId());

        return $this->redirectRoute('notification_dashboard');
    }
}
