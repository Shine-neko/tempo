/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Tempo.Controller.Timesheet = Backbone.Marionette.Controller.extend({

    collection: new Tempo.Collection.Timesheet(),

    dashboard: function() {
        this.view  = new Tempo.View.Timesheet();

        $('.cra_load').on('keydown', function(event) {
            var input = $(event.target);
            if (!$.isNumeric( input.val() )) {
                input.css('border', '1px solid red');
            } else {
                input.css('border', '1px solid #CCC');
            }

            if (event.which == 9) {
                event.preventDefault();

                $(this).parent().find('.cra_desc').css('display', 'block');
            }
        });

        $('.cra_desc').on('keydown', function(event) {
            if (event.which == 13) {
                event.preventDefault();
                var form = $(this).parent('form');

                var loginFormObject = {};
                var name;
                $.each(form.serializeArray(),
                    function(i, v) {
                        //@toto replace by regex ?
                        name = (v.name).replace('timesheet[', '').replace(']', '');
                        loginFormObject[name] = v.value;
                    }
                );
                loginFormObject['project'] = form.data('project');
                var period = new Tempo.Model.Timesheet(loginFormObject).save().done(function() {
                    window.location.reload();
                });
            }
        });
    }
});
