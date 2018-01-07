App.addons.rest = {

    uri: function () {
        return App.cache._backenduri;
    },

    sendRequest: function (path, type, data, callback) {
        var params = typeof data == 'string' ? data : Object.keys(data).map(
            function (k) {
                return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
            }
        ).join('&');
        var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        xhr.open(type, this.uri()+path);
        xhr.onreadystatechange = function () {
            try {
                var obj = JSON.parse(xhr.responseText);
            } catch (e){
                if(App.debug){ console.log(e) }
            }
            if(App.debug){
                console.log("[APIRequest]");
                console.log(data);
                console.log([path, type, xhr.status].join(" "));
                console.log(obj);
            }
            if (xhr.readyState > 3) {
                callback(xhr.status, obj)
            }
        };
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(params);
    }

};

App.bridge = {

    TYPES: {
        POST: "POST",
        GET: "GET",
        DELETE: "DELETE",
        PUT: "PUT"
    },

    sendRequest: function (path, type, data, callback) {
        App.addons.rest.sendRequest(path, type, data, callback);
    },

    createSession: function (session, callback) {
        this.sendRequest("session",
            this.TYPES.POST,
            {
                email: session.email,
                password: session.passwd
            }, function (state, response) {
                callback(state, response)
            })
    },

    getSession: function (callback) {
        this.sendRequest("session",
            this.TYPES.GET,
            {},
            function (state, response) {
                callback(state,response)
            })
    },

    removeSession: function (callback) {
        this.sendRequest("session",
            this.TYPES.DELETE,
            {},
            function (state, response) {
                callback(state, response)
            })
    },

    getRooms: function (callback) {
        this.sendRequest("rooms",
            this.TYPES.GET,
            {},
            function (state, response) {
                callback(state,response)
            })
    },

    getReservationsByRoom: function (id) {},

    createRoom: function (room) {},

    updateRoom: function (room) {},

    removeRoom: function (room) {},

    createReservation: function (reservation) {},

    updateReservation: function (reservation) {},

    removeReservation: function (reservation) {},

    getUsers: function () {},

    createUser: function (user) {},

    updateUser: function (user) {},

    removeUser: function (user) {}

};