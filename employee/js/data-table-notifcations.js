$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';

var table;
var notificationId;

$(document).ready(function () {
    table = $('#myTable').DataTable();
    table.on('click', '.actionClick', function (e) {
        e.preventDefault();
        var rowData = table.row($(this).closest('tr')).data();
        var notificationId = rowData[0]; 
        
  
        var icon = $(this).find('i');
        if (icon.hasClass('bi bi-square')) {
            icon.removeClass('bi bi-square').addClass('bi bi-check-square-fill');
       
            markNotificationAsRead(notificationId);
        } else {
            icon.removeClass('bi bi-check-square-fill').addClass('bi bi-square');
       
        }
    });
});

$('#myTable').DataTable({
    layout: {
        topStart: 'search',
        topEnd: null,
    },
    scrollY: 450,
    language: {
        emptyTable: 'No data available in table'
    },
    'columnDefs': [
        {
            targets: 1,
            className: "right-aligned-cell"
        },
        {
            data: null,
            defaultContent: '<form id="markAsReadForm" method="post"><input id="notificationId" type="hidden" name="notificationId" value=""></form> <button class="actionClick" style="background: none; border: none;"><i class="bi bi-square"></i></button>',
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