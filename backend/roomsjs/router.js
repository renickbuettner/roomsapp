App.cache._routes = {};

App.TRoute = function(name, run) {
    this.run = run;
    this.name= name;
};

App.addons.router = {
    callBack: function (name) {
        for(var r in App.cache._routes){
            if ("#"+r.trim() == name.trim()){
                App.log("[Router] Action found: " + r);
                App.cache._routes[r].run()
            }
        }
    }
};
App.events.onNavigate = new App.TEvent("onNavigate", function () {
    tabs = document.getElementsByClassName("nav-link");
    for (var i = 0; i < tabs.length; i++) {
        tabs.item(i).addEventListener("click", function () {
            App.log("[EventManager] Navigate to: " + this.hash);
            App.addons.router.callBack(this.hash)
        })
    }
});