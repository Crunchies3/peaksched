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
        topEnd: null,
    },
    scrollY: 250,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: 0,
            className: "right-aligned-cell"
        },
        {
            targets: -1,
            className: "right-aligned-cell"
        },

    ],
});



// var data = $('#myTable').DataTable().rows().data();
