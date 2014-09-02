<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Timesheet;
use Tempo\Bundle\AppBundle\Timesheet\ProjectTimesheet;

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
            'Tempo\Bundle\AppBundle\Timesheet\ProjectActivityDayTimesheet',
            array(),
            array('date' => date('y'))
        );
        $day
            ->expects($this->any())
            ->method('getDay')
            ->willReturn(date('j'))
        ;

        $projectTimesheet = new ProjectTimesheet();
        $projectTimesheet->addDay($day);
    }
}