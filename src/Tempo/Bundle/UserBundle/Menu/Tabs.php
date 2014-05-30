<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Menu;

use Symfony\Component\Translation\Translator;
use Knp\Menu\FactoryInterface;

class Tabs
{
    public function __construct(FactoryInterface $factory, Translator $translator)
    {
        $this->factory = $factory;
        $this->translator = $translator;
    }

    public function tabMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');

        $edit = $this->translator->trans('profile.tabs.profil', array(), 'TempoUser');
        $profile = $this->translator->trans('profile.tabs.avatar', array(), 'TempoUser');
        $password = $this->translator->trans('profile.tabs.password', array(), 'TempoUser');
        $setting = $this->translator->trans('profile.tabs.settings', array(), 'TempoUser');

        $menu->addChild($edit, array('route' => 'user_profile_edit'));
        $menu->addChild($profile, array('route' => 'user_profile_picture'));
        $menu->addChild($password, array('route' => 'user_profile_password'));
        $menu->addChild($setting, array('route' => 'user_profile_settings'));

        return $menu;
    }
}
