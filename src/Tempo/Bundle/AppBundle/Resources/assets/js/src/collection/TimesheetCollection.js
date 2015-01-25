Tempo.Collection.Timesheet = Backbone.Collection.extend({
    comparator: 'id',
    url: "/timesheet/timesheets.json",
    model: Tempo.Model.Timesheet
});