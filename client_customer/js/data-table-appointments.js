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

        //! start copy
        top1: {
            searchPanes: {
                initCollapsed: true,
                preSelect: [
                    {
                        rows: ['Pending Approval', 'Denied', 'Approved', 'Cancelled'],
                        column: 4
                    }
                ]
            }
        }
        //! end copy
    },
    //! start copy
    select: {
        style: 'os',
        selector: 'td:first-child'
    },
    //order para ma sort by time. first number is ang cell sa date
    order: [[3, 'asc'], [5, 'asc']],
    //! end copy

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
            targets: 5,
            'visible': false
        },
        {
            data: null,
            defaultContent: '<form action="./manage-appointment-details.php" id="selectedAppointment" method="get"><input id="appointmentId" hidden type="text" name="appointmentId" value=""> </form><button form="selectedAppointment" class="btn btn-sm my-button-yes mx-1" id="actionClick">view</button>',
            targets: -1
        },
        //! start copy
        {
            searchPanes: {
                show: true,
                orderable: false,
                options: [
                    {
                        label: 'Denied',
                        value: function (rowData, rowIdx) {
                            return rowData[4] == '<span class="badge rounded-pill my-badge-denied">Denied</span>';
                        }
                    },
                    {
                        label: 'Cancelled',
                        value: function (rowData, rowIdx) {
                            return rowData[4] == '<span class="badge rounded-pill my-badge-denied">Cancelled</span>';
                        }
                    },
                    {
                        label: 'Pending Approval',
                        value: function (rowData, rowIdx) {
                            return rowData[4] == '<span class="badge rounded-pill my-badge-pending">Pending Approval</span>';
                        }
                    },
                    {
                        label: 'Completed',
                        value: function (rowData, rowIdx) {
                            return rowData[4] == '<span class="badge rounded-pill my-badge-denied">Completed</span>';
                        }
                    },
                    {
                        label: 'Approved',
                        value: function (rowData, rowIdx) {
                            return rowData[4] == '<span class="badge rounded-pill my-badge-approved">Approved</span>';
                        }
                    }
                ],
                combiner: 'or'
            },
            targets: [4]
        },
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 3, 5, 6]
        }
        //! end copy
    ],
});

//! start copy
$('#myTable').on('select', function () {
    $('#myTable').searchPanes('rebuildPane', 0, true);
});

$('#myTable').on('deselect', function () {
    $('#myTable').searchPanes('rebuildPane', 0, true);
});
//! end copy



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