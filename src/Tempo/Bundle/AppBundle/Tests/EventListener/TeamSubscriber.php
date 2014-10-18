<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

class TeamSubscriber extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected $translator;

    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @param Translator          $translator
     * @param Router              $router
     * @param NotificationManager $notificationManager
     */
    public function setUp()
    {
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->translator = $this->getMock('Symfony\Bundle\FrameworkBundle\Translation\Translator');
        $this->router = $this->getMock('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->notificationManager = $this->getMock('Tempo\Bundle\AppBundle\Manager\NotificationManager');
    }
}
