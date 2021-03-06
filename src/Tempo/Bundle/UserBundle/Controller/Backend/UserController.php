<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\UserBundle\Controller\Backend;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\UserBundle\Form\Type\Backend\UserType;

class UserController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function getForm($resource = null)
    {
        if ($this->config->isApiRequest()) {
            return $this->container->get('form.factory')->createNamed('', $this->config->getFormType(), $resource);
        }

        return $this->createForm(new UserType(), $resource);
    }

    /**
     * Render user filter form.
     */
    public function filterFormAction(Request $request)
    {
        return $this->render('TempoUserBundle:Backend/User:filterForm.html.twig', array(
            'form' => $this->get('form.factory')->createNamed('criteria', 'tempo_user_filter', $request->query->get('criteria'))->createView()
        ));
    }


}
