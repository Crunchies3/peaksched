$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var appointmentId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        appointmentId = table.row(e.target.closest('tr')).data();
        document.getElementById('appointmentId').value = appointmentId[0];
    });
});

$('#myTable').DataTable({
    responsive: true,
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'col-sm my-button-no rounded mx-2 bi-sort-down-alt',
            }],
        },
        top1: {
            searchPanes: {
                initCollapsed: true,
                preSelect: [
                    {
                        rows: ['Pending Approval', 'Denied', 'Approved'],
                        column: 2
                    }
                ]
            }
        }
    },
    select: {
        style: 'os',
        selector: 'td:first-child'
    },
    //order para ma sort by time. first number is ang cell sa date
    order: [[3, 'asc'], [4, 'asc']],
    scrollY: 370,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: -1,
            className: "right-aligned-cell"
        },
        {
            targets: 0,
            className: "right-aligned-cell"
        },
        {
            targets: -2,
            className: "right-aligned-cell"
        },
        {
            targets: -3,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="./manage-appointment-details.php" id="selectedAppointment" method="get"><input id="appointmentId" hidden type="text" name="appointmentId" value=""> </form><button form="selectedAppointment" class="btn btn-sm my-button-yes mx-1" id="actionClick">view</button>',
            targets: -1
        },
        {
            searchPanes: {
                show: true,
                orderable: false,
                options: [
                    {
                        label: 'Denied',
                        value: function (rowData, rowIdx) {
                            return rowData[2] == '<span class="badge rounded-pill my-badge-denied">Denied</span>';
                        }
                    },
                    {
                        label: 'Pending Approval',
                        value: function (rowData, rowIdx) {
                            return rowData[2] == '<span class="badge rounded-pill my-badge-pending">Pending Approval</span>';
                        }
                    },
                    {
                        label: 'Completed',
                        value: function (rowData, rowIdx) {
                            return rowData[2] == '<span class="badge rounded-pill my-badge-denied">Completed</span>';
                        }
                    },
                    {
                        label: 'Approved',
                        value: function (rowData, rowIdx) {
                            return rowData[2] == '<span class="badge rounded-pill my-badge-denied">Approved</span>';
                        }
                    }
                ],
                combiner: 'or'
            },
            targets: [2]
        }
    ],
});

$('#myTable').on('select', function () {
    $('#myTable').searchPanes('rebuildPane', 0, true);
});

$('#myTable').on('deselect', function () {
    $('#myTable').searchPanes('rebuildPane', 0, true);
});



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