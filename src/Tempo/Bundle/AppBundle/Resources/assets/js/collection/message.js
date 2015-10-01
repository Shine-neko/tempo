/**
 * Chat Messages Collection
 */

'use strict';

var model = require ('../model/message.js');

module.exports = Backbone.Collection.extend({
    model: model
});
