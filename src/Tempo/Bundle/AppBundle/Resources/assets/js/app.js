/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

'use strict';

var RouterManager = require('./router.js');
var Behavior = require('./core/behavior.js');

$(function() {

    $('body').removeClass('no-js').addClass('js');
    $('select').selectize();
    $('[data-toggle="tooltip"]').tooltip();

    $('.datetimepicker-instance').datetimepicker({
        separator: '-',
        format: 'YYYY/MM/DD'
    });

    $('.datepicker-instance').datetimepicker({
        pickTime: false,
        format: 'YYYY/MM/DD'
    });

    ZeroClipboard.config( { swfPath: "/vendor/zeroclipboard/dist/ZeroClipboard.swf" } );
    var zeroClipboard = new ZeroClipboard($(".zeroclipboard-pre button"));

    $( "time" ).each(function( index ) {
        var element = $(this);
        var time = $(this).attr('datetime');

        element.html(moment(time).fromNow());
    });

    $('.switch').bootstrapSwitch();

    require('./components/behavior.js')(Behavior);
    require('./components/modal.js');
    require('./components/flash.js');

    RouterManager = new RouterManager();
    Backbone.history.start({pushState: true});

});
