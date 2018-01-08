App.addons.RoomManager = {};

App.TRoom = function(uuid, name, location, entries){
    this.name     = name;
    this.location = location;
    this.entries  = entries;
    this.uuid     = uuid;
};

App.TRoom.prototype = {
    getView: function () {
        return new App.TView(this.name, App.l.getTemplate("template.room"), {
            "\\$room": this.name,
            "\\$building": this.location,
            "\\$href": "#rooms/"+this.uuid,
            "\\$currentState": "undefined"
        })
    }
};

App.events.initRooms = new App.TEvent("initRooms", function () {
    var slug = "/rooms";
    App.cache._routes[slug] = new App.TRoute(slug, function () {
        App.bridge.getRooms(function (state, response) {
            if(state == 200)
            {
                var body = "";
                for(var i=0; i < response.length; i++)
                {
                    body += (new App.TRoom(
                        response[i].uuid,
                        response[i].name,
                        response[i].location,
                        null).getView().html())
                }
                App.l.loadView(
                    new App.TView("RoomContainer", App.l.getTemplate("template.roomContainer"), {
                        "\\$rooms": body
                    })
                );
            }
            else {
                App.addons.snackbar.show(App.getTemplate("template.snackConFailed"))
            }
        })
    });
});