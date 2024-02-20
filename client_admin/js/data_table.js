$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        let data = table.row(e.target.closest('tr')).data();
        alert(data[1]);
    });
});

$('#myTable').DataTable({
    stateSave: true,
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt',
            }, {
                text: '<i class="bi bi-plus plus-icon"></i> add service',
                className: 'add-service-btn rounded'
            }]
        },
    },
    buttons: true,
    scrollY: 450,
    responsive: true,
    language: {
        emptyTable: 'No data available in table'
    },
    columnDefs: [
        {
            data: null,
            defaultContent: '<button id="actionClick">Click!</button>',
            targets: -1
        }
    ]
});

// var data = $('#myTable').DataTable().rows().data();






var toggle = 0;

$('.sort-btn').on('click', function () {

    if (toggle == 0) {
        table.order([
            [0, 'asc']
        ]).draw();
        toggle = 1;
    } else if (toggle == 1) {
        table.order([
            [0, 'desc']
        ]).draw();
        toggle = 2;
    } else {
        table.order([
            [0, '']
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