<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

use Tempo\Bundle\AppBundle\Controller\Controller;
use Tempo\Bundle\AppBundle\Model\Message;
use Tempo\Bundle\AppBundle\Model\Room;
use Tempo\Bundle\AppBundle\Form\Type\MessageType;


/**
 * Rest controller for stories
 */
class MessageController extends Controller
{
    /**
     *
     * @Get("/room/{room}/message/{$messageId}")
     *
     * Get a single message from this room messages
     *
     * @param Room $room
     * @param string $messageId
     *
     */
    public function getMessageAction($room, $messageId)
    {
        $room = $this->getManager('room')->getRepository()->findRoom($room, $this->getUser()->getId());

        $message = $room->getMessage($messageId);
        if (!$message) {
            throw $this->createNotFoundException(sprintf(
                'Could not find message %s',
                $messageId
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
     * @Post("/room/{room}/message")
     */
    public function postMessageAction($room, Request $request)
    {
        $room = $this->getManager('room')->getRepository()->findRoom($room, $this->getUser()->getId());

        $view = View::create();

        $message = new Message();
        $message
            ->setRoom($room)
            ->setUser($this->getUser());
        
        $room->addMessage($message);

        $form = $this->createForm(new MessageType(), $message);

        if ($form->submit($request) && $form->isValid()) {
            $this->get('tempo.domain_manager')->create($room);
            $view->setStatusCode(201)->setData($message);
        } else {
            $view->setData($form);
        }

        return $view;
    }
}
