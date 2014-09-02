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
use Tempo\Bundle\AppBundle\Controller\Controller;
use Tempo\Bundle\AppBundle\Form\Type\ChatMessageType;

class DashboardController extends Controller
{
    /**
     * main Action
     * 
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(Request $request)
    {
        $manager = $this->getManager('room');

        $rooms = $manager->findAll();
        $roomId = $request->query->get('currentRoom', $rooms[0]->getId());

        $request->getSession()->set('currentRoom', $roomId);
        $currentRoom = $this->getManager('room')->find( $request->getSession()->get('currentRoom'));

        $form  = $this->createForm(new ChatMessageType());

        return $this->render('TempoAppBundle:Default:dashboard.html.twig', array(
            'rooms' => $rooms,
            'currentRoom' => $currentRoom,
            'form' => $form->createView()
        ));
    }
}
