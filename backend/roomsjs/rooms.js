App.addons.RoomManager = {};

App.TRoom = function(name, location, entries){
    this.name     = name;
    this.location = location;
    this.entries  = entries;
};

App.TRoom.prototype = {
    getView: function () {
        return new App.TView(this.name, App.getTemplate("template.room"), {
            "\\$room": this.name,
            "\\$building": this.location,
            "\\$currentState": "undefined yet"
        })
    }
};