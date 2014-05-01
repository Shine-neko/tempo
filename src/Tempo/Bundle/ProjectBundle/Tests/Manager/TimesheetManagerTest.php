<?php

namespace Tempo\Bundle\ProjectBundle\Tests\Manager;

use Tempo\Bundle\ProjectBundle\Manager\TimesheetManager;
use CalendR\Period\Week;


class TimesheetManagerTest extends \PHPUnit_Framework_TestCase
{
    const TIMESHEET_CLASS = 'Tempo\Bundle\ProjectBundle\Entity\Timesheet';

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


        $this->timesheetManager = $this->createTimesheetManager($this->em, static::TIMESHEET_CLASS);

    }

    protected function createTimesheetManager($objectManager, $userClass)
    {
        return new TimesheetManager($objectManager, $userClass);
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
