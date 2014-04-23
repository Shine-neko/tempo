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
use Tempo\Bundle\ProjectBundle\Timesheet\ProjectTimesheet;

class ProjectTimesheetTest extends \PHPUnit_Framework_TestCase
{
    public function testNoExistDay()
    {
        $projectTimesheet = new ProjectTimesheet();

        $this->assertNull($projectTimesheet->getDay(date('d')));
    }

    public function testExistDay()
    {
        $day = $this->getMock(
            'Tempo\Bundle\ProjectBundle\Timesheet\ProjectActivityDayTimesheet',
            array(),
            array('date' => date('y'))
        );
        $day
            ->expects($this->any())
            ->method('getDay')
            ->willReturn(date('d'))
        ;

        $projectTimesheet = new ProjectTimesheet();
        $projectTimesheet->addDay($day);
    }
}