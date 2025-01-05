let d_chosenYear;
let d_chosenMonth;

let d_last_chosen = 'clean';

let d_date_type = 'year'


document.addEventListener('DOMContentLoaded', () => {
    // Destructure the Calendar constructor
    const { Calendar } = window.VanillaCalendarPro;
    // Create a calendar instance and initialize it.

    var today = new Date();
    var dd = String(today.getDate() + 1).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;


    const inputElement = document.getElementById('input-calendar');
    inputElement.value = convertToMonth(mm - 1) + " " + yyyy;

    let options;

    if (d_date_type === 'month') {
        d_chosenMonth = [convertToShortMonth(mm - 1)];
        d_chosenYear = yyyy;

        options = {
            inputMode: true,
            selectedTheme: 'light',
            positionToInput: "auto",
            type: 'month',
            dateMax: today,
            onClickMonth(self) {
                if (!self.context.inputElement) return;
                if (self.context.selectedMonth || self.context.selectedMonth == 0) {

                    let month = convertToMonth(self.context.selectedMonth);
                    d_chosenMonth = [convertToShortMonth(self.context.selectedMonth)];

                    self.context.inputElement.value = month + " " + self.context.selectedYear;

                    d_chosenYear = self.context.selectedYear;

                    if (d_last_chosen == 'clean')
                        d_cleaning_service();
                    else d_maintenance_service();


                    putValuesInCard();
                    // if you want to hide the calendar after picking a date
                    self.hide();
                } else {
                    self.context.inputElement.value = '';
                }
            },
        }
    } else {
        d_chosenMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        d_chosenYear = yyyy;

        options = {
            inputMode: true,
            selectedTheme: 'light',
            positionToInput: "auto",
            type: 'year',
            dateMax: today,
            onClickYear(self) {
                if (!self.context.inputElement) return;
                if (self.context.selectedYear) {

                    self.context.inputElement.value = self.context.selectedYear;

                    d_chosenMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

                    d_chosenYear = self.context.selectedYear;

                    if (d_last_chosen == 'clean')
                        d_cleaning_service();
                    else d_maintenance_service();


                    putValuesInCard();
                    self.hide();

                } else {
                    self.context.inputElement.value = '';
                }
            },
        }
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

function convertToShortMonth(temp) {
    switch (temp) {
        case 0:
            return 'Jan';
        case 1:
            return 'Feb';
        case 2:
            return 'Mar';
        case 3:
            return 'Apr';
        case 4:
            return 'May';
        case 5:
            return 'Jun';
        case 6:
            return 'Jul';
        case 7:
            return 'Aug';
        case 8:
            return 'Sep';
        case 9:
            return 'Oct';
        case 10:
            return 'Nov';
        case 11:
            return 'Dec';
    }
}


let historical_data;


window.onload = async function () {
    await getHistoricalData();
    d_cleaning_service();
    y_cleaning_service();
    putValuesInCard();
}


async function getHistoricalData() {
    fetch('data.json').then(respose => respose.json()).then(data => {
        historical_data = data;
    }).catch(error => {
        console.error("Error loading the JSON file:", error)
    });

    return new Promise(resolve => {
        setTimeout(() => {
            console.log("Historical data fetched");
            resolve();
        }, 1000); // Simulating async behavior
    });
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

    const year = d_chosenYear;
    const month = d_chosenMonth;

    const serviceTypes = ["regular_cleaning", "detailed_cleaning", "airbnb_cleaning", "move_out_in_cleaning", "other"]

    const temp = getServiceValues(historical_data, year, month, serviceTypes)

    if (d_date_type === 'month') {
        demand_per_service_data = getValuesByMonth(temp, month[0]);
    } else {
        demand_per_service_data = getValuesByYear(temp);
    }


    loadDemandPerServiceChart();




    d_last_chosen = 'clean';

}

function d_maintenance_service() {
    const d_button_m = document.getElementById('d-maintenance service');
    d_button_m.classList.add('my-button-selected');
    d_button_m.classList.remove('my-button-unselected');


    const d_button_c = document.getElementById('d-cleaning-service');
    d_button_c.classList.remove('my-button-selected')
    d_button_c.classList.add('my-button-unselected');

    demand_per_service_categories = ["Home renovation", "Drywall repair", "Painting", "Pressure Washing"];

    const year = d_chosenYear;
    const month = d_chosenMonth;
    const serviceTypes = ["home_renovation", "drywall_repair", "painting_service", "pressure_washing"]

    const temp = getServiceValues(historical_data, year, month, serviceTypes)


    if (d_date_type === 'month') {
        demand_per_service_data = getValuesByMonth(temp, month[0]);
    } else {
        demand_per_service_data = getValuesByYear(temp);
    }



    loadDemandPerServiceChart();

    d_last_chosen = 'maintain';
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



function getServiceValues(data, year, months, serviceTypes) {
    return months.map(month => {
        const entry = data.find(e => e.year === year && e.month === month); // Find the matching entry for each month
        if (!entry) {
            return { month, values: Array(serviceTypes.length).fill(0) }; // Default to 0 for all service types if the month is not found
        }
        // Extract values for all requested service types
        const values = serviceTypes.map(type => entry[type] || 0);
        return {
            month: entry.month,
            values
        };
    });
}


function getValuesByMonth(data, targetMonth) {
    const entry = data.find(item => item.month === targetMonth);
    return entry ? entry.values : null; // Return values if found, otherwise null
}


function getValuesByYear(data) {

    if (d_last_chosen === 'clean') {
        let columnSums = [0, 0, 0, 0, 0];

        // Loop through the data and sum the values
        data.forEach(entry => {
            entry.values.forEach((value, index) => {
                columnSums[index] += value; // Add the value to the corresponding column
            });
        });

        return columnSums;
    }
}


function putValuesInCard() {

    if (d_date_type === 'month') {
        const year1 = d_chosenYear;
        const month1 = d_chosenMonth;
        const serviceTypes1 = ["regular_cleaning", "detailed_cleaning", "airbnb_cleaning", "move_out_in_cleaning", "other"]

        const temp1 = getServiceValues(historical_data, year1, month1, serviceTypes1)

        demand_per_service_data1 = getValuesByMonth(temp1, month1[0]);

        const sum1 = demand_per_service_data1.reduce((accumulator, currentValue) => accumulator + currentValue, 0);

        document.getElementById('clean-card').textContent = sum1;

        const year = d_chosenYear;
        const month = d_chosenMonth;
        const serviceTypes = ["home_renovation", "drywall_repair", "painitng_service", "pressure_washing"]

        const temp = getServiceValues(historical_data, year, month, serviceTypes)

        demand_per_service_data = getValuesByMonth(temp, month[0]);

        const sum = demand_per_service_data.reduce((accumulator, currentValue) => accumulator + currentValue, 0);

        document.getElementById('maintain-card').textContent = sum;
    } else {
        const year1 = d_chosenYear;
        const month1 = d_chosenMonth;
        const serviceTypes1 = ["regular_cleaning", "detailed_cleaning", "airbnb_cleaning", "move_out_in_cleaning", "other"]

        const temp1 = getServiceValues(historical_data, year1, month1, serviceTypes1)

        demand_per_service_data1 = getValuesByYear(temp1, month1);

        const sum1 = demand_per_service_data1.reduce((accumulator, currentValue) => accumulator + currentValue, 0);

        document.getElementById('clean-card').textContent = sum1;
    }
}