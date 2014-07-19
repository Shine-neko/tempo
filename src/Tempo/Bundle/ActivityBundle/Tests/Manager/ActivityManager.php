<?php

namespace Tempo\Bundle\ProjectBundle\Tests\Manager;

class ActivityManagerTest extends \PHPUnit_Framework_TestCases
{
    private function createActivityManager()
    {
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $class = '';

        $manager =  $this->getMockBuilder('Tempo\Bundle\ActivityBundle\Manager\ActivityManager')
            ->disableOriginalConstructor()
            ->getMock();

        return new OrganizationManager(
            $dispatcher, $objectManager, $class
        );
    }
}