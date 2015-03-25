/**
 * Simple view to render chat messages in the chatBox
 */
Tempo.View.ChatMessage = Backbone.View.extend({
    tagName: 'div',
    template: '<div class="message-head" title="<%= created_at %>"><a href="#"> <%= user.username %> </a></div><p class="message-content"><%= content %></p>',
    className: 'chat-message',

    initialize: function(options) {
    },

    /**
     * Render a singe chat message
     */
    render: function() {
        var data = this.model.toJSON();
        this.$el.html(_.template(this.template)(data));
        return this;
    }
});

