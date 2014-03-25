<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\View As AnnotView;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Tempo\Bundle\MainBundle\Entity\ChatMessage;
use Tempo\Bundle\MainBundle\Entity\Room;
use Tempo\Bundle\MainBundle\Form\Type\ChatMessageType;


/**
 * Rest controller for stories
 */
class MessagesController extends FOSRestController
{
    /**
     * Get a single message from this room messages
     * 
     * @param Room $room
     * @param string $chatMessageId
     */
    public function getMessageAction(Room $room, $chatMessageId)
    {
        $message = $room->getChatMessage($chatMessageId);
        if (!$message) {
            throw $this->createNotFoundException('Could not find message ' . $chatMessageId);
        }
        return $message;
    }

    /**
     * Get all messages for a room
     * 
     * @param Room $room
     * @param string $chatMessageId
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many pages to return.")
     *
     */
    public function getMessagesAction(Room $room, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->get('tempo_main.manager.room.message')->all($room , $limit, $offset, array());
    }

    /**
     * Create a new message
     */
    public function postMessagesAction(Room $room, Request $request)
    {
        $view = View::create();

        $message = new ChatMessage();
        $message->setRoom($room);
        $message->setUser($this->getUser());

        $room->addChatMessage($message);


        $form = $this->createForm(new ChatMessageType(), $message);

        if ($form->submit($request) && $form->isValid()) {
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($room);
            $dm->flush();
            $view->setStatusCode(201)->setData($message);
        } else {
            $view->setData($form);
        }
        return $view;
    }
}
