<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MenuBuilder
{
    private $factory;
    private $translator;

    /**
     * @param FactoryInterface $factory
     * @param SecurityContextInterface $securityContext
     * @param TranslatorInterface $translator
     */
    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->securityContext  = $securityContext;
    }

    /**
     * Builds main menu.
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->setChildrenAttribute('id', 'menu');

        $menu->addChild(
            $this->translate('tempo.menu.project'),
            array('route' => 'project_home')
        );
        $menu->addChild(
            $this->translate('tempo.menu.timesheet'),
            array('route' => 'timesheet')
        );

        return $menu;
    }

    /**
     * Generate Breadcrumb
     * @return \Knp\Menu\ItemInterface
     */
    public function breadcrumb()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('id', 'breadcrumb');
        $menu->setChildrenAttribute('class', 'clearfix');

        $menu->addChild(
            $this->translate('menu.home'),
            array('route' => 'homepage')
        );

        return $menu;
    }

    protected function translate($label, $parameters = array())
    {
        return $this->translator->trans($label, $parameters);
    }
}