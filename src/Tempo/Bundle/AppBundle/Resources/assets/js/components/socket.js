var Configuration = window.Tempo.Configuration;

module.exports = function() {
    if (window.socket){

        return window.socket;
    }

    var socket = io.connect(Configuration.get('socket_io.client'));

    window.socket = socket;

    return socket;
};