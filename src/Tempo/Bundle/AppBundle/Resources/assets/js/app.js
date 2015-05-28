/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

'use strict';

var Tempo = {
    'Settings' : {},
    'Notification' : {},
    'Behavior' : {},
    'Controller':{},
    'View':{},
    'Model':{},
    'Collection':{}
};

/**
 *
 * @type {Object}
 * @todo : complete
 */
Tempo.Behavior = {
    behaviors: {},
    statics: {},
    initialized: {},

    create: function (name, control_function) {
        this.behaviors[name] = control_function;
        this.statics[name] = {};
    },

    init: function (map) {
        var missing_behaviors = [];
        for (var name in map) {
            if (!(name in this.behaviors)) {
                missing_behaviors.push(name);
                continue;
            }

            var configs = map[name];
            if (!configs.length) {
                if (this.initialized.hasOwnProperty(name)) {
                    continue;
                }
                configs = [null];
            }
            for (var ii = 0; ii < configs.length; ii++) {
                this.behaviors[name](configs[ii], this.statics[name]);
            }
            this.initialized[name] = true;
        }

        if (missing_behaviors.length) {
            throw new Error(
                'Behavior.init(map): behavior(s) not registered: ' +
                    missing_behaviors.join(', ')
            );
        }
    }
};

Tempo.Provide = function (name, obj, force) {
    if (!name) {
        throw "Give a name for Tempo.provide(name)";
    }
    var parent = this;

    var parts = name.split('.');
    if (parts) {
        for (var i = 0; i < parts.length; i++) {
            if (!parent[parts[i]]) {
                if (i >= parts.length - 1 && obj) {
                    parent[parts[i]] = obj;
                } else {
                    parent[parts[i]] = {};
                }
            }
            parent = parent[parts[i]];
        }

        if (force) {
            parent = obj;
        }
    }

    return parent;
};

Tempo.baseObject = {
    extend: function(props) {
        var prop, obj;
        obj = Object.create(this);
        for (prop in props) {
            if (props.hasOwnProperty(prop)) {
                obj[prop] = props[prop];
            }
        }
        return obj;
    },

    getSimple: function()
    {
        var simple = {};
        for (var prop in this) {
            if (this.hasOwnProperty(prop)) {
                simple[prop] = this[prop];
            }
        }
        return simple;
    }
};

$(function() {
    Tempo.run =  function() {
        var RouterManager = new TempoRouterManager();
        Backbone.history.start({pushState: true});

    };

    $('body').removeClass('no-js').addClass('js');
    $('select').selectize();
    $('[data-toggle="tooltip"]').tooltip();


    $('.datetimepicker-instance').datetimepicker({
        separator: '-',
        format: 'YYYY/MM/DD'
    });
    $('.datepicker-instance').datetimepicker({
        pickTime: false,
        format: 'YYYY/MM/DD'
    });

    ZeroClipboard.config( { swfPath: "/vendor/zeroclipboard/dist/ZeroClipboard.swf" } );
    var zeroClipboard = new ZeroClipboard($(".zeroclipboard-pre button"));


    var flash = $(".flash-container");
    if (flash.length > 0) {
        flash.show();
        flash.click(function() {
            return $(this).slideUp("slow");
        });

        flash.slideDown("slow");
        setTimeout((function() {
            return flash.slideUp("slow");
        }), 3000);
    }

    Tempo.Provide('router', function() {
        Backbone.Router.extend({
            el:undefined,
            $el:undefined,
            currentRoute:undefined,
            currentView:undefined,
            navigate:function (fragment, options) {
                this.currentRoute = fragment;
                return Backbone.Router.prototype.navigate.call(this, fragment, options);
            },
            route: function(route, name, callback) {
                return Backbone.Router.prototype.route.call(this, route, name, callback);
            },
            setElement:function (el) {
                this.el = el;
                this.$el = $(this.el);
            }
        });
    });
    Tempo.run();

});
