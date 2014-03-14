Tempo.View.Timesheet = Backbone.View.extend({

    el: $("#content"),
    events: {
        'click .filter': 'filterClick'
    },
    logKey: function(e) {
        console.log(e.type, e.keyCode);
    },

    initialize: function() {
        _.bindAll(this, "render","filterClick");
    },
    modelAdded: function(model) {
        console.log(model);
    },

    filterClick: function(e) {
        $('.filter-content').toggle('slow');
    },

    render: function() {
    }
});
