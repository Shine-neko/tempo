/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Tempo.Controller.Timesheet = Backbone.Marionette.Controller.extend({

    dashboard: function() {
        this.view  = new Tempo.View.Timesheet();

        $('.cra_load').on('keypress', function(event) {
            var input = $(event.target);
            var value = parseFloat(input.val());

            if (!$.isNumeric(value)) {
                input.css('border', '1px solid red');
            } else {
                input.css('border', '1px solid #CCC');
            }
        }).on('click', function() {
            $(this).parent().find('.cra_desc').show();
        });

    }
});
