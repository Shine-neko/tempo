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

use Symfony\Component\Translation\TranslatorInterface;
use Knp\Menu\FactoryInterface;

class Tabs
{
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->translator = $translator;
    }

    public function tabMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');

        $menu->addChild(
            $this->translate('tempo.profile.tabs.profil'),
            array('route' => 'user_profile_edit')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.avatar'),
            array('route' => 'user_profile_picture')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.password'),
            array('route' => 'user_profile_password')
        );
        $menu->addChild(
            $this->translate('tempo.profile.tabs.settings'),
            array('route' => 'user_profile_settings')
        );

        return $menu;
    }

    protected function translate($label, $parameters = array())
    {
        return $this->translator->trans($label, $parameters);
    }
}
