const services_button = document.getElementById('service_btn');
const cleaning_button = document.getElementById('cleaning_btn');
const maintain_button = document.getElementById('maintain_btn');
const myForm = document.getElementById('my_form');
const forecast_button = document.getElementById('forecast_button');
let selected_services = [];
let yAxis = [];


toggleButtonState();

window.onLoad = service_check();

function service_check() {

    services_button.classList.add('my-button-selected');
    services_button.classList.remove('my-button-unselected');

    cleaning_button.classList.remove('my-button-selected');
    cleaning_button.classList.add('my-button-unselected');

    maintain_button.classList.remove('my-button-selected');
    maintain_button.classList.add('my-button-unselected');



    const checkBoxesHTML = `  <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                value="Cleaning Service">
                            <label class="form-check-label" for="inlineCheckbox1">Cleaning Service</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                value="Maintenance Service">
                            <label class="form-check-label" for="inlineCheckbox2">Maintenance Service</label>
                        </div>`;
    myForm.innerHTML = checkBoxesHTML;

    document.querySelectorAll(".form-check-input").forEach(checkbox => {
        checkbox.addEventListener("change", toggleButtonState);
    });

    toggleButtonState();
}

function cleaning_check() {

    cleaning_button.classList.add('my-button-selected');
    cleaning_button.classList.remove('my-button-unselected');

    services_button.classList.remove('my-button-selected');
    services_button.classList.add('my-button-unselected');

    maintain_button.classList.remove('my-button-selected');
    maintain_button.classList.add('my-button-unselected');

    const checkBoxesHTML = `   <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                value="regular_cleaning">
                            <label class="form-check-label" for="inlineCheckbox1">Regular</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                value="detailed_cleaning">
                            <label class="form-check-label" for="inlineCheckbox2">Detailed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                value="airbnb_cleaning">
                            <label class="form-check-label" for="inlineCheckbox3">Air BNB</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                value="move_out_in_cleaning">
                            <label class="form-check-label" for="inlineCheckbox4">Move-in/out</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="other">
                            <label class="form-check-label" for="inlineCheckbox5">Other</label>
                        </div>`;

    myForm.innerHTML = checkBoxesHTML;

    document.querySelectorAll(".form-check-input").forEach(checkbox => {
        checkbox.addEventListener("change", toggleButtonState);
    });

    toggleButtonState();
}

function maintain_check() {

    maintain_button.classList.add('my-button-selected');
    maintain_button.classList.remove('my-button-unselected');

    cleaning_button.classList.remove('my-button-selected');
    cleaning_button.classList.add('my-button-unselected');

    services_button.classList.remove('my-button-selected');
    services_button.classList.add('my-button-unselected');


    const checkBoxesHTML = `  <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="home_renovation">
                            <label class="form-check-label" for="inlineCheckbox1">Home Renovation</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="drywall_repair">
                            <label class="form-check-label" for="inlineCheckbox2">Drywall Repair</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="painting_service">
                            <label class="form-check-label" for="inlineCheckbox3">Painting</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="pressure_washing">
                            <label class="form-check-label" for="inlineCheckbox4">Pressure Washing</label>
                        </div>`;

    myForm.innerHTML = checkBoxesHTML;

    document.querySelectorAll(".form-check-input").forEach(checkbox => {
        checkbox.addEventListener("change", toggleButtonState);
    });

    toggleButtonState();
}

async function forecast() {
    yAxis.length = 0;

    selected_services = [];
    const checkboxes = document.querySelectorAll(".form-check-input");

    for (const checkbox of checkboxes) {
        if (checkbox.checked) {
            selected_services.push(checkbox.value); // Add value to array if checkbox is selected
            months_ahead = 12;
            switch (checkbox.value) {
                case "Cleaning Service":
                    await cleaning_service();
                    break;
                case "Maintenance Service":
                    await maintenance_service();
                    break;
                case "regular_cleaning":
                    await regular_cleaning(); // Wait for regular_cleaning to finish
                    break;
                case "detailed_cleaning":
                    await detailed_cleaning();
                    break;
                case "airbnb_cleaning":
                    await airbnb_cleaning();
                    break;
                case "move_out_in_cleaning":
                    await move_out_in_cleaning();
                    break;
                case "other":
                    await other_cleaning();
                    break;
                case "home_renovation":
                    await home_renovation();
                    break;
                case "drywall_repair":
                    await drywall_repair();
                    break;
                case "painting_service":
                    await painting_service();
                    break;
                case "pressure_washing":
                    await pressure_washing();
                    break;
            }
        }
    }

    yAxis = selected_services.map((service, index) => ({
        name: service,
        data: collections_of_predicted_values[index],
        type: 'line',
        smooth: true,
        showSymbol: false,
    }));

    loadForecastChart();

    console.log(yAxis);

    collections_of_predicted_values = [];

}



function toggleButtonState() {

    const checkboxes = document.querySelectorAll(".form-check-input");
    const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    forecast_button.disabled = !anyChecked;
}


function loadForecastChart() {
    var forecast_chart = document.getElementById("forecast_chart")
    var myChart_yearly_service3 = echarts.init(forecast_chart)
    var option_yearly_service3

    option_yearly_service3 = {
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "shadow"
            }
        },
        legend: {
            data: selected_services
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
        series: yAxis
    }
    myChart_yearly_service3.setOption(option_yearly_service3)
}



