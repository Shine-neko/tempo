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
use Tempo\Bundle\AppBundle\Form\Type\MessageType;

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
        $session = $request->getSession();

        $currentRoom = null;
        $manager = $this->getManager('room');
        $form  = $this->createForm(new MessageType());

        $rooms = $manager->getRepository()->findRooms($this->getUser()->getId());

        if ($rooms) {
            $roomId = $request->query->get('currentRoom', $rooms[0]->getId());
            $session->set('currentRoom', $roomId);
            $currentRoom = $this->getManager('room')->find($session->get('currentRoom'));
        }

        return $this->render('@TempoApp/dashboard.html.twig', array(
            'rooms' => $rooms,
            'currentRoom' => $currentRoom,
            'form' => $form->createView()
        ));
    }
}
