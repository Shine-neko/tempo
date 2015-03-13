/**
 * Controller for viewing dashboard
 *
 * Initializes the board view and board model
 */
Tempo.Controller.Dashboard = Tempo.baseObject.extend({

    room: null,
    connectedUsersView: null,
    messagesView: null,
    CurrentRoomView: null,
    user:  null,

    load: function() {
        var container = $('#row-box');
        var chatbox = container.find('#chatbox');

        this.connectedUsersView = new Tempo.View.ConnectedUsers();
        this.messagesView = new Tempo.View.ChatBox({messages: this.room.get('chat_messages'), room: this.room});

        chatbox.html(''); //Remove loader
        chatbox.append(this.connectedUsersView.render().el);
        chatbox.append(this.messagesView.render().el);

        this.currentRoomView = new Tempo.View.Room({room: this.room});

        //Open a socket
        Tempo.socket = io.connect(window.location.hostname + ':8000');
        Tempo.socket.on('connect', _.bind(this.onSocketConnect, this));
    },

    //Handler for socket connections and reconnections
    onSocketConnect: function() {
        //Join the room for this scrumboard
        Tempo.socket.emit('subscribe', this.room.id, this.user);

        //We now have a socket so bind on events from it
        this.connectedUsersView.bindSocketEvents();
        this.messagesView.bindSocketEvents();
        this.currentRoomView.bindSocketEvents();
    }

});

