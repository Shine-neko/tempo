/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

$(function() {
    $('select').selectize({
        sortField: 'text',
        searchField: 'title'
    });
    $( "#slider" ).slider({
        slide: function( event, ui ) {
            $('#project_avancement').val(ui.value);
            $('#knob_value').html(ui.value + "%");
        },
        value: $('#project_avancement').val()
    });
});