/**
 * Model for Room
 */

var Collection = require('../collection/message.js');

var RoomModel = Backbone.Model.extend({
    urlRoot: Routing.generate('api_room_show', { version: 'internal'}),

    defaults: {
        messages: null
    },

    /**
     * When we get a response from the server, that contains messages
     * Put those into collections
     */
    parse: function(response) {
        response.messages = new Collection(response.messages);
        response.messages.url = Routing.generate('api_message_get_messages', {
            version: 'internal',
            room: response.id
        });
        response.messages.fetch();
        return response;
    }
});

module.exports = RoomModel;