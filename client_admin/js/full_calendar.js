document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        timeZone: 'UTC',
        fixedWeekCount: false,
        height: "100%",
        selectable: true,
        dateClick: function () {
            $("#exampleModal").modal("show");
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
            info.el.style.borderColor = 'black';
            $("#exampleModal").modal("show");
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

