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
    debug: false,
    defaults: {
        uri: "/",
        screen: "screen.login"
    }
};

App.log = function (s) {
    console.log(s)
};

App.l.init = function () {
    App.log("[RoomsApp] Hello!");
    App.cache._backenduri = App.defaults.uri;
    App.l.loadEvents();
    App.l.loadScreen(App.defaults.screen);
};

App.l.loadEvents = function(){
    for(var ev in App.events){
        App.log("[Events] Added: " + App.events[ev].name);
        App.events[ev].start()
    }
};

App.broadcast = function () {
    document.addEventListener('DOMContentLoaded', function () {
        App.l.init();
    }, false);
};

App.cache._elems = {};
App.l.getElemById = function (id) {
    if(App.cache._elems[id] === undefined){
        App.cache._elems[id] = document.getElementById(id)}
    return (App.cache._elems[id]);
};

App.TEvent = function(name, call) {
    this.name  = name;
    this.start = call;
};

App.broadcast();