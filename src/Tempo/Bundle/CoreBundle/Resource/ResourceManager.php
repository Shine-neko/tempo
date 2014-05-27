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
 * @todo: Management with Assetics
 */

class ResourceManager implements ResourceManagerInterface
{
    protected $resources = array(
        'javascripts' => array(),
        'stylesheets' => array()
    );

    /**
     * {@inheritdoc}
     */
    public function requireResource($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if ($extension === 'js') {
            $this->resources['javascripts'][] = $filename;
        } else {
            $this->resources['stylesheets'][] = $filename;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function requireResources(array $files)
    {
        foreach ($files as $filename) {
           $this->requireResource($filename);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStylesheets()
    {
       return $this->resources['stylesheets'];
    }

    /**
     * {@inheritdoc}
     */
    public function getJavascripts()
    {
        return $this->resources['javascripts'];
    }
}
