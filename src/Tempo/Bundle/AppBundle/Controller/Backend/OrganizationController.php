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
use Tempo\Bundle\AppBundle\Form\Type\Backend\Filter\OrganizationFilterType;

class OrganizationController extends ResourceController
{
    /**
     * Render Organization filter form.
     */
    public function filterFormAction(Request $request)
    {
        return $this->render('TempoAppBundle:Backend/Organization:filterForm.html.twig', array(
            'form' => $this->get('form.factory')->createNamed('criteria', new OrganizationFilterType(), $request->query->get('criteria'))->createView()
        ));
    }
}