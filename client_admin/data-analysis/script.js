document.addEventListener('DOMContentLoaded', () => {
    // Destructure the Calendar constructor
    const { Calendar } = window.VanillaCalendarPro;
    // Create a calendar instance and initialize it.

    var today = new Date();
    var dd = String(today.getDate() + 1).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    console.log(today);

    const inputElement = document.getElementById('input-calendar');
    inputElement.value = convertToMonth(mm - 1) + " " + yyyy;



    const options = {
        inputMode: true,
        selectedTheme: 'light',
        positionToInput: "auto",
        type: 'month',
        dateMax: today,
        onClickMonth(self) {
            if (!self.context.inputElement) return;
            if (self.context.selectedMonth || self.context.selectedMonth == 0) {

                let month = convertToMonth(self.context.selectedMonth);

                self.context.inputElement.value = month + " " + self.context.selectedYear;
                // if you want to hide the calendar after picking a date
                self.hide();
            } else {
                self.context.inputElement.value = '';
            }
        },
    }

    const calendar = new Calendar('#input-calendar', options);
    calendar.init();
});


document.addEventListener('DOMContentLoaded', () => {
    // Destructure the Calendar constructor
    const { Calendar } = window.VanillaCalendarPro;
    // Create a calendar instance and initialize it.

    var today = new Date();
    var dd = String(today.getDate() + 1).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    console.log(today);

    const inputElement = document.getElementById('input-calendar-year');
    inputElement.value = yyyy;


    const options = {
        inputMode: true,
        selectedTheme: 'light',
        positionToInput: "auto",
        type: 'year',
        dateMax: today,
        onClickYear(self) {
            if (!self.context.inputElement) return;
            if (self.context.selectedYear) {
                self.context.inputElement.value = self.context.selectedYear;
                self.hide();
            } else {
                self.context.inputElement.value = '';
            }
        },
    }

    const calendar = new Calendar('#input-calendar-year', options);
    calendar.init();
});


function convertToMonth(temp) {
    switch (temp) {
        case 0:
            return 'January';
        case 1:
            return 'February';
        case 2:
            return 'March';
        case 3:
            return 'April';
        case 4:
            return 'May';
        case 5:
            return 'June';
        case 6:
            return 'July';
        case 7:
            return 'August';
        case 8:
            return 'September';
        case 9:
            return 'October';
        case 10:
            return 'November';
        case 11:
            return 'December';
    }
}
