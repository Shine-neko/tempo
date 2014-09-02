<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Event;

use Tempo\Bundle\AppBundle\Model\TimesheetInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class Timesheet extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @param Request            $request
     * @param TimesheetInterface $timesheet
     */
    public function __construct(Request $request, TimesheetInterface $timesheet)
    {
        $this->request = $request;
        $this->timesheet = $timesheet;
    }

    /**
     * @var \Tempo\Bundle\AppBundle\Model\TimesheetInterface
     */
    private $timesheet;

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
