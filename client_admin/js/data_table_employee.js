$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var employeeId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        employeeId = table.row(e.target.closest('tr')).data();
        document.getElementById('employeeId').value = employeeId[0];
    });
});

$('#myTable').DataTable({
    responsive: true,
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt',
            }, {
                text: '<i class="bi bi-plus plus-icon"></i> add employee',
                className: 'my-button-yes rounded',
                action: function () {
                    location.href = 'employee_adding_page.php'
                }
            }]
        },
    },
    order: [1, 'asc'],
    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: 0,
            'visible': false
        },
        {
            targets: [4, 5],
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="./employee_editing_page.php" id="editEmployee" method="get"><input id="employeeId" hidden type="text" name="employeeId" value=""></form><button form="editEmployee" class="btn my-button-yes mx-1" id="actionClick">View</button>',
            targets: -1
        },
    ],
});


// var data = $('#myTable').DataTable().rows().data();





var toggle = 0;

$('.sort-btn').on('click', function () {

    if (toggle == 0) {
        table.order([
            [1, 'asc']
        ]).draw();
        toggle = 1;
    } else if (toggle == 1) {
        table.order([
            [1, 'desc']
        ]).draw();
        toggle = 2;
    } else {
        table.order([
            [1, '']
        ]).draw();
        toggle = 0;
    }
});

$(function () {
    $(".sort-btn").click(function () {
        $(this).toggleClass("bi-sort-down");
        return true;
    });
});

// !sugod copy

// ? para ma disable ang submit on enter
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

$("#showEdit").on("click", function () {
    $("#editEmployee").toggle();
    $("#discardChanges").toggle();
    $("#showEdit").toggle();
});

$("#discardChanges").on("click", function () {
    $("#editEmployee").toggle();
    $("#discardChanges").toggle();
    $("#showEdit").toggle();
});
// !end copy