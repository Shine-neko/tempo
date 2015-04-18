<?php

namespace Tempo\Bundle\AppBundle\Tests\Manager;

use Tempo\Bundle\AppBundle\Manager\TimesheetManager;
use CalendR\Period\Week;


class TimesheetManagerTest extends \PHPUnit_Framework_TestCase
{
    const TIMESHEET_CLASS = 'Tempo\Bundle\AppBundle\Model\Timesheet';
    private $timesheetManager;
    private $em;

    public function setUp()
    {
        $this->em = $this->getMock('\Doctrine\ORM\EntityManager', array(
                'getRepository',
                'getClassMetadata',
                'persist',
                'flush',
                'remove'
            ), array(), '', false
        );

        $domainManager = $this->getMockBuilder('Tempo\Bundle\AppBundle\Manager\DomainManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->timesheetManager = $this->createTimesheetManager($this->em, $domainManager, static::TIMESHEET_CLASS);

    }

    protected function createTimesheetManager($objectManager, $domainManager, $userClass)
    {
        return new TimesheetManager($objectManager, $domainManager, $userClass);
    }


    public function testDaysInWeek()
    {
        $daysInWeek = $this->timesheetManager->getDaysInWeek(
            array(
                0 => 'foo',
                1 => 'bar',
            )
        );

        $this->assertEquals( array(
            1 => 'foo',
            2 => 'bar',
        ), $daysInWeek);
    }

    public function testWorkday()
    {
        $week = (new \DateTime())->setISOdate('2014', '14');

        $daysInWeek = $this->timesheetManager->getDaysInWeek(
            new Week($week)
        );

        $workDay = $this->timesheetManager->getWorkday( array(
            0 => 'Monday',
            1 => 'Tuesday',
            2 => 'Wednesday'
        ), $daysInWeek);

        $this->assertEquals(array(
            1 =>  "Monday 31",
            2 =>  "Tuesday 01",
            3 =>  "Wednesday 02"
        ), $workDay);

    }

}
