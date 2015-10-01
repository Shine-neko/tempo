var User = Backbone.View.extend({
    
    el: '#content',
    
    events: {
        'click .add-phone': 'addPhone',
        'click .remove-phone': 'removePhone'
    },
    
    addPhone: function(event) {
        event.preventDefault();
        var phoneCount = $('.col-phone').length;
        var phonePrototype = $('#phone-prototype');
        var prototype = phonePrototype.data('prototype');
        prototype = prototype.replace(/__name__/g, phoneCount);
        phoneCount++;
        phonePrototype.append(prototype);
    },
    
    removePhone: function(event) {
        event.preventDefault();
        var element = $(event.currentTarget).parent();
        element.remove();
    }
});

module.exports = User;