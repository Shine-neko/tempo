/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

var Comment = Backbone.View.extend({

  el: $("#content"),
  events: {
    "click .edit-comment" : "edit"
  },

  edit: function(event) {
      var target = $( event.currentTarget );
      var that = this.$el;
      Backbone.ajax({
          url: target.attr('href'),

          success : function(event) {
              $(target).parents('.panel').find('.panel-body').html(event);
          }
      });
  }

});

module.exports = Comment;
