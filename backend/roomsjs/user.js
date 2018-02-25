App.TUser = function(uuid, name, email, group){
    this.name  = name;
    this.uuid  = uuid;
    this.email = email;
    this.group = group;
};

App.TUser.prototype = {
    getView: function () {
        return new App.TView(this.name, App.l.getTemplate("template.user"), {
            "\\$name": this.name,
            "\\$email": this.email,
            "\\$group": this.getGroup(),
            "\\$href": "#" + App.addons.UserManager.ROUTES.singleUser(this.uuid)
        })
    },
    getGroup: function () {
        if(this.group > 50)
        {
            return App.l.getElemById("template.groupSU").innerText
        }
        else {
            return App.l.getElemById("template.groupTC").innerText
        }
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
        singleUser: function (id) {
            return this.users() + "/view/" + id;
        }
    },
    UI: {
       users: function () {
           App.bridge.getUsers(function (state, response) {
               if(state = 200)
               {
                   var body = "";
                   for(var i=0; i < response.length; i++)
                   {
                       body += (new App.TUser(
                           response[i].uuid,
                           response[i].name,
                           response[i].email,
                           response[i].group
                       ).getView().html())
                   }
                   App.l.loadView(
                       new App.TView("Users", App.l.getTemplate("template.userContainer"), {
                           "\\$users": body
                       })
                   );

                   document.querySelector("#viewport #btnContAction")
                       .addEventListener("click", App.addons.UserManager.UI.createUser, false);

               }
               else {
                    App.addons.snackbar.show(App.l.getTemplate("template.snackConFailed"));
               }
           });

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
            var user = new App.TUser(
                null,
                document.querySelector("#viewport #cuName").value,
                document.querySelector("#viewport #cuEmail").value,
                document.querySelector("#viewport #cuSU").value);

            user.passwd = document.querySelector("#viewport #cuPwd").value;

            if(user.name.length < 4 || user.email.length < 6){
                document.querySelector("#viewport #cuWarn").classList.remove("hidden");
                return;
            }

            App.bridge.createUser(user, function (state, response) {
               if(state == 200)
               {
                   App.addons.UserManager.Actions.onFormLeave();
                   App.addons.snackbar.show(App.l.getTemplate("template.snackUserCreated"));
               }
               else {
                   App.addons.snackbar.show(App.l.getTemplate("template.snackConFailed"))
               }
            });

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