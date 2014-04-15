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
    //view : new Tempo.View.Timesheet(),

    initialize: function() {
        console.log('timesheet iniatialise');

        //this.collection.fetch();

        this.view  = new Tempo.View.Timesheet();

        $('.cra_load').on('click', function(e) {
            e.preventDefault();

            var cra_id = $(this).attr('rel');
            var day_date = cra_id.replace('form-cra-load-', '');
            var init_date = new Date();

            var projectId = $(this).data('projectid');

        });

        $('.cra_load').on('keydown', function(event) {
            if (event.which == 9) {
                event.preventDefault();

                var cra_id = $(this).attr('rel');
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

               var period = new Tempo.Model.Timesheet(loginFormObject).save().done(function() {
                    window.location.reload();
               });
            }
        });

        $('a.show_cra').on('click', function(e) {
            e.preventDefault();
            $('.list').hide();
            $('#' + $(this).attr('rel')).show();
        });


        $('#time-list .boxclose').on('click', function(e) {
            $('#' + $(this).attr('rel')).hide();
        });

    }
});
