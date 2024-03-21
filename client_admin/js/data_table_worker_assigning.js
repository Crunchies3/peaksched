$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var workerId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        workerId = table.row(e.target.closest('tr')).data();
        var supId = document.getElementById('supId').value;
        document.getElementById('workerId').value = workerId[0];
        document.getElementById('superId').value = supId;
    });
});

$('#myTable').DataTable({

    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt',
            }]
        },
    },
    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    columnDefs: [
        {
            targets: 0,
            visible: false
        },
        {
            targets: -2,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form id="addWorkerForm" action="worker_assigning_page.php" method="post"><input id="workerId" name="workerId" hidden type="text" value=""><input id="superId" hidden name="supervisorId" type="text" value=""></form><button data-bs-target="#addWorkerModal"  data-bs-toggle = "modal" class="btn my-button-yes mx-1" id="actionClick">Add</button>',
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