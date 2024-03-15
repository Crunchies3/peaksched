$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var notificationId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        notificationId = table.row(e.target.closest('tr')).data();
        document.getElementById('notificationId').value = notificationId[0];

    });
});

$('#myTable').DataTable({
    layout: {
        topStart: null,
        topEnd: null,
        bottomStart: null
    },
    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: 0,
            visible: false
        },
        {
            data: null,
            defaultContent: '<form action="view-details.php" id="viewNotification" method="get"><input id="notificationId" hidden type="text" name="notificationId" value=""></form><button form="viewNotification" class="btn btn-sm my-button-yes mx-1" id="actionClick">View</button>',
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