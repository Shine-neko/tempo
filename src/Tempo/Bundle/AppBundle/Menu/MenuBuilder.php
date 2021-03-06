<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class MenuBuilder
{
    protected $factory;
    protected $translator;
    protected $securityContext;
    protected $eventDispatcher;
    protected $request;

    /**
     * @param FactoryInterface         $factory
     * @param SecurityContextInterface $securityContext
     * @param TranslatorInterface      $translator
     */
    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext, TranslatorInterface $translator, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->securityContext  = $securityContext;
        $this->eventDispatcher  = $eventDispatcher;
    }

    /**
     * @param $label
     * @param array $parameters
     * @return string
     */
    protected function translate($label, $parameters = array())
    {
        return $this->translator->trans($label, $parameters);
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }
}
