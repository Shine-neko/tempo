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
        console.log(model);
    },

    filterClick: function(e) {
        $('.filter-content').toggle('slow');
    }
});
