/**
 * Model for Boards
 */
Tempo.Model.Room = Backbone.Model.extend({
    urlRoot: Routing.generate('get_rooms'),

    defaults: {
        stories: null,
        chat_messages: null
    },

    initialize: function(options) {

    },

    /**
     * When we get a response from the server, that contains tickets and stories
     * Put those into collections
     */
    parse: function(response) {
        response.chat_messages = new Tempo.Collection.ChatMessages(response.chat_messages);
        response.chat_messages.url = Routing.generate('get_room_messages', {room: response.id});
        response.chat_messages.fetch();
        return response;
    }
});

