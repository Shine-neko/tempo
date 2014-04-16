Tempo.View.Timesheet = Backbone.View.extend({

    el: $("#content"),
    events: {
        'click .filter': 'filterClick',
        'click .cra_load': 'loadCra',
    },
    logKey: function(e) {
        console.log(e.type, e.keyCode);
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
    },

    ShowCra: function(e) {
        console.log(e);
    },

    loadCra: function(e) {
        console.log(e);
    }
});
