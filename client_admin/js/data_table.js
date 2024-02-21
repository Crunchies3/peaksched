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
                className: 'sort-btn rounded mx-2 bi-sort-down-alt',
            }, {
                text: '<i class="bi bi-plus plus-icon"></i> add service',
                className: 'add-service-btn rounded',
                action: function () {
                    location.href = 'service_adding_page.php'
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
            'visible': false
        },
        {
            data: null,
            defaultContent: '<form action="./service_editing_page.php" id="editService" method="get"><input id="serviceId" hidden type="text" name="serviceId" value=""> </form><button form="editService" class="btn btn-primary mx-1" id="actionClick">edit</button>',
            targets: -1
        },
        {

        }
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