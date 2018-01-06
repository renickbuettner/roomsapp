App.addons.RoomManager = {};

function TRoom(name, location, entries){
    this.name     = name;
    this.location = location;
    this.entries  = entries;
}

TRoom.prototype = {
    getView: function () {
        return new TView(this.name, App.getTemplate("template.room"), {
            "\\$room": this.name,
            "\\$building": this.location,
            "\\$currentState": "undefined yet"
        })
    }
};