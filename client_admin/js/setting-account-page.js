$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

$("#showEdit").on("click", function () {
    $("#editAccount").toggle();
    $("#discardChanges").toggle();
    $("#showEdit").toggle();
});

$("#discardChanges").on("click", function () {
    $("#editAccount").toggle();
    $("#discardChanges").toggle();
    $("#showEdit").toggle();
});