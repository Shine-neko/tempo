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
            //Join the room for this scrumboard
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
        var $dashboard = $('.dashboard-' + userId);
        var lastEvent = $dashboard.data('activities').split(',');

        $.ajax({
            type: "GET",
            url: Routing.generate('activity_list', { type: 'all', internal: lastEvent[0], provider: lastEvent[1] })
        }) .done(function( content ) {
            $dashboard.prepend(content);
            //$dashboard.toggle("highlight");
        });
    }
});

