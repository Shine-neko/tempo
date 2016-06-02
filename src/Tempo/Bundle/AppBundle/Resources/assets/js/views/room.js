/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


var Room = Backbone.View.extend({
    el: $("#content"),

    events : {
        'click #create-room': 'renderForm'
    },

    renderForm: function (event) {

        var template = _.template(JST["room/create.html"])({
            'action' : Routing.generate('room_create'),
            'save': Translator.trans('tempo.form.save')
        });

        var roomAdd = $('.room-add');

        if (roomAdd.find('form').length === 0) {
            roomAdd.append(template);
        }
    }

});

module.exports = Room;
