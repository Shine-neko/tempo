module.exports = function (name, obj, force) {
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