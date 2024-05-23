$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var payrollId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        payrollId = table.row(e.target.closest('tr')).data();
        document.getElementById('payslipId').value = payrollId[0];
    });
});

$('#myTable').DataTable({
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt my-button-no',
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
            className: "right-aligned-cell"
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
            targets: 6,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="../payroll/view-payslip-detail.php" id="editPayroll" method="get"><input id="payslipId" hidden type="text" name="payslipId" value=""></form><button form="editPayroll" class="btn my-button-yes mx-1" id="actionClick">view</button>',
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