<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle;

final class TempoActivityEvents
{
    const ACTIVITY_CREATE_INITIALIZE            = 'tempo.activity.create.initialize';
    const ACTIVITY_CREATE_SUCCESS               = 'tempo.activity.create.success';
    const ACTIVITY_EDIT_INITIALIZE              = 'tempo.activity.edit.initialize';
    const ACTIVITY_EDIT_SUCCESS                 = 'tempo.activity.edit.success';
    const ACTIVITY_DELETE_COMPLETED             = 'tempo.activity.delete.completed';
}
