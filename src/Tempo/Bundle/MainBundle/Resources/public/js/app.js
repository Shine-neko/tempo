/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

'use strict';


var container = new Pimple();
container.set('router', function (c) {
    return new RouterManager();
});


var Tempo = Tempo || {
    'settings': {},
    'notification' : {},
    'behavior' : {},
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
Tempo.behavior = {
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
                if (initialized.hasOwnProperty(name)) {
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

Tempo.provide = function (name, obj, force) {
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
        Tempo.log('Starting application', 'INFO');
        container.get('router');

        Backbone.history.start({pushState: true});

    };
    Tempo.log = function() {
        var msg = '[Tempo] ' + Array.prototype.join.call(arguments,', ');
        if (window.console && window.console.log) {
            window.console.log(msg);
        } else if (window.opera && window.opera.postError) {
            window.opera.postError(msg);
        }
    };

    $('body').removeClass('no-js').addClass('js');
    $('.datepicker').datepicker();

    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();

        var btn = $(this),
            url = btn.attr('href'),
            title = btn.data('title'),
            role = btn.attr('role'),
            redirect = btn.data('redirect'),
            data_target = 'modal'+parseInt(Math.random()*1000),
            modal =  $('#myModal').clone();

        if(role != 'dialog') {
            modal.find('.modal-footer button.confirm').remove();
        }

        if (url.indexOf('#') == 0) {
            $(url).show().appendTo(modal.find('.modal-body'));
        } else {
            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            }).success(function() {
                $('input:text:visible:first').focus();
            });
        }

        modal.attr('id', data_target);
        modal.find('.modal-title').html(title);
        $('#dialog').append(modal);
        modal.modal();

        modal.find('button.confirm').on('click', function(e) {
            e.preventDefault();
            window.location.href = redirect;
        });

    });

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
    };


    Tempo.provide('router', function() {
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
                Tempo.log("Add route [" + route + "]");
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