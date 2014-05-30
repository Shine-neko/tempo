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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tempo\Bundle\MainBundle\Entity\Settings;
use Tempo\Bundle\MainBundle\Form\SettingsType;
use Tempo\Bundle\MainBundle\Form\Type\ChatMessageType;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function helpAction()
    {
         return $this->render('TempoMainBundle:Default:help.html.twig');
    }
}
