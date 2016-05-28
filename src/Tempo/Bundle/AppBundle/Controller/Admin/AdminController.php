<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\DefaultFormFactory;

class AdminController extends ResourceController
{
    public function filterFormAction(Request $request)
    {
        $form  = $this->getForm($request->query->get('criteria'));

        return $this->render('TempoAppBundle:Admin/Organization:filterForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function getForm($resource = null, array $options = array())
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $this->get('request_stack')->getCurrentRequest());
        $type = $configuration->getFormType();

        if (strpos($type, '\\') !== false) { // full class name specified
            $type = new $type();
        } elseif (!$this->get('form.registry')->hasType($type)) { // form alias is not registered
            $defaultFormFactory = new DefaultFormFactory($this->get('form.factory'));
            return $defaultFormFactory->create($resource, $this->manager);
        }

        return $this->createForm($type, $resource, $options);
    }
}
