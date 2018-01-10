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
    }
};

App.addons.UserManager = {
    ROUTES: {
        users: function () {
            return "/users";
        },
        createUser: function () {
            return this.users() + "/create";
        },
        editUser: function (id) {
            return this.users() + "/view/" + id;
        }
    },
    UI: {
       users: function () {
           App.l.loadView(
               new App.TView("users", App.l.getTemplate("template.userContainer"), {}));

           document.querySelector("#viewport #btnContAction")
               .addEventListener("click", App.addons.UserManager.UI.createUser, false);
       },
       createUser: function () {
           App.l.loadView(
               new App.TView("createUser", App.l.getTemplate("template.createUser"), {}));

           document.querySelector("#viewport #btnUserCreate")
               .addEventListener("click", App.addons.UserManager.Actions.onUserCreate, false);

           document.querySelector("#viewport #btnUserCreateCancel")
               .addEventListener('click', App.addons.UserManager.Actions.onFormLeave, false);
       }
    },
    Actions: {
        onUserCreate: function () {
            App.log("[Rooms] Room creation requested.");
            var user = new App.TRoom(
                null,
                document.querySelector("#viewport #criName").value,
                document.querySelector("#viewport #criEmail").value,
                null);

            user.passwd = document.querySelector("#viewport #criPwd").value;

            if(user.name.length < 4 || user.location.length < 4){
                document.querySelector("#viewport #cuWarn").classList.remove("hidden");
                return;
            }

            // App.bridge.createRoom(room, function (state, response) {
            //     if(state == 200)
            //     {
            //         App.addons.RoomManager.Actions.onFormLeave();
            //         App.addons.snackbar.show(App.l.getTemplate("template.snackRoomCreated"));
            //     }
            //     else {
            //         App.addons.snackbar.show(App.l.getTemplate("template.snackConFailed"));
            //     }
            // });
        },
        onFormLeave: function () {
            App.addons.router.callBack(App.addons.UserManager.ROUTES.users());
        }
    }
};

App.events.UserManager = new App.TEvent("UserManager", function () {
    var slugUsers = App.addons.UserManager.ROUTES.users();
    App.cache._routes[slugUsers] = new App.TRoute(slugUsers, function () {
        App.addons.UserManager.UI.users()
    });
    var slugCreateUser = App.addons.UserManager.ROUTES.createUser();
    App.cache._routes[slugCreateUser] = new App.TRoute(slugCreateUser, function () {
        App.addons.UserManager.UI.createUser()
    });
});