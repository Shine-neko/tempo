<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\AppBundle\Controller\Backend;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends ResourceController
{
    public function filterFormAction(Request $request)
    {
        $form  = $this->getForm($request->query->get('criteria'));
        return $this->render('TempoAppBundle:Backend/Organization:filterForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
}