<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Controller;

use Tempo\Bundle\AppBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('TempoUserBundle:User')->findAll();

        return $this->render('TempoUserBundle:Default:list.html.twig', array('users' => $users));
    }
}
