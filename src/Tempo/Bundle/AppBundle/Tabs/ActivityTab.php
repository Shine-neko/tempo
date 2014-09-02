<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tabs;

class ActivityTab implements TabProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return "activity";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "Activity";
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return "TempoAppBundle:Project/Tabs:activity.html.twig";
    }
}
