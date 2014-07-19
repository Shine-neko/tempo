Tempo.Model.Timesheet = Backbone.Model.extend({

    initialize: function(options) {

    },
    save: function(key, val, options) {
        var attributes  = this.attributes;
        this.url = Routing.generate('api_timesheet_create', { 'project': attributes.project });
        return Backbone.Model.prototype.save.call(this,attributes, options);
    }
});