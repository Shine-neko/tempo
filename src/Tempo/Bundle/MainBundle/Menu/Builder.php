<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;


class Builder extends ContainerAware
{
    private $factory;
    private $translator;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, Translator $translator)
    {
        $this->factory = $factory;
        $this->translator = $translator;
    }

    /**
     * Generate Menu
     * @return \Knp\Menu\ItemInterface
     */
    public function menu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'right');

        $projects_trans = $this->translator->trans('menu.project', array(), 'TempoProject');
        $users_trans = $this->translator->trans('menu.users', array(), 'TempoProject');
        $timesheet_trans = $this->translator->trans('menu.timesheet', array(), 'TempoProject');
        $menu->addChild($projects_trans, array('route' => 'project_home'));
        $menu->addChild($timesheet_trans, array('route' => 'timesheet'));
        $menu->addChild($users_trans, array('route' => 'user_list'));

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

        $home_trans = $this->translator->trans('menu.home', array(), 'TempoProject');
        $menu->addChild($home_trans, array('route' => '_welcome'));
        
        return $menu;
    }
}