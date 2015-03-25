/**
 * Room view
 */
Tempo.View.ConnectedUsers = Backbone.View.extend({

    tagName: 'div',
    id: 'connected-users',
    template: '<h5 id="user-handle" class="live-box-heading"><%= connectedCount %> Connected users</h5>' +
        '<a href="#" class="toolbar-btn"><span class="glyphicon glyphicon-chevron-up"></span> </a>'+
        '<ul id="users-list" class="clearfix"></ul>',
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
    bindSocketEvents: function() {
        var socket = Tempo.socket;
        if (typeof socket !== 'undefined') {
            socket.on('user:change', _.bind(this.onUserChange, this));
        }
    },

    /**
     * Render the view
     */
    render: function() {
        this.$el.html(_.template(this.template)({connectedCount : this.users.length}));
        var list = $('ul', this.$el);
        _.forEach(this.users, function(user) {
            var a = $('<a />')
                .attr('href', '/profile/' + user.username_canonical)
                .append('<img src="http://www.gravatar.com/avatar/'+md5(user.username_canonical)+'?s=30&d=mm" />');
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
