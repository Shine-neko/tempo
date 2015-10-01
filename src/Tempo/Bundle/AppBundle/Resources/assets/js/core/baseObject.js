module.exports = {
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