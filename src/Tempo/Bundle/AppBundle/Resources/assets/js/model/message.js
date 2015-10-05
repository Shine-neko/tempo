/**
 * Model for Chat Messages
 */
var MessageModel = Backbone.Model.extend({

    save: function(attributes, options) {
        options = _.defaults((options || {}), {url: Routing.generate('api_message_post_message', { version: 'internal', 'room': options.room.id} )});
        return Backbone.Model.prototype.save.call(this, attributes, options);
    }
});

module.exports = MessageModel;

