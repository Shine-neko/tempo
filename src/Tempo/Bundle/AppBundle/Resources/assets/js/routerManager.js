/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


TempoRouterManager = Backbone.Router.extend({

    constructor: function(options) {
        options || (options = {});
        Backbone.Router.prototype.constructor.call(this, options);
    },

    _bindRoutes: function() {
        this.routes = _.result(this, 'routes');
        var route, routes = _.keys(this.routes);

        while ((route = routes.pop()) != null) {
            var routeAction = this.routes[route];
            var routeParts = routeAction.split('#');
            var isControllerAction = routeParts.length === 2;

            if (isControllerAction) {
                var controller, controllerName, method, methodName;
                controllerName = routeParts[0];
                controller = this.controllers[controllerName];
                methodName = routeParts[1];

                if (typeof controller !== 'undefined') {
                    method = controller[methodName];
                    this.route(route, routeAction, _.bind(method, controller));
                }

            } else {
                this.route(route, routeAction);
            }
        }
    },

    controllers: {
    },

    routes: {
        "": "home",
        "dashboard": "load",
        "timesheet": "timesheet#dashboard"
    },

    home: function() {
    }
});
