$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var reportId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        reportId = table.row(e.target.closest('tr')).data();
        document.getElementById('reportId').value = reportId[0];
        document.getElementById('appointmentId').value = reportId[2];
    });
});

$('#myTable').DataTable({
    responsive: true,
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
                        rows: ['Pending'],
                        column: 5
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
    order: [[6, 'asc'], [4, 'asc'], [5, 'desc']],
    //! end copy

    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: [0, 1, 2, 3, 4],
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form action="view-details.php" id="addAppoitment" method="get"><input id="reportId" hidden type="text" name="reportId" value=""><input id="appointmentId" hidden type="text" name="appointmentId" value=""></form><button form="addAppoitment" class="btn my-button-yes mx-1" id="actionClick">view</button>',
            targets: -1
        },
        {
            targets: 6,
            'visible': false
        },
        //! start copy
        {
            searchPanes: {
                show: true,
                orderable: false,
                options: [
                    {
                        label: 'Approved',
                        value: function (rowData, rowIdx) {
                            return rowData[5] == '<span class="badge rounded-pill my-badge-approved">Approved</span>';
                        }
                    },
                    {
                        label: 'Pending',
                        value: function (rowData, rowIdx) {
                            return rowData[5] == '<span class="badge rounded-pill my-badge-pending">Pending</span>';
                        }
                    }
                ],
                combiner: 'or'
            },
            targets: [5]
        },
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 4, 6]
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

$(document).on("keydown", ":input:not(textarea)", function (event) {
    return event.key != "Enter";
});
