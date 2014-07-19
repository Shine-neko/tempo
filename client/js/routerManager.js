TempoRouterManager = Backbone.Router.extend({
    current : function(route){
        if(route && Backbone.History.started) {
            var Router = this,
            // Get current fragment from Backbone.History
                fragment = Backbone.history.fragment,
            // Get current object of routes and convert to array-pairs
                routes = _.pairs(Router.routes);

            // Loop through array pairs and return
            // array on first truthful match.
            var matched = _.find(routes, function(handler) {
                var route = handler[0];

                // Convert the route to RegExp using the
                // Backbone Router's internal convert
                // function (if it already isn't a RegExp)
                route = _.isRegExp(route) ? route :  Router._routeToRegExp(route);

                // Test the regexp against the current fragment
                return route.test(fragment);
            });

            // Returns callback name or false if
            // no matches are found
            return matched ? matched[1] : false;
        } else {
            // Just return current hash fragment in History
            return Backbone.history.fragment
        }
    },
    routes: {
        "": "home",
        "timesheet*": "timesheet",
    },

    home: function() {

    },
    timesheet: function() {
        new Tempo.Controller.Timesheet();
    }
});
