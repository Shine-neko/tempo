Tempo.Collection.Timesheet = Backbone.Collection.extend({
    comparator: 'id',
    url: "/api/latest/timesheet/timesheets.json",
    model: Tempo.Model.Timesheet
});