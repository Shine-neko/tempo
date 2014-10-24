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

use Symfony\Component\HttpFoundation\Request;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Tempo\Bundle\AppBundle\Form\Type\Backend\Filter\ProjectFilterType;

class ProjectController extends ResourceController
{
    public function filterFormAction(Request $request)
    {
        return $this->render('TempoAppBundle:Backend/Project:filterForm.html.twig', array(
            'form' => $this->get('form.factory')->createNamed('criteria', new ProjectFilterType() ,  $request->query->get('criteria'))->createView()
        ));
    }
}