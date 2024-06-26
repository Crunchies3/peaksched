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
            document.getElementById("addAppointment").reset();
            document.getElementById("selectedDateApp").value = currDate;
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
            $("#editAppointment").modal("show");
            var eventDate = moment(info.event.start).format("YYYY-MM-DD");
            document.getElementById("customerList").value = info.event.title;
            document.getElementById("selectedDate").value = eventDate;
            document.getElementById("serviceList").value = info.event.extendedProps.service;
            document.getElementById("supervisorList").value = info.event.extendedProps.supervisor;
            document.getElementById("appointmentId").value = info.event.id;
            document.getElementById("editNote").value = info.event.extendedProps.note;
            var eventTime = moment(info.event.start).format("HH:mm");
            const tempEventDate = new Date(`2000-01-01T${eventTime}`);
            tempEventDate.setHours(tempEventDate.getHours() - 8);
            const adjustedEventStart = tempEventDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            document.getElementById("start").value = adjustedEventStart;
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

