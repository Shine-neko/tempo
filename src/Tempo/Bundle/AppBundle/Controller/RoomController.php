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
use Tempo\Bundle\AppBundle\Form\Type\RoomType;
use Tempo\Bundle\AppBundle\Model\Room;

class RoomController extends Controller
{
    public function updateAction(Request $request, Room $room)
    {
        $form = $this->createForm(new RoomType(), $room);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('tempo.domain_manager')->update($room);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('TempoAppBundle:Room:update.html.twig', array(
            'form' => $form->createView(),
            'room' => $room
         ));
    }
    
    public function listAction()
    {
        $rooms = $this->getManager('room')->getRepository()->findRooms($this->getUser()->getId());
        
        return $this->render('TempoAppBundle:Room:list.html.twig', array('rooms' => $rooms));
    }
}
