document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        timeZone: 'UTC',
        fixedWeekCount: false,
        height: "100%",
        selectable: true,
        dateClick: function (info) {
            var currDate = info.dateStr;
            $("#appointment").modal("show");
            document.getElementById("selectedDate").value = currDate;
        },
        windowResizeDelay: 0,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        dayMaxEvents: true,
        events: './php/fetchAppointments.php',

        eventClick: function (info) {
            $("#appointment").modal("show");
            var eventDate = moment(info.event.start).format("YYYY-MM-DD");
            document.getElementById("eventTitle").value = info.event.title;
            document.getElementById("selectedDate").value = eventDate;
            document.getElementById("selectedTime").value = eventTime;
            // alert('Event: ' + info.event.title);
            // alert('id: ' + info.event.id);
            // alert('desc: ' + info.event.extendedProps.description);
        },

        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
            meridiem: true
        }
    });
    calendar.render();

    var hamburger = document.querySelector('#toggle-btn');
    hamburger.addEventListener('click', function () {
        setTimeout(function () {
            window.dispatchEvent(new Event('resize'));
        }, 80);
    });

});

