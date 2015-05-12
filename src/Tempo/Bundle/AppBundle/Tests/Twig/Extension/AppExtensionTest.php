<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Twig\Extension;

use Tempo\Bundle\AppBundle\Twig\Extension\AppExtension;

class AppExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppExtension
     */
    protected $appExtension;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->appExtension = new AppExtension(
            $this
                ->getMockBuilder('Tempo\Bundle\AppBundle\Helper\Behavior')
                ->disableOriginalConstructor()
                ->getMock()
        );
    }

    public function testProviderContentParse()
    {
        $this->assertEquals(
            $this->appExtension->providerContentParse('[Visit Ikimea!](http://ikimea.com)'),
            '<a href="http://ikimea.com">Visit Ikimea!</a>'
        );
    }

    public function testGetAttribute()
    {
        $this->assertEquals($this->appExtension->getAttribute(array('firstName' => 'Nawo'), 'firstName'), 'Nawo');
        $this->assertEquals($this->appExtension->getAttribute(array('firstName' => 'Nawo'), '[firstName]'), 'Nawo');
        $this->assertEquals($this->appExtension->getAttribute(array('firstName' => 'Nawo'),'first_name'), 'Nawo');
        $this->assertEquals($this->appExtension->getAttribute(array('firstName' => 'Nawo'),'first_name'), 'Nawo');

        $this->assertFalse($this->appExtension->getAttribute(array(),'first_name'), 'Kamini');

    }
}
