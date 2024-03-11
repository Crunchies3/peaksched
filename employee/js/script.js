const hamburger = document.querySelector("#toggle-btn");

hamburger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("shrink");
    document.querySelector("#main").classList.toggle("shrink");
});


$('#applyHoursWorked').click(
    function () {
        var hour = document.getElementById("hoursWorked").value;
        var minute = document.getElementById("minutesWorked").value;
        var rows = $("#myTable tr").length - 1;
        for (let i = 0; i < rows; i++) {
            let currInput = document.getElementById("hour" + i);
            currInput.setAttribute('value', hour);
            let currInput2 = document.getElementById("minute" + i);
            currInput2.setAttribute('value', minute);
        }
    }
)

// para dili masubmit kung pisliton ang enter
$(document).on("keydown", ":input:not(textarea)", function (event) {
    return event.key != "Enter";
});
