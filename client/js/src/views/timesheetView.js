Tempo.View.Timesheet = Backbone.View.extend({

    el: $("#content"),
    events: {
        'click .filter' : 'filterClick'
    },

    initialize: function() {
    },

    render: function() {
    },
    modelAdded: function(model) {
    },

    filterClick: function(e) {
        $('.filter-content').toggle('slow');
    }
});
