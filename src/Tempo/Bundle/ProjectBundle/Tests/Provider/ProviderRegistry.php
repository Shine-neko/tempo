<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tests;

use Tempo\Bundle\ProjectBundle\Provider\ProviderRegistry;

class ProviderRegistryTest extends \PHPUnit_Framework_TestCase
{
    protected $register;
    protected $provider;

    protected function setUp()
    {
        $this->register = new ProviderRegistry();
        $this->provider = $this->getMock('Tempo\Bundle\ProjectBundle\Provider\GithubProvider');
    }

    public function testProviderIsRegister()
    {
        $this->assertFalse($this->register->hasProvider('test'));
        $this->register->registerProvider('test', $this->provider);
        $this->assertTrue($this->register->hasProvider('test'));
    }

    public function testProviderUnRegister()
    {
        $this->register->registerProvider('test', $this->provider);
        $this->register->unregisterProvider('test', $this->provider);
        $this->assertFalse($this->register->hasProvider('test'));
    }
}