$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var workerId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        workerId = table.row(e.target.closest('tr')).data();
        var appointmentId = document.getElementById('appointmentId').value;
        document.getElementById('workerId').value = workerId[0];
        document.getElementById('appointId').value = appointmentId;
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
            {
                text: '<i class="bi bi-plus plus-icon"></i> assign workers',
                className: 'my-button-yes rounded',
                action: function () {
                    var appointmentId = document.getElementById('appointmentId').value;
                    location.href = 'assign-workers.php?appointmentId=' + '' + appointmentId;
                }
            }],

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
            data: null,
            defaultContent: '<form id="RemoveWorkerForm" method="post"><input id="workerId" name="workerId" hidden type="text" value=""><input id="appointId" name="appointmentId" hidden type="text" value=""></form><button data-bs-target="#RemoveWorker"  data-bs-toggle = "modal" class="btn my-button-yes mx-1" id="actionClick">Remove</button>',
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
