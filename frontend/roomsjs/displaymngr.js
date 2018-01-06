
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