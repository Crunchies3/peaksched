$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var serviceId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        serviceId = table.row(e.target.closest('tr')).data();
        document.getElementById('serviceId').value = serviceId[0];
    });
});

$('#myTable').DataTable({
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'col-sm my-button-no rounded mx-2 bi-sort-down-alt',
            }]
        },
    },
    scrollY: 370,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: 0,
            'visible': false
        },
        {
            targets: -1,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="./request-appointment-details.php" id="selectedService" method="get"><input id="serviceId" hidden type="text" name="serviceId" value=""> </form><button form="selectedService" class="btn btn-sm my-button-yes mx-1" id="actionClick">select</button>',
            targets: -1
        },
    ],
});

// var data = $('#myTable').DataTable().rows().data();






var toggle = 0;

$('.my-button-no').on('click', function () {

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
    $(".my-button-no").click(function () {
        $(this).toggleClass("bi-sort-down");
        return true;
    });
});