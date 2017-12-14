/**

 Contains source of software for schools by

 © Copyright by Renick Büttner, 2017

 */

App = {
    cache: {},
    views: {},
    addons: {},
    l: {}, // l stands for function library
    events: {},
    init: function () {
        App.l.onStart()
    }
};

App.log = function (s) {
    console.log(s)
};

App.l.onStart = function(){
    for(var ev in App.events){
        App.log("[Events] Added: " + App.events[ev].name);
        App.events[ev].start()
    }
};

function TEvent(name, call) {
    this.name  = name;
    this.start = call;
}

/*
 * Plugin: DisplayManager
 */

function TView(name, template, defs) {
    this.name        = name;
    this.template    = template;
    this.definitions = defs;
}

TView.prototype = {
    html: function() {
        App.log("[DisplayManager] View: Render: "+this.name);
        temp = this.template.toString();
        for (var key in this.definitions) {
            if (this.definitions.hasOwnProperty(key)) {
                temp = temp.replace(new RegExp(key, 'gi'), this.definitions[key])
            }
        }
        return temp;
    }
};

App.addons.DisplayManager = {
    viewport: null,
    defaultViewport: "viewport",
    resetViewport: function () {
        this.viewport = this.defaultViewport
    }
};
App.addons.DisplayManager.resetViewport();
App.addons.DisplayManager.loadView = function (v){
    elem = document.getElementById(this.viewport);
    elem.innerHTML = v.html()
};

App.addons.DisplayManager.screen = {
    active: null,
    enable: function (name) {
        if(this.active != null) {
            document.getElementById(this.active).style.display = "none";
        }
        document.getElementById(name).style.display = "block";
        this.active = name;
    }
};

App.getTemplate = function (name) {
    return (document.getElementById(name).innerHTML);
};

App.loadView = function (v) {
  this.addons.DisplayManager.loadView(v)
};

App.loadScreen = function (s) {
  this.addons.DisplayManager.screen.enable(s)
};

/*
 * Sidebar Navigation
 */
App.cache._routes = {};

function TRoute (name, run) {
    this.run = run;
    this.name= name;
}

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
App.events.onNavigate = new TEvent("onNavigate", function () {
    tabs = document.getElementsByClassName("nav-link");
    for (var i = 0; i < tabs.length; i++) {
        tabs.item(i).addEventListener("click", function () {
            App.log("[EventManager] Navigate to: " + this.hash);
            App.addons.router.callBack(this.hash)
        })
    }
});

/*
 * Login Manager
 */
function TUser(name, uuid){
    this.name     = name;
    this.uuid     = uuid;
}

TUser.prototype = {
    getView: function () {
        return new TView(this.name, App.getTemplate("template.room"), {
            "\\$room": this.name,
            "\\$building": this.location,
            "\\$currentState": "undefined yet"
        })
    },
    delete: function () {
    },
    changePwd: function () {
    }
};

/*
 * Room Manager
 */

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

// Hook
App.init();

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