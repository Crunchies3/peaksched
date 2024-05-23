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
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt',
            },
            ]
        },
        //! start copy
        top1: {
            searchPanes: {
                initCollapsed: true,
                preSelect: [
                    {
                        rows: ['Pending', 'Report Needed',],
                        column: 3
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
    order: [[4, 'asc'], [5, 'asc']],
    //! end copy

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
            defaultContent: '<form action="view-details.php" id="addAppoitment" method="get"><input id="appointmentId" hidden type="text" name="appointmentId" value=""></form><button form="addAppoitment" class="btn my-button-yes mx-1" id="actionClick">view</button>',
            targets: -1
        },
        //! start copy
        {
            searchPanes: {
                show: true,
                orderable: false,
                options: [
                    {
                        label: 'Report Needed',
                        value: function (rowData, rowIdx) {
                            return rowData[3] == '<span class="badge rounded-pill my-badge-report-needed">Report Needed</span>';
                        }
                    },
                    {
                        label: 'Pending',
                        value: function (rowData, rowIdx) {
                            return rowData[3] == '<span class="badge rounded-pill my-badge-pending">pending</span>';
                        }
                    },
                    {
                        label: 'Completed',
                        value: function (rowData, rowIdx) {
                            return rowData[3] == '<span class="badge rounded-pill my-badge-approved">Approved</span>';
                        }
                    }
                ],
                combiner: 'or'
            },
            targets: [3]
        },
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 4, 5, 6]
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