App.events.initDashboard = new App.TEvent("initDashboard", function () {
    App.l.appendScreenTask(
        "screen.dashboard",
        "initDashboard",
        new App.TScreenTask("initDashboard", function () {
            App.l.getElemById("btnUsername").innerText = App.cache.user.name;
            App.addons.router.callBack("#/rooms")}));
});