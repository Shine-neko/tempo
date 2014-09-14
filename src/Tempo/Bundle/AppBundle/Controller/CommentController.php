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

use Tempo\Bundle\AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Event\CommentEvent;
use Tempo\Bundle\AppBundle\Form\Type\CommentType;
use Tempo\Bundle\AppBundle\Entity\Comment;

class CommentController extends Controller
{
    public function listAction(Request $request, $type, $parent)
    {
        $page = $request->query->get('page', 1);
        $comments = $this->getManager('comment')->getRepository()->findAllWithType($type);
        $form = $this->createForm(new CommentType());

        return $this->render('TempoAppBundle:Comment:list.html.twig', array(
            'comments' => $this->getPaginator($comments, $page),
            'form' => $form->createView(),
            'pagerRouteOptions' => $this->getPagerRouteOptions($type, $parent)
        ));
    }

    public function createAction(Request $request)
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $event = new CommentEvent($request, $comment);
        $form = $this->createForm(new CommentType(), $comment);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('event_dispatcher')->dispatch(TempoAppEvents::COMMENT_CREATE_INITIALIZE, $event);
            $this->getManager('comment')->save($comment);
            $this->get('event_dispatcher')->dispatch(TempoAppEvents::COMMENT_CREATE_SUCCESS, $event);
        }

        return $this->getUrlRedirect($request);
    }

    public function updatedAction(Request $request, Comment $comment)
    {
        $event = new CommentEvent($request, $comment);
        $form = $this->createForm(new CommentType(), $comment);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('event_dispatcher')->dispatch(TempoAppEvents::COMMENT_EDIT_INITIALIZE, $event);
            $this->getManager('comment')->save($comment);
            $this->get('event_dispatcher')->dispatch(TempoAppEvents::COMMENT_EDIT_SUCCESS, $event);

            return $this->getUrlRedirect($request);
        }

        return $this->render('TempoAppBundle:Comment:update.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $request, Comment $comment)
    {
        if ($comment->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $event = new CommentEvent($request, $comment);
        $this->getManager('comment')->remove($comment);
        $this->get('event_dispatcher')->dispatch(TempoAppEvents::COMMENT_DELETE_COMPLETED, $event);

        $this->addFlash('success', 'success deleted');

        return $this->getUrlRedirect($request);
    }

    protected function getPagerRouteOptions($type, $parent)
    {
        $routeParams = array();

        switch($type) {
            case 'project':
                $parent = $this->getManager('project')->getRepository()->find($parent);

                $routeParams['routeName'] = 'project_show';
                $routeParams['routeParams'] = array('slug' => $parent->getSlug());
                break;
        }

        return $routeParams;
    }

    private function getUrlRedirect($request)
    {
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
}
