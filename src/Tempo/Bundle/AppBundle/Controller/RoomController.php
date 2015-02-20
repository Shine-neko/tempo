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
    /**
     * Get a single room
     */
    public function getRoomAction($slug)
    {
        try {
            $room = $this->getManager('room')->getRepository()->findRoom($slug, $this->getUser()->getId());
        } catch (\Exception $e) {
            throw $this->createNotFoundException();
        }

        return $room;
    }

    public function getRoomsAction()
    {
        $rooms = $this->getManager('room')->getRepository()->findRooms($this->getUser()->getId());

        return $rooms;
    }

    public function updateAction(Request $request, Room $room, $_format = 'html')
    {
        $form = $this->createForm(new RoomType(), $room);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('tempo.domain_manager')->update($room);

            return $this->redirectToRoute('homepage');
        }

        $data = array(
            'form' => $form->createView(),
            'room' => $room
         );

        $view = $this->view($data, 200)
            ->setFormat('html')
            ->setTemplate('TempoAppBundle:Room:update.html.twig')
        ;
        return $this->handleView($view);
    }

}
