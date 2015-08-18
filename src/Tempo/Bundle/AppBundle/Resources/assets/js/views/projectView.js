/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

$(document).ready(function() {
    $(document).on("switchChange.bootstrapSwitch",".provider-state-switch", function(event, state) {

        var routeProvider = $(this).attr('rel');

        $.ajax(routeProvider);
    });
});

Tempo.View.Project = Backbone.View.extend({

    el: $("#content"),
    events: {
        'click .handlediv' : 'toggleSection',
    },

    initialize: function() {

        $( "#slider" ).slider({
            slide: function( event, ui ) {
                $('#project_avancement').val(ui.value);
                $('#knob_value').html(ui.value + "%");
            },
            value: $('#project_avancement').val()
        });
    },
    toggleSection: function(e) {
        var target = $( event.target );
        target.parent().parent().children('.inside').toggle('slow');
    },
});