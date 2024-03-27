document.addEventListener('DOMContentLoaded', function () {

    var today = new Date();
    var dd = String(today.getDate() + 1).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    const option = {
        settings: {
            iso8601: false,
            visibility: {
                theme: 'light',
                weekend: false,
            },
            range: {
                min: today,
                disableWeekday: [0],
                disabled: [''],

            },
        },
        actions: {
            clickDay(event, self) {
                var element = document.getElementById("selectedDate");
                element.setAttribute('value', self.selectedDates);
            },
        }
    }

    const calendar = new VanillaCalendar('#calendar', option);
    calendar.init();
});