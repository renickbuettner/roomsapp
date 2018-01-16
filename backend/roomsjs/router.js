App.cache._routes = {};

App.TRoute = function(name, run) {
    this.run  = run;
    this.name = name;
};

App.addons.router = {
    callBack: function (name) {
        for(var r in App.cache._routes){
            if (r.trim() == name.trim()){
                window.location.hash = r;
                App.addons.Toolbar.resetToolbar();
                App.cache._routes[r].run()
            }
        }
    }
};
App.events.onNavigate = new App.TEvent("onNavigate", function () {
    tabs = document.getElementsByClassName("nav-link");
    for (var i = 0; i < tabs.length; i++) {
        tabs.item(i).addEventListener("click", function () {
            var ref = this.hash.split('#')[1];
            App.log("[Router] Called to " + ref);
            App.addons.router.callBack(ref)
        })
    }
});