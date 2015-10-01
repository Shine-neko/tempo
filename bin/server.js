'use strict';

var
    fs      = require('fs'),
    yaml    = require('js-yaml'),
    logger  = require('winston');

try {
    var config = yaml.safeLoad(fs.readFileSync(__dirname +'/../app/config/parameters.yml', 'utf8'));
    var socket_io_port = config.parameters['socket_io.client'].split(':')[2];
} catch (e) {
    console.log(e);
}

var server = require('http').createServer();
var io = require('socket.io')(server);

server.listen(socket_io_port);

logger.info('SocketIO > listening on port ' + socket_io_port);

/**
 * Map of client IDs to usernames
 */
var usernames = {};

io.sockets.on('connection', function (socket) {

    logger.info('ElephantIO > broadcast');

    /**
     * Get the list of usernames connected to a room
     */
    var getCurrentUsers = function(room) {
        var clients = io.sockets.adapter.rooms[room];
        var returnClients = [];

        for ( var clientId in clients ) {
            if (usernames[room][clientId] !== 'undefined') {
                returnClients.push(usernames[room][clientId]);
            }
        }

        return returnClients;
    };

    socket.on('loadUser', function(user){
        socket.join(user.id);
    });

    /**
     * Allow clients to subscribe to a specific room
     */
    socket.on('subscribe', function(room, username) {
        socket.join(room);
        if (typeof(usernames[room]) == 'undefined') {
            usernames[room] = {};
        }

        logger.info(username.username + ' join room ' + room + ' on socket '+ socket.id);

        usernames[room][socket.id] = username;

        io.sockets.in(room).emit('user:change', getCurrentUsers(room));
    });

    /**
     * Allow clients to unsubscribe from a room
     */
    socket.on('unsubscribe', function(room) {
        socket.leave(room);

        logger.info(usernames[room][socket.id].username + ' join room ' + room + ' on socket '+ socket.id);

        delete usernames[room][socket.id];

        io.sockets.in(room).emit('user:change', getCurrentUsers(room));
    });

    socket.on('RoomEvent', function(room, eventType, params) {
        io.sockets.in(room).except(socket.id).emit(eventType, params);
    });

    socket.on('providerEvent', function(data) {
        //socket.broadcast
        var project = JSON.parse(data.project);

        project.members.forEach(function(member){
            socket.broadcast.to(member.user.id).emit('feed:change', data);
        })
    });
});