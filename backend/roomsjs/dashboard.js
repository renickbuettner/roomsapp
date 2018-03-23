App.events.initDashboard = new App.TEvent("initDashboard", function () {
    App.l.appendScreenTask(
        "screen.dashboard",
        "initDashboard",
        new App.TScreenTask("initDashboard", function () {
            App.l.getElemById("btnUsername").innerText = App.cache.user.name;
            App.addons.router.callBack(
                App.addons.RoomManager.ROUTES.rooms());

            if(App.l.isSU()){
                var suOnly = document.createElement('style');
                suOnly.innerHTML = ".su-only { display: inline !important; }";
                document.body.appendChild(suOnly);
            }
        }));
});