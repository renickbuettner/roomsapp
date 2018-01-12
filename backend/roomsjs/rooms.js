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
                        var _room = new App.TRoom(
                            response[i].uuid,
                            response[i].name,
                            response[i].location,
                            null);
                        App.cache._rooms[_room.uuid] = _room;
                        body += (_room.getView().html())
                    }
                    App.l.loadView(
                        new App.TView("Rooms", App.l.getTemplate("template.roomContainer"), {
                            "\\$rooms": body
                        })
                    );

                    document.querySelector("#viewport #btnContAction")
                        .addEventListener("click", App.addons.RoomManager.UI.createRoom, false);

                     tabs = document.getElementsByClassName("goToRoom");
                     for (var i = 0; i < tabs.length; i++) {
                         tabs.item(i).addEventListener("click", App.addons.RoomManager.UI.singleRoom)
                     }
                }
                else {
                    App.addons.snackbar.show(App.l.getTemplate("template.snackConFailed"))
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
        },
        singleRoom: function () {
            var ref = this.hash.split('/')[3];
            App.log("[Rooms] Called to Room #" + ref);
            if(App.cache._rooms[ref] === undefined)
            {
                App.cache.lastOpenedRoom = null;
                App.addons.snackbar.show(App.l.getTemplate("template.snackDoesntExist"))
            }
            else {
                var room = App.cache._rooms[ref];
                App.cache.lastOpenedRoom = room;
                App.l.loadView(
                    new App.TView("SingleRoom", App.l.getTemplate("template.singleRoom"), {
                        "\\$name": room.name,
                        "\\$uuid": room.uuid,
                        "\\$location": room.location
                    })
                );
                App.addons.DateTimePicker.initSingleRoom()
            }
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
        loadReservations: function (room, begin, end) {
            App.bridge.getReservations(room, begin, end, function (state, response) {
                if(state == 200)
                {
                    var body = "";
                    for(var i=0; i < response.length; i++)
                    {
                        body += (
                            new App.TReservation(
                                response[i].uuid,
                                response[i].user,
                                response[i].room,
                                response[i].notes,
                                response[i].begin,
                                response[i].end
                            ).getView().html())
                    }
                    App.addons.RoomManager.putReservationsOnScreen(body);
                }
                else {
                    App.addons.snackbar.show(App.l.getTemplate("template.snackConFailed"));
                }
            });
        }
    },
    getCurrentRoom: function () {
        if(App.cache.lastOpenedRoom.uuid !== window.location.hash.split('/')[3]){
            App.log("[RoomManager] Suspicious activity detected.");
        }
        return App.cache.lastOpenedRoom;
    },
    putReservationsOnScreen: function (body) {
        var elem = document.querySelector("#viewport #reservations");
        if(body.length == 0)
        {
            elem.innerHTML = App.l.getTemplate("template.roomReservEmpty");
        }
        else {
            elem.innerHTML = body;
        }
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

App.TReservation = function (uuid, user, room, notes, begin, end) {
    this.uuid = uuid;
    this.user = user;
    this.room = room;
    this.notes = notes;
    this.begin = begin;
    this.end = end;
};

App.TReservation.prototype = {
    getView: function () {
        return new App.TView(this.name, App.l.getTemplate("template.reservation"), {
            "\\$uuid": this.name,
            "\\$username": this.user,
            "\\$roomname": this.room.name,
            "\\$notes": this.notes,
            "\\$begin": this.formatTimeString(this.begin),
            "\\$end": this.formatTimeString(this.end)
        })
    },
    formatTimeString: function (timestamp) {
        return (moment(timestamp, "X").format("k:mm"));
    }
};

App.events.RoomManager = new App.TEvent("RoomManager", function () {
    App.cache._rooms = {};
    var slugRooms = App.addons.RoomManager.ROUTES.rooms();
    App.cache._routes[slugRooms] = new App.TRoute(slugRooms, function () {
        App.addons.RoomManager.UI.getRooms()
    });
    var slugRoomCreate = App.addons.RoomManager.ROUTES.createRoom();
    App.cache._routes[slugRoomCreate] = new App.TRoute(slugRoomCreate, function () {
       App.addons.RoomManager.UI.createRoom()
    });
});