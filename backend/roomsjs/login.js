App.events["onLogin"] = new App.TEvent("onLogin", function () {
    App.l.getElemById("btnLogin").onclick = function () {

        var email   = App.l.getElemById("loginInputEmail").value,
            passwd  = App.l.getElemById("loginInputPasswd").value;

        App.cache.session = new App.TSession(email, passwd);
        App.cache.session.create(function (state, response) {
            if (state !== 200) {
                App.addons.snackbar.show(App.getTemplate("template.snackLoginFailed"));
            }
            else {
                App.addons.session.setup(response);
            }
        });
    };
    App.l.getElemById("btnLogout").onclick = function () {
        App.addons.session.remove()
    }
});