<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle;

final class TempoAppEvents
{
    const SECURITY_IMPLICIT_LOGIN = 'tempo.security.implicit_login';

    const EMAIL_PRE_RENDER = 'tempo.mail.pre_render';
    const EMAIL_RENDER = 'tempo.mail.render';

    const ACTIVITY_CREATE_INITIALIZE            = 'tempo.activity.create.initialize';
    const ACTIVITY_CREATE_SUCCESS               = 'tempo.activity.create.success';
    const ACTIVITY_EDIT_INITIALIZE              = 'tempo.activity.edit.initialize';
    const ACTIVITY_EDIT_SUCCESS                 = 'tempo.activity.edit.success';
    const ACTIVITY_DELETE_COMPLETED             = 'tempo.activity.delete.completed';

    const ORGANIZATION_CREATE_INITIALIZE   = 'tempo.organization.create.initialize';
    const ORGANIZATION_CREATE_SUCCESS      = 'tempo.organization.create.success';
    const ORGANIZATION_EDIT_INITIALIZE     = 'tempo.organization.edit.initialize';
    const ORGANIZATION_EDIT_SUCCESS        = 'tempo.organization.edit.success';
    const ORGANIZATION_DELETE_COMPLETED    = 'tempo.organization.delete.completed';
    const ORGANIZATION_ASSIGN_USER         = 'tempo.organization.team.add.completed';
    const ORGANIZATION_DELETE_USER         = 'tempo.organization.team.delete.completed';

    const PROJECT_CREATE_INITIALIZE        = 'tempo.project.create.initialize';
    const PROJECT_CREATE_SUCCESS           = 'tempo.project.create.success';
    const PROJECT_EDIT_INITIALIZE          = 'tempo.project.edit.initialize';
    const PROJECT_EDIT_SUCCESS             = 'tempo.project.edit.success';
    const PROJECT_DELETE_COMPLETED         = 'tempo.project.delete.completed';
    const PROJECT_ASSIGN_USER              = 'tempo.project.team.add.completed';
    const PROJECT_DELETE_USER              = 'tempo.project.team.delete.completed';

    const TIMESHEET_CREATE_INITIALIZE      = 'tempo.timesheet.create.initialize';
    const TIMESHEET_CREATE_SUCCESS         = 'tempo.timesheet.create.success';
    const TIMESHEET_EDIT_INITIALIZE        = 'tempo.timesheet.edit.initialize';
    const TIMESHEET_EDIT_SUCCESS           = 'tempo.timesheet.edit.success';
    const TIMESHEET_DELETE_COMPLETED       = 'tempo.timesheet.delete.completed';

    const ACTIVITY_PROVIDER_CREATE_INITIALIZE   = 'tempo.activity.provider.create.initialize';
    const ACTIVITY_PROVIDER_CREATE_SUCCESS      = 'tempo.activity.provider.create.success';
    const ACTIVITY_PROVIDER_EDIT_INITIALIZE     = 'tempo.activity.provider.edit.initialize';
    const ACTIVITY_PROVIDER_EDIT_SUCCESS        = 'tempo.activity.provider.edit.success';
    const ACTIVITY_PROVIDER_DELETE_COMPLETED    = 'tempo.activity.provider.delete.completed';

    const COMMENT_CREATE_INITIALIZE            = 'tempo.comment.post_create';
    const COMMENT_CREATE_SUCCESS               = 'tempo.comment.post_create';
    const COMMENT_EDIT_INITIALIZE              = 'tempo.comment.edit.initialize';
    const COMMENT_EDIT_SUCCESS                 = 'tempo.comment.edit.success';
    const COMMENT_DELETE_COMPLETED             = 'tempo.comment.delete.completed';
}
