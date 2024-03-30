$('#serviceList').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("serviceList");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.classList.add("selecServiceInput");
    element.placeholder = "Select a service";
    element.name = "selectedService";
}

$('#positionList').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("positionList");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.placeholder = "Select a position";
    element.name = "position";
}



$('#serviceList2').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("serviceList2");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.classList.add("selecServiceInput");
    element.placeholder = "Select a service";
    element.name = "selectedService";
}


$('#supervisorList2').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("supervisorList2");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.classList.add("selecServiceInput");
    element.placeholder = "Add a supervisor";
    element.name = "selectedSupervisor";
}




$('#customerList2').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("customerList2");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.classList.add("selecServiceInput");
    element.placeholder = "Add a customer";
    element.name = "selectedCustomer";
}



$('#supervisorList').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("supervisorList");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.classList.add("selecServiceInput");
    element.placeholder = "Add a supervisor";
    element.name = "selectedSupervisor";
}



$('#supervisorList3').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("supervisorList3");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.placeholder = "Assign a supervisor";
    element.name = "selectedSupervisor";
}


$('#customerList').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("customerList");
if (element) {
    element.classList.add("form-control");
    element.classList.add("input-field");
    element.classList.add("selecServiceInput");
    element.placeholder = "Add a customer";
    element.name = "selectedCustomer";
}
