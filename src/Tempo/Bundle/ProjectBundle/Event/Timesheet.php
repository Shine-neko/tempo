<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Event;

use Tempo\Bundle\ProjectBundle\Model\TimesheetInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class Timesheet extends Event
{
    private $request;
    private $timesheet;

    /**
     * @param TimesheetInterface $timesheet
     * @param Request            $request
     */
    public function __construct(TimesheetInterface $timesheet, Request $request)
    {
        $this->timesheet = $timesheet;
        $this->request = $request;
    }

    /**
     * @return TimesheetInterface
     */
    public function getTimesheet()
    {
        return $this->timesheet;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}
