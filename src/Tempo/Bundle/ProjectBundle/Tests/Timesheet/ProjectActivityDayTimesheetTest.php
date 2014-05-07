<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Tests\Timesheet;

use Tempo\Bundle\ProjectBundle\Timesheet\ProjectActivityDayTimesheet;


class ProjectActivityDayTimesheetTest extends \PHPUnit_Framework_TestCase
{
    public function testAddTime()
    {
        $day = new ProjectActivityDayTimesheet(date('j'));

        $day->addTime(date('j'), 0.5);
        $day->addTime(date('j'), 1);
        var_dump($day->getTime(date('j')));
        $this->assertEquals(1.5, $day->getTime(date('j')));
    }

    public function testAddActivity()
    {
        $activity = $this->getMock('Tempo\Bundle\ProjectBundle\Model\TimesheetInterface');
        $activity
            ->expects($this->any())
            ->method('getWorkedDate')
            ->willReturn(date('j'))
        ;

        $day = new ProjectActivityDayTimesheet(date('j'));
        $day->addActivity($activity);

        $this->assertTrue($day->getDay() === date('j'));

        $this->assertEquals($day->getActivities(date('j'))[0]->getWorkedDate(), date('j'));
    }
}