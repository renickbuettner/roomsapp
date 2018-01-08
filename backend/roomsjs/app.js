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
    init: function (uri, screen) {
        App.cache._backenduri = uri;
        App.l.onStart();
        App.l.loadScreen(screen);
    },
    debug: true
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
