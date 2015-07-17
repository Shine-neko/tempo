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

class MainMenuBuilder extends MenuBuilder
{
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
            array('route' => 'project_dashboard')
        );
        $menu->addChild(
            $this->translate('tempo.menu.timesheet'),
            array('route' => 'timesheet')
        );

        $this->eventDispatcher->dispatch(MenuBuilderEvent::MAIN, new MenuBuilderEvent($this->factory, $menu));

        if ($this->authorization->isGranted('ROLE_ADMIN')) {
            $menu->addChild(
                $this->translate('tempo.menu.admin'),
                array('route' => 'admin')
            );
        }

        return $menu;
    }

    public function userProfile()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');

        $menu->addChild(
            $this->translate('tempo.profile.tabs.profil'),
            array('route' => 'user_profile_edit')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.avatar'),
            array('route' => 'user_profile_avatar')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.password'),
            array('route' => 'user_profile_password')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.settings'),
            array('route' => 'user_profile_settings')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.notifications'),
            array('route' => 'notification_dashboard')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.room'),
            array('route' => 'room_list')
        );

        $this->eventDispatcher->dispatch(MenuBuilderEvent::USER, new MenuBuilderEvent($this->factory, $menu));

        return $menu;
    }
}
