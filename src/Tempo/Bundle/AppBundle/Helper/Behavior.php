<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Tempo\Component\Resource\ResourceManagerInterface;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class Behavior extends Helper
{
    protected $resourceManager;
    protected $router;
    protected $onload = array();
    protected $behavior = array();

    /**
     * @param ResourceManagerInterface $resourceManager
     * @param $router
     */
    public function __construct(ResourceManagerInterface $resourceManager, $router)
    {
        $this->resourceManager = $resourceManager;
        $this->router = $router;
    }

    /**
     * @return \Tempo\Component\Resource\ResourceManager
     */
    public function getResourceManager()
    {
        return $this->resourceManager;
    }

    /**
     * @param string $behavior
     * @param array $options
     */
    public function init($behavior, array $options)
    {
        $this->behavior[$behavior][] = $options;
    }

    /**
     *  Registers a JavaScript code to execute when loading the page, a * Once the DOM is ready.
     * @param string $call Code to run
     */
    public function onload($call)
    {
        $this->onload[] = 'function(){'.$call.'}';
    }

    /**
     * @return string
     */
    public function renderHTML()
    {
        $data = array();

        if ($this->behavior) {
            $behavior = json_encode($this->behavior);
            $this->onload('Tempo.Behavior.init('.$behavior.');');
            $this->behavior = array();
        }

        foreach ($this->onload as $func) {
            $data[] = '$('.$func.');';
        }

        if ($data) {
            $data = implode(' ', $data);
            return '<script type="text/javascript">/*<![CDATA[*/'. $data.'/*]]>*/</script>';
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return array
     */
    public function getResource()
    {
        return array(
            'javascripts' => $this->resourceManager->getJavascripts(),
            'stylesheets' => $this->resourceManager->getStylesheets()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Behavior';
    }
}
