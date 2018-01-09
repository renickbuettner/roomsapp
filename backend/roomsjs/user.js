App.TUser = function(uuid, name, email, group){
    this.name  = name;
    this.uuid  = uuid;
    this.email = email;
    this.group = group;
};

App.TUser.prototype = {
    getView: function () {
        return new App.TView(this.name, App.getTemplate("template.room"), {
            "\\$room": this.name,
            "\\$building": this.location,
            "\\$currentState": "undefined yet"
        })
    },
    requestDelete: function () {},
    requestPasswordChange: function () {},
    requestNameChange: function () {},
    requestCreation: function () {}
};

App.addons.UserManager = {
    ROUTES: {
        users: function () {
            return "/users";
        },
        createUser: function () {
            
        },
        editUser: function () {
            
        }
    }
};


App.events.UserManager = new App.TEvent("UserManager", function () {

});