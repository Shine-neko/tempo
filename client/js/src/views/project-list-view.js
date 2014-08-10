/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Tempo.View.ProjectList = Backbone.View.extend({

  el: $("#content"),
  events: {
    "click .list-organizations h2 a"  : "select"
  },

  initialize: function() {
  },

  select: function(event) {
    var target = $( event.currentTarget );
    var that = this.$el;
    $.ajax({
      url: target.attr('href'),
      beforeSend: function() {
        that.find('.list-project').html('<img class="loader" src="/bundles/tempomain/images/loading-bubbles.svg" width="64" height="64">');
      }
    }).done(function(content) {
      that.find('.list-project').html(content);
    });
  }

});

new Tempo.View.ProjectList();