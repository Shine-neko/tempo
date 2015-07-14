/**
 * Controller for viewing dashboard
 *
 * Initializes the board view and board model
 */
Tempo.Controller.Dashboard = Tempo.baseObject.extend({

    room: null,
    connectedUsersView: null,
    messagesView: null,
    currentActivityView: null,
    user:  null,

    load: function() {

        var thas = this;
        var chatbox = $('#chatbox');

        if (this.room != null) {

            this.connectedUsersView = new Tempo.View.ConnectedUsers();
            this.messagesView = new Tempo.View.ChatBox({messages: this.room.get('chat_messages'), room: this.room});

            chatbox.html(''); //Remove loader
            chatbox.append(this.connectedUsersView.render().el);
            chatbox.append(this.messagesView.render().el);
        }

        $('#more-activity').click(function(event) {
            event.preventDefault();
            thas.reloadActivity(Tempo.Controller.Dashboard.user.id);
        });

        //Open a socket
        Tempo.socket = io.connect(window.location.hostname + ':8000');
        Tempo.socket.on('connect', _.bind(this.onSocketConnect, this));
    },

    //Handler for socket connections and reconnections
    onSocketConnect: function() {
        var thas = this;

        if (this.room != null) {
            //Join the room
            Tempo.socket.emit('subscribe', this.room.id, this.user);

            //We now have a socket so bind on events from it
            this.connectedUsersView.bindSocketEvents();
            this.messagesView.bindSocketEvents();
        }

        Tempo.socket.on('feed:change', function(data) {
            var project = JSON.parse(data.project);
            _.each(project.members, function(member) {
                if(Tempo.Controller.Dashboard.user.id == member.user.id) {
                    thas.reloadActivity(member.user.id);
                }
            });
        });
    },

    reloadActivity: function(userId) {

        var params = { type: 'all' };
        var eventPush = $('.events-push:first');

        if (eventPush.hasData('activities')) {
            var lastEvent = eventPush.data('activities').split(',');
            params['internal'] = lastEvent[0];
            params['provider'] = lastEvent[1];
        } else {
            $('#more-activity').attr('href', '#');
        }

        $.ajax({
            type: "GET",
            url: Routing.generate('activity_list', params)
        }) .done(function( content ) {
            $('.dashboard-' + userId).prepend(content);
            $('#more-activity').attr('href', Routing.generate('homepage', params));
        });
    }
});

