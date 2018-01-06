// Test TRoom and TView together
App.loadScreen("screen.login");

App.cache._routes.rooms = new TRoute("rooms", function () {
    App.loadView(
        new TView("RoomContainer", App.getTemplate("template.roomContainer"), {
            "\\$rooms": (new TRoom("Raum 905", "Haus 9", {}).getView().html())+(new TRoom("Raum 927", "Haus 9", {}).getView().html())
        })
    );
});
App.cache._routes.users = new TRoute("users", function () {
    App.loadView(new TView("Users", App.getTemplate("template.usermg"), {
        "\\$users": (new TView("User", "template.user", {

        }))
    }));
});



// Indev
App.loadScreen("screen.dashboard");
App.loadScreen("screen.login");