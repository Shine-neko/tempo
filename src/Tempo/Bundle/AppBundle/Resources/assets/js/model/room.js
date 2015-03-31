/**
 * Model for Room
 */
Tempo.Model.Room = Backbone.Model.extend({
    urlRoot: Routing.generate('room_list'),

    defaults: {
        stories: null,
        chat_messages: null
    },

    initialize: function(options) {

    },

    /**
     * When we get a response from the server, that contains messages
     * Put those into collections
     */
    parse: function(response) {
        response.chat_messages = new Tempo.Collection.Messages(response.chat_messages);
        response.chat_messages.url = Routing.generate('chat_room_get_messages', {
            room: response.slug
        });
        response.chat_messages.fetch();
        return response;
    }
});

