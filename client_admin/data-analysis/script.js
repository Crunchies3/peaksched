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

window.onload = function () {
    d_cleaning_service();
    y_cleaning_service();
}


let demand_per_service_categories;
let demand_per_service_data;

let year_per_service_categories;
let year_per_service_data;


function d_cleaning_service() {

    const d_button_m = document.getElementById('d-maintenance service');
    d_button_m.classList.remove('my-button-selected');
    d_button_m.classList.add('my-button-unselected');

    const d_button_c = document.getElementById('d-cleaning-service');
    d_button_c.classList.add('my-button-selected')
    d_button_c.classList.remove('my-button-unselected');

    demand_per_service_categories = ["Regular", "Detailed", "Air-BNB", "Move-in/out", "Other"];
    demand_per_service_data = [100, 52, 88, 69, 80, 90];

    loadDemandPerServiceChart();

}

function d_maintenance_service() {
    const d_button_m = document.getElementById('d-maintenance service');
    d_button_m.classList.add('my-button-selected');
    d_button_m.classList.remove('my-button-unselected');


    const d_button_c = document.getElementById('d-cleaning-service');
    d_button_c.classList.remove('my-button-selected')
    d_button_c.classList.add('my-button-unselected');

    demand_per_service_categories = ["Home renovation", "Drywall repair", "Painting", "Pressure Washing"];
    demand_per_service_data = [40, 60, 75, 55];

    loadDemandPerServiceChart();
}



function y_cleaning_service() {

    const y_button_m = document.getElementById('y-maintenance service');
    y_button_m.classList.remove('my-button-selected');
    y_button_m.classList.add('my-button-unselected');

    const y_button_c = document.getElementById('y-cleaning-service');
    y_button_c.classList.add('my-button-selected')
    y_button_c.classList.remove('my-button-unselected');

    year_per_service_categories = ["Regular Cleaning", "Detailed Cleaning", "Air-BNB cleaning", "Move-in/out cleaning", "Other"];
    year_per_service_data = [[69, 93, 132, 161, 152, 133, 111, 113, 92, 75, 60, 55], [53, 61, 90, 131, 128, 109, 113, 74, 70, 65, 51, 44],
    [2, 5, 15, 11, 15, 16, 21, 22, 5, 2, 8, 3], [3, 3, 3, 4, 4, 6, 9, 8, 10, 8, 4, 3], [6, 5, 2, 3, 4, 2, 3, 1, 4, 7, 5, 3]];

    console.log(year_per_service_categories);

    loadYearlyDemandPerServiceChart();

}

function y_maintenance_service() {
    const y_button_m = document.getElementById('y-maintenance service');
    y_button_m.classList.add('my-button-selected');
    y_button_m.classList.remove('my-button-unselected');


    const y_button_c = document.getElementById('y-cleaning-service');
    y_button_c.classList.remove('my-button-selected')
    y_button_c.classList.add('my-button-unselected');

    year_per_service_categories = ["Home renovation", "Drywall repair", "Painting", "Pressure Washing"];
    year_per_service_data = [[2, 5, 15, 11, 15, 16, 21, 22, 5, 2, 8, 3], [69, 93, 132, 161, 152, 133, 111, 113, 92, 75, 60, 55],
    [6, 5, 2, 3, 4, 2, 3, 1, 4, 7, 5, 3], [53, 61, 90, 131, 128, 109, 113, 74, 70, 65, 51, 44]];

    loadYearlyDemandPerServiceChart();
}


function loadDemandPerServiceChart() {
    var demand_per_service = document.getElementById("demand-per-service")
    var myChart_demand_per_service = echarts.init(demand_per_service)
    var option_demand_per_service
    option_demand_per_service = {
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "shadow"
            }
        },
        grid: {
            left: "3%",
            right: "4%",
            bottom: "3%",
            containLabel: true
        },
        xAxis: [
            {
                type: "category",
                data: demand_per_service_categories,
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: [
            {
                type: "value"
            }
        ],
        series: [
            {
                type: "bar",
                barWidth: "60%",
                data: demand_per_service_data
            }
        ]
    }

    option_demand_per_service && myChart_demand_per_service.setOption(option_demand_per_service)
}


function loadYearlyDemandPerServiceChart() {


    var yearly_service2 = document.getElementById("yearly_service-2")
    var myChart_yearly_service2 = echarts.init(yearly_service2)
    var option_yearly_service2


    option_yearly_service2 = {
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "shadow"
            }
        },
        legend: {
            data: year_per_service_categories
        },
        grid: {
            left: "3%",
            right: "4%",
            bottom: "3%",
            containLabel: true
        },
        xAxis: [

            {
                type: "category",
                data: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: year_per_service_categories[0],
                data: year_per_service_data[0],
                type: 'line',
                smooth: true,
                showSymbol: false
            },
            {
                name: year_per_service_categories[1],
                data: year_per_service_data[1],
                type: 'line',
                smooth: true,
                showSymbol: false
            },
            {
                name: year_per_service_categories[2],
                data: year_per_service_data[2],
                type: 'line',
                smooth: true,
                showSymbol: false
            },
            {
                name: year_per_service_categories[3],
                data: year_per_service_data[3],
                type: 'line',
                smooth: true,
                showSymbol: false
            },
            {
                name: year_per_service_categories[4],
                data: year_per_service_data[4],
                type: 'line',
                smooth: true,
                showSymbol: false
            },
        ]
    }
    myChart_yearly_service2.setOption(option_yearly_service2)
}
