<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
g*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle;

final class TempoProjectEvents
{
    const ORGANIZATION_CREATE_INITIALIZE   = 'tempo.organization.create.initialize';
    const ORGANIZATION_CREATE_SUCCESS      = 'tempo.organization.create.success';
    const ORGANIZATION_EDIT_INITIALIZE     = 'tempo.organization.edit.initialize';
    const ORGANIZATION_EDIT_SUCCESS        = 'tempo.organization.edit.success';
    const ORGANIZATION_DELETE_COMPLETED    = 'tempo.organization.delete.completed';
    const ORGANIZATION_ASSIGNING_USER      = 'tempo.organization.team.add.completed';
    const ORGANIZATION_DELETE_USER         = 'tempo.organization.team.delete.completed';

    const PROJECT_CREATE_INITIALIZE        = 'tempo.project.create.initialize';
    const PROJECT_CREATE_SUCCESS           = 'tempo.project.create.success';
    const PROJECT_EDIT_INITIALIZE          = 'tempo.project.edit.initialize';
    const PROJECT_EDIT_SUCCESS             = 'tempo.project.edit.success';
    const PROJECT_DELETE_COMPLETED         = 'tempo.project.delete.completed';
    const PROJECT_ASSIGNING_USER           = 'tempo.project.team.add.completed';
    const PROJECT_DELETE_USER              = 'tempo.project.team.delete.completed';

    const TIMESHEET_CREATE_INITIALIZE      = 'tempo.timesheet.create.initialize';
    const TIMESHEET_CREATE_SUCCESS         = 'tempo.timesheet.create.success';
    const TIMESHEET_EDIT_INITIALIZE        = 'tempo.timesheet.edit.initialize';
    const TIMESHEET_EDIT_SUCCESS           = 'tempo.timesheet.edit.success';
    const TIMESHEET_DELETE_COMPLETED       = 'tempo.timesheet.delete.completed';
}
