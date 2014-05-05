Tempo.View.Timesheet = Backbone.View.extend({

    el: $("#content"),
    events: {
    },

    initialize: function() {
        _.bindAll(this, "render","filterClick");
    },

    render: function() {
    },
    modelAdded: function(model) {
    },

    filterClick: function(e) {
        $('.filter-content').toggle('slow');
    }
});
