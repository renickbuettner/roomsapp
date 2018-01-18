App.addons.Toolbar = {

    elemID: "toolbar",

    registerButton: function (TButton) {
        App.cache._toolbarBtns[TButton.name] = TButton;
        return this;
    },

    hideButton: function (name) {
        var childs = App.l.getElemById(this.elemID).children;
        for (var i = 0; i < childs.length; i++)
        {
            //
            // Problem: das div element
            if( childs[i].hash == name )
            {
                childs[i].remove()
            }
        }
    },

    showButton: function (name) {
        //App.l.getElemById(this.elemID)
        //    .innerHTML += App.cache._toolbarBtns[name]
        //    .getView().html()
        var tb = App.l.getElemById(this.elemID),
            elem = document.createElement('div');
        elem.innerHTML = App.cache._toolbarBtns[name].getView().html();
        tb.insertBefore(elem, tb.lastChild.previousElementSibling);


    },

    resetToolbar: function () {
        var childs = App.l.getElemById(this.elemID).children;
        for (var i = 0; i < childs.length; i++)
        {
            if (childs[i].getAttribute("data-primary") !== "true") {
                childs[i].remove()
            }
        }
    }

};

App.cache._toolbarBtns = {};

App.TToolbarButton = function (name, desc, icon, href, oc) {
    this.name = name;
    this.description = desc;
    this.icon = icon;
    this.href = href;
    this.onclick = oc;
};

App.TToolbarButton.prototype = {
    getView: function () {
        return new App.TView("name", App.l.getTemplate("template.toolbarButton"), {
            "\\$icon": this.icon,
            "\\$href": "#" + this.href,
            "\\$text": this.description,
            "\\$onclick": this.onclick
        })
    }
};