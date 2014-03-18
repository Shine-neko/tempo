<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tabs;

class ProjectTab implements TabProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return "project";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "Project";
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return "TempoProjectBundle:Project/Tabs:project.html.twig";
    }
}