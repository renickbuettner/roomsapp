App.addons.RoomManager = {
    ROUTES: {
        rooms: function () {
            return "/rooms";
        },
        createRoom: function () {
            return (this.rooms() + "/create")
        },
        "singleRoom": function (id) {
            return (this.rooms() + "/view/" + id)
        }
    },
    UI: {
        getRooms: function () {
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
                        new App.TView("Rooms", App.l.getTemplate("template.roomContainer"), {
                            "\\$rooms": body
                        })
                    );
                }
                else {
                    App.addons.snackbar.show(App.getTemplate("template.snackConFailed"))
                }
            })
        },
        createRoom: function () {
            App.l.loadView(
                new App.TView("createRoom", App.l.getTemplate("template.createRoom"), {}));

            document.querySelector("#viewport #btnRoomCreate")
                .addEventListener("click", App.addons.RoomManager.Actions.onRoomCreate, false);

            document.querySelector("#viewport #btnRoomCreateCancel")
                .addEventListener('click', App.addons.RoomManager.Actions.onFormLeave, false);
        }
    },
    Actions: {
        onRoomCreate: function () {
            App.log("[Rooms] Room creation requested.");
            var room = new App.TRoom(
                null,
                document.querySelector("#viewport #criName").value,
                document.querySelector("#viewport #criLocation").value,
                null);

            if(room.name.length < 4 || room.location.length < 4){
                document.querySelector("#viewport #criWarn").classList.remove("hidden");
                return;
            }

            App.bridge.createRoom(room, function (state, response) {
                if(state == 200)
                {
                    App.addons.RoomManager.Actions.onFormLeave();
                    App.addons.snackbar.show(App.l.getTemplate("template.snackRoomCreated"));
                }
                else {
                    App.addons.snackbar.show(App.l.getTemplate("template.snackConFailed"));
                }
            });
        },
        onFormLeave: function () {
            App.addons.router.callBack(App.addons.RoomManager.ROUTES.rooms());
        },
    }
};

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
            "\\$href": "#" + App.addons.RoomManager.ROUTES.singleRoom(this.uuid),
            "\\$currentState": "undefined"
        })
    }
};

App.events.RoomManager = new App.TEvent("RoomManager", function () {
    var slugRooms = App.addons.RoomManager.ROUTES.rooms();
    App.cache._routes[slugRooms] = new App.TRoute(slugRooms, function () {
        App.addons.RoomManager.UI.getRooms();
    });
    var slugRoomCreate = App.addons.RoomManager.ROUTES.createRoom();
    App.cache._routes[slugRoomCreate] = new App.TRoute(slugRoomCreate, function () {
       App.addons.RoomManager.UI.createRoom();
    });
});