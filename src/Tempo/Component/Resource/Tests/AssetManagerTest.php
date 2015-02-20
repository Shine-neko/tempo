<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Component\Resource\Tests;

use Tempo\Component\Resource\AssetManager;

class ResourceManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AssetManager
     */
    protected $manager;

    protected function setUp()
    {
        $this->manager = new AssetManager();
    }

    public function testGetStylesheets()
    {
        $this->manager->requireResource('test.css');
        $this->assertEquals($this->manager->getStylesheets(), array('test.css'));
    }

    public function testGetJavascripts()
    {
        $this->manager->requireResource('test.js');
        $this->assertEquals($this->manager->getJavascripts(), array('test.js'));
    }

    public function testRequireResources()
    {
        $this->manager->requireResources(array('test.css', 'test.js'));

        $this->assertEquals(
           array_merge($this->manager->getStylesheets(), $this->manager->getJavascripts()),
            array('test.css', 'test.js')
        );
    }
}
