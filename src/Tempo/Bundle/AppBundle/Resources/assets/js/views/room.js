/**
 * View object for the room box
 */
Tempo.View.Room = Backbone.View.extend({

    currentRoom : null,

    initialize: function(options) {
        this.currentRoom = options.room;
        _.bindAll(this, 'bindSocketEvents', 'OnFeedChange');
    },

    bindSocketEvents: function() {
        Tempo.socket.on('feed:change', _.bind(this.OnFeedChange, this));
    },

    OnFeedChange: function(param) {
        var room = JSON.parse(param.room);
        var project = JSON.parse(param.project);
        $.ajax({
            type: "GET",
            url: Routing.generate('activity_list', { type: 'all', project: project.id })
        }) .done(function( content ) {
            $('room-' + room.id + ' #room-activity-box').html(content);
        });
    }
});