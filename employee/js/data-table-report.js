$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var reportId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        reportId = table.row(e.target.closest('tr')).data();
        document.getElementById('reportId').value = reportId[0];
    });
});

$('#myTable').DataTable({
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt',
            },
            ]
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
            targets: -3,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="view-details.php" id="addAppoitment" method="get"><input id="reportId" hidden type="text" name="reportId" value=""></form><button form="addAppoitment" class="btn my-button-yes mx-1" id="actionClick">View</button>',
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