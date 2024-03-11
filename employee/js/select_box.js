$('#hoursWorked').editableSelect({
    effects: 'fade',
});

var element = document.getElementById("hoursWorked");
element.classList.add("form-control");
element.classList.add("input-field");
element.name = "hour";
element.type = "number";
