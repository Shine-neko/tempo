/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

var Tempo = Tempo || {};
var baseObject = require('../core/baseObject.js');
var timesheetView = require('../views/timesheet.js');

var timesheetController = baseObject.extend({
    view: false,

    dashboard: function() {
        this.view  = new timesheetView;

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
module.exports = timesheetController;