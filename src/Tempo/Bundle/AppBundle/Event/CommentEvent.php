<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class CommentEvent extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Tempo\Bundle\AppBundle\Model\CommentInterface
     */
    private $comment;

    /**
     * @param Request          $request
     * @param CommentInterface $comment
     */
    public function __construct(Request $request, $comment)
    {
        $this->request = $request;
        $this->comment = $comment;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return CommentInterface
     */
    public function getComment()
    {
        return $this->comment;
    }
}
