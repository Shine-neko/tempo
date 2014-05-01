<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Resource;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

interface ResourceManagerInterface
{
    /**
     * @param $resource
     */
    public function requireResource($resource);

    /**
     * @param array $resources
     */
    public function requireResources(array $resources);

    /**
     * return all css
     * @return array
     */
    public function getStylesheets();

    /**
     * return all javascripts
     * @return array
     */
    public function getJavascripts();
}
