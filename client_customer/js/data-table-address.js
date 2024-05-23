$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var addressId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '#actionClick', function (e) {
        addressId = table.row(e.target.closest('tr')).data();
        document.getElementById('addressId').value = addressId[0];
    });
});

$('#myTable').DataTable({
    layout: {
        topStart: 'search',
        topEnd: {
            buttons: [{
                text: '<i class="bi bi-plus plus-icon"></i> add address',
                className: 'add-adress-btn rounded',
                action: function () {
                    location.href = '../address/add-address.php'
                }
            },]
        },
    },
    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    order: [2, 'desc'],
    'columnDefs': [
        {
            targets: 0,
            'visible': false,
        },
        {
            data: null,
            defaultContent: '<form action="../address/view-details.php" id="editEmployee" method="get"><input id="addressId" hidden type="text" name="addressId" value=""></form><button form="editEmployee" class="btn btn-sm my-button-yes mx-1" id="actionClick">view</button>',
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

$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

$("#showEdit").on("click", function () {
    $("#editAddress").toggle();
    $("#discardChanges").toggle();
    $("#showEdit").toggle();
    $("#deleteAddress").toggle();
});

$("#discardChanges").on("click", function () {
    $("#editAddress").toggle();
    $("#discardChanges").toggle();
    $("#showEdit").toggle();
    $("#deleteAddress").toggle();
});