const services_button = document.getElementById('service_btn');
const cleaning_button = document.getElementById('cleaning_btn');
const maintain_button = document.getElementById('maintain_btn');
const myForm = document.getElementById('my_form');
const forecast_button = document.getElementById('forecast_button');
let selected_services = [];

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

function forecast() {
    selected_services = [];
    const checkboxes = document.querySelectorAll(".form-check-input");
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            selected_services.push(checkbox.value); // Add value to array if checkbox is selected
        }
    })


}


function toggleButtonState() {

    const checkboxes = document.querySelectorAll(".form-check-input");
    const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    forecast_button.disabled = !anyChecked;
}



