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
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\View As AnnotView;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

use Tempo\Bundle\AppBundle\Controller\Controller;
use Tempo\Bundle\AppBundle\Model\ChatMessage;
use Tempo\Bundle\AppBundle\Model\Room;
use Tempo\Bundle\AppBundle\Form\Type\ChatMessageType;


/**
 * Rest controller for stories
 */
class MessagesController extends Controller
{
    /**
     *
     * @Get("/room/{room}/message/{$chatMessageId}")
     *
     * Get a single message from this room messages
     *
     * @param Room $room
     * @param string $chatMessageId
     *
     */
    public function getMessageAction($room, $chatMessageId)
    {
        $room = $this->getManager('room')->getRepository()->findRoom($room, $this->getUser()->getId());

        $message = $room->getChatMessage($chatMessageId);
        if (!$message) {
            throw $this->createNotFoundException(sprintf(
                'Could not find message %s',
                $chatMessageId
            ));
        }
        return $message;
    }

    /**
     *
     * Get all messages for a room
     *
     * @param Room $room
     * @Get("/room/{room}/messages")
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="100", description="How many pages to return.")
     *
     */
    public function getMessagesAction($room, ParamFetcherInterface $paramFetcher)
    {
        $room = $this->getManager('room')->getRepository()->findRoom($room, $this->getUser()->getId());

        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->get('tempo.model_manager.message')->all($room , $limit, $offset, array());
    }

    /**
     * Create a new message
     * @Post("/room/{room}/messages")
     */
    public function postMessagesAction($room, Request $request)
    {
        $room = $this->getManager('room')->getRepository()->findRoom($room, $this->getUser()->getId());

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
