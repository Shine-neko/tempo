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

use Tempo\Bundle\AppBundle\Twig\Extension\UserExtension;

class UserExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $router;
    private $translator;
    private $notificationManager;
    private $imagineCacheManager;
    private $userExtension;

    public function setUp()
    {
        $this->router = $this
            ->getMockBuilder('Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->translator = $this
            ->getMockBuilder('Symfony\Component\Translation\TranslatorInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->notificationManager = $this
            ->getMockBuilder('Tempo\Bundle\AppBundle\Manager\NotificationManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->imagineCacheManager = $this
            ->getMockBuilder('Liip\ImagineBundle\Imagine\Cache\CacheManager')
            ->disableOriginalConstructor()
            ->getMock();


        $this->userExtension = new UserExtension(
            $this->router,
            $this->translator,
            $this->notificationManager,
            $this->imagineCacheManager
        );
    }

    public function testGetAvatarWithGravatar()
    {
        $path = $this->userExtension->getAvatar('http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?&d=mm', 80);

        $this->assertEquals('http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?&d=mm&s=80', $path);
    }

    public function testGetAvatar()
    {
        $this->imagineCacheManager
            ->expects($this->once())
            ->method('getBrowserPath')
            ->will($this->returnValue('/media/cache/resolve/avatar/rc/8BW561AA/uploads/avatars/user1.jpeg'));
        ;

        $path = $this->userExtension->getAvatar('/bundles/tempoapp/images/default-icon-project.png', 50);

        $this->assertEquals($path, '/media/cache/resolve/avatar/rc/8BW561AA/uploads/avatars/user1.jpeg');
    }
}