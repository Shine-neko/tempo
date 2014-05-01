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
        $day = new ProjectActivityDayTimesheet(date('d'));

        $day->addTime(0.5);
        $day->addTime(1);

        $this->assertEquals(1.5, $day->getTime());
    }

    public function testAddActivity()
    {
        $activity = $this->getMock('Tempo\Bundle\ProjectBundle\Model\TimesheetInterface');
        $activity
            ->expects($this->any())
            ->method('getWorkedDate')
            ->willReturn(date('d'))
        ;

        $day = new ProjectActivityDayTimesheet(date('d'));
        $day->addActivity($activity);

        $this->assertEquals($day->getActivities(date('d'))[0]->getWorkedDate(), date('d'));
    }
}