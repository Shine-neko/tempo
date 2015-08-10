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
use Tempo\Bundle\AppBundle\Model\Project;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Event\CommentEvent;
use Tempo\Bundle\AppBundle\Form\Type\CommentType;
use Tempo\Bundle\AppBundle\Model\Comment;

class CommentController extends Controller
{
    public function listAction(Request $request, $type, $parent)
    {
        $page = $request->query->get('page', 1);
        $comments = $this->getManager('comment')->getRepository()->findAllWithType($parent, $type);
        $form = $this->createForm(new CommentType());

        return $this->render('TempoAppBundle:Comment:list.html.twig', array(
            'comments' => $this->getPaginator($comments, $page),
            'form' => $form->createView(),
            'type' => $type,
            'parent' => $parent,
            'pagerRouteOptions' => $this->getPagerRouteOptions($type, $parent)
        ));
    }

    public function createAction(Request $request, $type, $parent)
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());

        $resource = $this->getManager($type)->find($parent);

        if (!$resource) {
            throw $this->createNotFoundException('Resource parent not found');
        }

        $comment->{'set'. $type}($resource);

        $form = $this->createForm(new CommentType(), $comment);

        if ($form->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->create($comment);
            $this->get('tempo.mailer.sender')->sender('TempoAppBundle:Mail/Comment:create.html.twig', array(
                'resource' => $resource,
                'comment' => $comment,
                'emails' => array_map(function($member) {
                    return $member->getUser()->getEmail();
                }, $resource->getMembers()->toArray()),
            ));
        }

        return $this->getUrlRedirect($request);
    }

    public function updatedAction(Request $request, Comment $comment)
    {
        $form = $this->createForm(new CommentType(), $comment);

        if ($form->handleRequest($request)->isValid()) {

            $this->get('tempo.domain_manager')->update($comment);

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

        $this->get('tempo.domain_manager')->delete($comment);
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
