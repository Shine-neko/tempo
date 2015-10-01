/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


var Router = Backbone.Router.extend({

    constructor: function(options) {
        options || (options = {});
        Backbone.Router.prototype.constructor.call(this, options);
    },

    _bindRoutes: function() {
        this.routes = _.result(this, 'routes');
        var route, routes = _.keys(this.routes);

        while ((route = routes.pop()) != null) {
            var routeAction = this.routes[route];
            if( typeof routeAction === 'string' ) {
                var routeParts = routeAction.split('#');
            }
            this.route(route, routeAction);
        }
    },

    routes: {
        "": function() {
            var controller = require('./controllers/dashboard.js');
            controller.initialize();

            return controller;
        },
        "timesheet": function() {
            var controller =  require('./controllers/timesheet.js');
            controller = new controller;
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

        "profile/edit/update": function () {
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
