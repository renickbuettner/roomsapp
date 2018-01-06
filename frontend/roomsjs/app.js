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
