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
    const COMMENT_CREATE_INITIALIZE            = 'tempo.comment.create.initialize';
    const COMMENT_CREATE_SUCCESS               = 'tempo.comment.create.success';
    const COMMENT_EDIT_INITIALIZE              = 'tempo.comment.edit.initialize';
    const COMMENT_EDIT_SUCCESS                 = 'tempo.comment.edit.success';
    const COMMENT_DELETE_COMPLETED             = 'tempo.comment.delete.completed';
}
