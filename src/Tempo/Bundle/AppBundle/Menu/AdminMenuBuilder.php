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

use Tempo\Bundle\AppBundle\Event\MenuBuilderEvent;

class AdminMenuBuilder extends MenuBuilder
{
    public function settingMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');
        $menu->setChildrenAttribute('id', 'menu');

        $menu->addChild(
            $this->translate('tempo.admin.menu.general'),
            array('route' => 'admin_configuration_general')
        );

        $menu->addChild(
            $this->translate('tempo.admin.menu.user'),
            array('route' => 'admin_user_index')
        );

        $menu->addChild(
            $this->translate('tempo.admin.menu.settings'),
            array('route' => 'admin_configuration_project')
        );

        $menu->addChild(
            $this->translate('tempo.admin.menu.organization'),
            array('route' => 'admin_organization_index')
        );

        $menu->addChild(
            $this->translate('tempo.admin.menu.project'),
            array('route' => 'admin_project_index')
        );

        $this->eventDispatcher->dispatch(MenuBuilderEvent::ADMIN_MAIN, new MenuBuilderEvent($this->factory, $menu));

        return $menu;
    }
}
