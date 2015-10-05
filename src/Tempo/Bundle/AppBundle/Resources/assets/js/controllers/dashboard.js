/**
 * Controller for viewing dashboard
 *
 * Initializes the board view and board model
 */
var Configuration = window.Tempo.Configuration;
var Tempo = Tempo || {};
Tempo.View = {};
Tempo.Model = {};

baseObject = require('../core/baseObject.js');
Tempo.View.ConnectedUsers = require('../views/connectedUsers.js');
Tempo.View.ChatBox = require('../views/chatBox.js');
Tempo.View.Room = require('../views/room.js');
Tempo.Model.Room = require('../model/room.js');

var Dashboard = baseObject.extend({

    connectedUsersView: null,
    messagesView: null,
    user:  null,

    initialize: function() {
        var that = this;
        var RoomId = $('#chat-box').data('currentroom');

        Tempo.socket = require('../components/socket.js')();
        this.connectedUsersView = new Tempo.View.ConnectedUsers;

        Backbone.ajax({
            url: Routing.generate('api_user_current'),
            async: false,
            success: function(userData) {
                that.user = userData;
            }
        });

        if (RoomId) {
            var Room = new Tempo.Model.Room({id:RoomId}, {parse:true});
            Room.fetch();
            this.room = Room;
            this.renderChatBox();
        }


        this.bindDomEvents();

        var roomView = new Tempo.View.Room;

        Tempo.socket.on('connect', _.bind(this.onSocketConnect, this));
    },

    bindDomEvents: function(){

        $('#more-activity').click(function(event) {
            event.preventDefault();
            that.reloadActivity(that.user.id);
        });
    },

    renderChatBox: function(){

        var chatbox = $('#chatbox');
        this.messagesView = new Tempo.View.ChatBox({messages: this.room.get('messages'), room: this.room});
        chatbox.html(''); //Remove loader
        chatbox.append(this.connectedUsersView.render().el);
        chatbox.append(this.messagesView.render().el);
    },
    //Handler for socket connections and reconnections
    onSocketConnect: function() {
        Tempo.socket.emit('loadUser', this.user);

        var that = this;
        if (this.room != null) {
            //Join the room
            Tempo.socket.emit('subscribe', this.room.id, this.user);

            //We now have a socket so bind on events from it
            this.connectedUsersView.bindSocketEvents(Tempo.socket);
            this.messagesView.bindSocketEvents();
        }

        Tempo.socket.on('feed:change', function(data) {
            that.reloadActivity(that.user.id);
        });
    },

    reloadActivity: function(userId) {

        var params = { type: 'all' };
        var eventPush = $('.events-push:first');

        if (eventPush.attr('data-activities') instanceof String) {
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

module.exports = Dashboard;
