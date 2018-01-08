App.TSession = function (email, passwd) {
    this.email  = email;
    this.passwd = passwd;
};

App.TSession.prototype.create = function (callback) {
    App.bridge.createSession(this, callback);
};

App.addons.session = {
    alreadyCreated: function () {
        App.bridge.getSession(function (state, response) {
            if (state !== 200) {}
            else {
                App.addons.session.setup(response);
            }
        })
    },
    setup: function (user) {
        App.cache.user = new App.TUser(
            user.uuid, user.name, user.email, user.group);
        App.l.loadScreen("screen.dashboard");
    },
    remove: function () {
        App.bridge.removeSession(function (state, response) {
            window.location.reload()
        });
    }
};

App.events["session"] = new App.TEvent("session", function () {
    App.addons.session.alreadyCreated();
});
