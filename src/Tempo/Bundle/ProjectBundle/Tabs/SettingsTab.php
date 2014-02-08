<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tabs;

class SettingsTab implements TabProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return "settings";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "Settings";
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return "TempoProjectBundle:Project/Tabs:settings.html.twig";
    }
}