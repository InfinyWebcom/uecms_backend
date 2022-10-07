/*
 * DataTables - Tables
 */


$(function () {

  // Simple Data Table

  $('#data-table-simple').DataTable({
    "responsive": true,
  });

  // Row Grouping Table

  var table = $('#data-table-row-grouping').DataTable({
    "responsive": true,
    "columnDefs": [{
      "visible": false,
      "targets": 2
    }],
    "order": [
      [2, 'asc']
    ],
    "displayLength": 25,
    "drawCallback": function (settings) {
      var api = this.api();
      var rows = api.rows({
        page: 'current'
      }).nodes();
      var last = null;

      api.column(2, {
        page: 'current'
      }).data().each(function (group, i) {
        if (last !== group) {
          $(rows).eq(i).before(
            '<tr class="group"><td colspan="5">' + group + '</td></tr>'
          );

          last = group;
        }
      });
    }
  });

  // Page Length Option Table

  $('#page-length-option').DataTable({
    "responsive": true,
    "bLengthChange": false,
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  });

  // Dynmaic Scroll table

  $('#scroll-dynamic').DataTable({
    "responsive": true,
    scrollY: '50vh',
    scrollCollapse: true,
    paging: false
  })

  // Horizontal And Vertical Scroll Table

  $('#scroll-vert-ho').DataTable({
    "scrollY": 200,
    "scrollX": true,
    "bAutoWidth": false
  })

  $('#scroll-vert-hor').DataTable({
    "searching": false,
    "scrollX": true,
    "bAutoWidth": false,
    "columns": [
      { "width": "50px" },
      { "width": "80px" },
      { "width": "400px" },
      { "width": "100px" },
      { "width": "150px" }
    ],
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  })

  // $('#staff-table').DataTable({
  //   "scrollY": false,
  //   "scrollX": true,
  //   "bAutoWidth": false,
  //   "columns": [
  //     { "width": "120px" },
  //     { "width": "120px" },
  //     { "width": "120px" },
  //     { "width": "120px" },
  //     { "width": "120px" },
  //     { "width": "200px" },
  //     { "width": "80px" },
  //     { "width": "80px" },
  //     { "width": "80px" },
  //     { "width": "80px" },
  //     { "width": "80px" },
  //     { "width": "300px" }
  //   ]
  // })

  $('#contract-details').DataTable({
    "scrollY": false,
    "scrollX": true,
    "bAutoWidth": false,
    "columns": [
      { "width": "50px" },
      { "width": "200px" },
      { "width": "170px" },
      { "width": "170px" },
      { "width": "350px" }
    ],
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  });

  $('#group-sites').DataTable({
    "scrollY": 200,
    "scrollX": true,
    "scrollY": false,
    "bAutoWidth": false,
    "columns": [
      { "width": "20px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "50px" },
      { "width": "120px" }
    ],
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  });

  $('#site-details').DataTable({
    "searching": false,
    // "scrollY": 200,
    // "scrollX": true,
    // "scrollY": false,
    // "bAutoWidth": false,
    "columns": [
      { "width": "30px" },
      { "width": "150px" },
      { "width": "70px" },
      { "width": "70px" },
      { "width": "70px" },
      { "width": "300px" }
    ],
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  });

  $('#site-inventory').DataTable({
    "searching": false,
    "scrollY": 200,
    "scrollX": true,
    "scrollY": false,
    "bAutoWidth": false,
    "columns": [
      { "width": "40px" },
      { "width": "200px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "100px" }
    ]
  });

  $('#contracts').DataTable({
    "scrollY": false,
    "scrollX": true,
    "bAutoWidth": false,
    "columns": [
      { "width": "80px" },
      { "width": "180px" },
      { "width": "120px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "120px" },
      { "width": "100px" },
      { "width": "350px" }
    ],
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  });

  $('#inventories').DataTable({
    "scrollY": false,
    "scrollX": true,
    "bAutoWidth": false,
    "columns": [
      { "width": "50px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "100px" },
      { "width": "450px" }
    ],
    "columnDefs": [{
        "targets": [-1], //last column
        "orderable": false, //set not orderable
    }, ]
  });


  $('#job-expenses').DataTable({
    "searching": false,
    "scrollY": false,
    "scrollX": true,
    "bAutoWidth": false,
    "columns": [
      { "width": "80px" },
      { "width": "180px" },
      { "width": "120px" },
      { "width": "120px" }
    ]
  });

  // Multi Select Table 

  $('#multi-select').DataTable({
    responsive: true,
    "paging": true,
    "ordering": false,
    "info": false,
    "columnDefs": [{
      "visible": false,
      "targets": 2
    }],


  });

});



// Datatable click on select issue fix
$(window).on('load', function () {
  $(".dropdown-content.select-dropdown li").on("click", function () {
    var that = this;
    setTimeout(function () {
      if ($(that).parent().parent().find('.select-dropdown').hasClass('active')) {
        // $(that).parent().removeClass('active');
        $(that).parent().parent().find('.select-dropdown').removeClass('active');
        $(that).parent().hide();
      }
    }, 100);
  });
});

var checkbox = $('#multi-select tbody tr th input')
var selectAll = $('#multi-select .select-all')

// Select A Row Function

$(document).ready(function () {
  checkbox.on('click', function () {
    $(this).parent().parent().parent().toggleClass('selected');
  })

  checkbox.on('click', function () {
    if ($(this).attr("checked")) {
      $(this).attr('checked', false);
    } else {
      $(this).attr('checked', true);
    }
  })


  // Select Every Row 

  selectAll.on('click', function () {
    $(this).toggleClass('clicked');
    if (selectAll.hasClass('clicked')) {
      $('#multi-select tbody tr').addClass('selected');
    } else {
      $('#multi-select tbody tr').removeClass('selected');
    }

    if ($('#multi-select tbody tr').hasClass('selected')) {
      checkbox.prop('checked', true);

    } else {
      checkbox.prop('checked', false);

    }
  })
})