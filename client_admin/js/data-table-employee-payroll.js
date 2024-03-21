$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var payrollId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        employeeid = table.row(e.target.closest('tr')).data();
        document.getElementById('employeeid').value = employeeid[0];
    });
});

$('#myTable').DataTable({
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt my-button-no',
            }, {
                text: '<i class="bi bi-plus plus-icon"></i> approve payroll',
                className: 'my-button-yes rounded',
                action: function () {
                    location.href = '';
                }
            }]
        },
    },
    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: 0,
            'visible' : false
        },
        {
            targets: 1,
            className: "right-aligned-cell"
        },
        {
            targets: 2,
            className: "right-aligned-cell"
        },
        {
            targets: 3,
            className: "right-aligned-cell"
        },
        {
            targets: 4,
            className: "right-aligned-cell"
        },
        {
            targets: 5,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="../payroll/view-payslip-detail.php" id="viewPayroll" method="get"><input id="employeeid" hidden type="text" name="employeeid" value=""></form><button form="viewPayroll" class="btn my-button-yes mx-1" id="actionClick">View</button>',
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