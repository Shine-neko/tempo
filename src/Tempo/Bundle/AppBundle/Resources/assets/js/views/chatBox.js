/**
 * View object for the chat box
 */

var Tempo = Tempo || {};
Tempo.View = {};
Tempo.Model = {};

Tempo.Model.Message =  require('../model/message.js');
Tempo.View.Message =  require('../views/message.js');

var ChatBox = Backbone.View.extend({
    tagName: 'div',
    template: JST["chat/chatbox.html"],
    id: 'chat',

    events: {
        'submit form': 'newMessage'
    },

    room: null,
    messages: null,

    /**
     * Initialize params and bind on collection events
     */
    initialize: function(options) {

        this.isLoading = false;
        this.room = options.room;
        this.messages = options.messages;
        this.messages.bind('add', this.renderNewMessage, this);

    },

    /**
     * Render the chat box, and render any messages using the sub view
     **/
    render: function() {
        this.$el.html(_.template(this.template)({
        }));

        var messageList = $('#chat-messages', this.$el);
        messageList.html('');
        var fragment = document.createDocumentFragment();
        if (typeof this.messages !== 'undefined') {
            this.messages.forEach(function(message) {
                var template = new Tempo.View.Message({model: message});
                fragment.appendChild(template.render().el);
            });
        }
        messageList.append(fragment);
        return this;
    },

    /**
     * Bind to events coming in from the socket connection
     */
    bindSocketEvents: function() {
        if (typeof Tempo.socket !== 'undefined') {
            Tempo.socket.on('message:create', _.bind(this.remoteCreate, this));
        }
    },

    /**
     * When the user submits a new chat message, save it and add it to the collection
     */
    newMessage: function(event) {
        event.preventDefault();
        event.stopPropagation();
        var textbox = $('#message-input', this.$el);
        if (textbox.val() != '') {
            var messages = this.room.get('messages');
            var message = messages.create(
                {
                    content: textbox.val()
                },
                {
                    room: this.room,
                    wait: true,
                    success:  _.bind(this.onCreateSuccess, this)
                }
            );
            textbox.val('');
        }
    },

   /**
    * Send a socket message when a new ticket is created
    */
    onCreateSuccess: function(message) {
        if (typeof Tempo.socket !== 'undefined') {
            Tempo.socket.emit('RoomEvent', Tempo.roomId, 'message:create', {message: message});
        }
    },

    /**
     * Handler for a message created by a different user
     */
    remoteCreate: function(params) {
        var newMessage = new Tempo.Model.Message(params.message);
        this.messages.add(newMessage);
        $('#chat-handle', this.$el).addClass('new-message');
    },

    /**
     * When a message is added to the collection, render the new message
     * so we don't need to rerender the whole chat box
     */
    renderNewMessage: function(message) {
        var view = new Tempo.View.Message({model: message});
        var messageBox = $('#chat-messages', this.$el);
        messageBox.append(view.render().el);
        messageBox.prop('scrollTop', messageBox.prop('scrollHeight'));
    }
});

module.exports = ChatBox;

