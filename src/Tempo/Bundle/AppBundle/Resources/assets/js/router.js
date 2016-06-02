/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

var Router = Backbone.Router.extend({
  routes: {
        "": function() {
            var controller = require('./controllers/dashboard.js');
            controller.initialize();

            return controller;
        },
        "timesheet/": function() {
            var controller =  require('./controllers/timesheet.js');
            controller.dashboard();

            return controller;
        },

        "project/:organization/:project": function() {
            var commentView = require('./views/comment.js');
            new commentView;
        },
        "project/:organization/:project/settings": function() {
            var projectView = require('./views/project.js');
            new projectView;
        },

        "profile/edit": function () {
            var userView = require('./views/user.js');
            new userView;
        },
        "room/list": function() {
            var roomView = require('./views/room.js');
            new roomView;
        }
    }
});

module.exports = Router;
