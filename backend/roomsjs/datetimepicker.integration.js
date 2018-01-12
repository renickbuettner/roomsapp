App.addons.DateTimePicker = {

    initSingleRoom: function () {

        flatpickr(document.querySelector("#viewport #rangepicker"), {
            dateFormat: "d.m.Y",
            maxDate: new Date().fp_incr(365),
            //minDate: "today",
            //"disable": [
            //    function(date) { return (date.getDay() === 6 || date.getDay() === 0);}
            //],
            "locale": {
                "firstDayOfWeek": 1
            },
            onChange: App.addons.DateTimePicker.Utils.requestReservations,
            onReady: App.addons.DateTimePicker.Utils.requestReservations,
            defaultDate: "today"
        });
    },
    Utils: {
        requestReservations: function(selectedDates, dateStr, instance) {
            console.log(selectedDates[0].toUTCString() + " = " + (moment(selectedDates[0].toUTCString()).unix()));
            App.addons.RoomManager.Actions.loadReservations(
                App.addons.RoomManager.getCurrentRoom(),
                (moment(selectedDates[0].toUTCString()).unix()),
                (moment(selectedDates[0].toUTCString()).add(24, 'hours').unix())
            )
        }
    }
};