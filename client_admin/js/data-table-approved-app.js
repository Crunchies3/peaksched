$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var employeeId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        employeeId = table.row(e.target.closest('tr')).data();
        document.getElementById('employeeId').value = employeeId[0];
    });
});

$('#myTable').DataTable({
    responsive: true,
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: ' sort',
                className: 'sort-btn rounded mx-2 bi-sort-down-alt my-button-no',
            }]
        },
        //! start copy
        top1: {
            searchPanes: {
                initCollapsed: true,
                preSelect: [
                    {
                        rows: ['Pending'],
                        column: 6
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
    order: [[5, 'asc'], [7, 'asc']],
    //! end copy

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
            targets: 4,
            className: "right-aligned-cell"
        },
        {
            targets: 7,
            'visible': false
        },
        {
            data: null,
            render: function (row) {
                var tempElement = document.createElement('div');
                return '<form action="./view-approved-details.php" id="editEmployee" method="get"><input id="employeeId" hidden type="text" name="appointmentId" value=""></form><button form="editEmployee" class="btn btn-sm my-button-yes mx-1" id="actionClick">View</button>';
            },
            targets: -1
        },
        //! start copy
        {
            searchPanes: {
                show: true,
                orderable: false,
                options: [
                    {
                        label: 'Pending',
                        value: function (rowData, rowIdx) {
                            return rowData[6] == '<span class="badge rounded-pill my-badge-pending">pending</span>';
                        }
                    },
                    {
                        label: 'Completed',
                        value: function (rowData, rowIdx) {
                            return rowData[6] == '<span class="badge rounded-pill my-badge-approved">Completed</span>';
                        }
                    },
                ],
                combiner: 'or'
            },
            targets: [6]
        },
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5]
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