
App.TView = function (name, template, defs) {
    this.name        = name;
    this.template    = template;
    this.definitions = defs;
};

App.TView.prototype = {
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
    defaultViewport: document.getElementById("viewport"),
    resetViewport: function () {
        this.viewport = this.defaultViewport
    }
};
App.addons.DisplayManager.resetViewport();
App.addons.DisplayManager.loadView = function (v){
    elem = this.viewport;
    elem.innerHTML = v.html();
};

App.addons.DisplayManager.screen = {
    active: null,
    activeCalled: null,
    enable: function (name) {
        if(this.active != null) {
            this.active.style.display = "none";
        }
        list = document.body.classList;
        while (list.length > 0) {
            list.remove(list.item(0))}
        this.active = document.getElementById(name);
        list.add(this.active.getAttribute("data-bodyclass"));
        this.screenTasks(name);
        this.active.style.display = "block";
        this.activeCalled = name;
    },
    screenTasks: function (name) {
        if(App.cache.screenTasks[name] !== undefined){
            var base = App.cache.screenTasks[name];
            for(var task in base){
                App.log("[ScreenTask] Run: " + base[task].name);
                base[task].start()
            }
        }
    },
    appendScreenTask: function (screen, name, task) {
        if(App.cache.screenTasks[screen] === undefined)
            App.cache.screenTasks[screen] = {};
        App.cache.screenTasks[screen][name] = task;
    }
};

App.cache.screenTasks = {};
App.TScreenTask = function(name, call) {
    this.name  = name;
    this.start = call;
};

App.cache._templates = [];
App.l.getTemplate = function (name) {
    if(App.cache._templates[name] === undefined){
        App.cache._templates[name] = document.getElementById(name).innerHTML;
    }
    return (App.cache._templates[name]);
};

App.l.loadView = function (v) {
    App.addons.DisplayManager.loadView(v)
};

App.l.loadScreen = function (s) {
    App.addons.DisplayManager.screen.enable(s)
};

App.l.appendScreenTask = function (screen, name, task) {
    App.addons.DisplayManager.screen.appendScreenTask(screen, name, task)
};