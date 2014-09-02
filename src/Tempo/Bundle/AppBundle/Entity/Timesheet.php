<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Entity;

use Tempo\Bundle\AppBundle\Model\Timesheet as BaseTimesheet;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class Timesheet extends BaseTimesheet
{
    /**
     * {@inheritdoc}
     */
    public function prePersist()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate()
    {
    }
}
