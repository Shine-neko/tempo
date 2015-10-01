/**
 * Room view
 */

var Tempo = Tempo || {};
Tempo.View = {};

Tempo.View.ConnectedUsers = Backbone.View.extend({

    tagName: 'div',
    id: 'connected-users',
    template: JST["chat/connectedusers.html"],
    users: [],
    events: {
        'click .toolbar-btn' : 'toggleShowUsers'
    },

    /**
     * Load the fixed elements on the bard
     * and do initial bindings
     */
    initialize: function(options) {
        _.bindAll(this, 'bindSocketEvents', 'render', 'onUserChange', 'toggleShowUsers');
        return this;
    },

    /**
     * Bind to events coming in from the socket connection
     */
    bindSocketEvents: function(socket) {
        if (typeof socket !== 'undefined') {
            socket.on('user:change', _.bind(this.onUserChange, this));
        }
    },

    /**
     * Render the view
     */
    render: function() {
        this.$el.html(_.template(this.template)({
            connectedCount : this.users.length,
            user: 'user' + (this.users.length > 1 ? 's' : '')
        }));
        var list = $('ul', this.$el);
        _.forEach(this.users, function(user) {
            var a = $('<a />')
                .attr('href', '/profile/' + user.slug)
                .append('<img src="'+user.avatar+'" width="30px" class="avatar" />');
            list.append($('<li>').html(a));
        });
        return this;
    },

    /**
     * When there is a change to a user from the server re render
     */
    onUserChange: function(users) {
        this.users = _.unique(users, false);

        this.render();
    },

    /**
     * Show/hide the connected users
     */
    toggleShowUsers: function() {

        var toolbar = $( this.$el).find('.toolbar-btn span');
        var element = $('#users-list', this.$el);

        if(element.is(':hidden') ) {
            element.show('slow');
            toolbar.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        } else {
            element.hide('slow');
            toolbar.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }

    }
});

module.exports = Tempo.View.ConnectedUsers;