if(App.cache.screenTasks["screen.dashboard"] === undefined)
    App.cache.screenTasks["screen.dashboard"] = {};

App.cache.screenTasks["screen.dashboard"]["prepareSidebar"] = new App.TScreenTask("prepareSidebar", function () {
    App.l.getElemById("btnUsername").innerText = App.cache.user.name;
});

App.cache._routes.rooms = new App.TRoute("rooms", function () {
    App.bridge.getRooms(function (state, response) {
        if(state == 200)
        {
            var arr = [];

            for(i=0; i > response.length; i++)
            {
                
            }

            App.loadView(
                new App.TView("RoomContainer", App.getTemplate("template.roomContainer"), {
                    "\\$rooms": arr
                })
            );
        }
        else {
            App.addons.snackbar.show(App.getTemplate("template.snackConFailed"))
        }
    })
});