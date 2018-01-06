function TUser(name, uuid){
    this.name     = name;
    this.uuid     = uuid;
}

TUser.prototype = {
    getView: function () {
        return new TView(this.name, App.getTemplate("template.room"), {
            "\\$room": this.name,
            "\\$building": this.location,
            "\\$currentState": "undefined yet"
        })
    },
    delete: function () {
    },
    changePwd: function () {
    }
};