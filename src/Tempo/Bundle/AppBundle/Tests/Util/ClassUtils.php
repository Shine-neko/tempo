<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Util
{
    use Tempo\Bundle\AppBundle\Util\ClassUtils;

    class ClassUtilsTest extends \PHPUnit_Framework_TestCase
    {
        public function testGetShortName()
        {
            $this->assertEquals('TestObject', ClassUtils::getRealClass('\Tempo\Proxies\__CG__\AppBundle\Util\TestObject'));
        }

        public function testGetShortNameWithInstance()
        {
            $this->assertEquals('TestObject', ClassUtils::getRealClss(new Tempo\Proxies\__CG__\AppBundle\Util\TestObject));
        }
    }
}

namespace Tempo\Proxies\__CG__\AppBundle\Util
{
    class TestObject
    {
    }
}
