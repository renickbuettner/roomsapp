App.addons.snackbar = {};
App.addons.snackbar.show = function (body) {
    var elem = App.l.getElemById("snackbar");
    elem.classList.add("show");
    elem.innerHTML = body;
    setTimeout(function () {
        var elem = App.l.getElemById("snackbar");
        elem.classList.remove("show");
        elem.innerHTML = "";
    }, 3000);
};