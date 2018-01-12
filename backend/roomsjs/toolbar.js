App.addons.Toolbar = {

    registerButton: function (TButton) {
        App.cache._toolbarBtns[TButton.name] = TButton;
    },

    hideButton: function (name) {

    },

    showButton: function (name) {

    }

};

App.cache._toolbarBtns = {};

App.TToolbarButton = function (name, desc, icon, href) {
    this.name = name;
    this.description = desc;
    this.icon = icon;
    this.href = href;
};

App.TToolbarButton.prototype = {
    getView: function () {
        return new App.TView("name", App.l.getTemplate("template.toolbarButton"), {
            "\\$icon": this.icon,
            "\\$href": this.href,
            "\\$text": this.description
        })
    }
};