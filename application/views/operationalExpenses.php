<style type="text/css">
    .siteDiv, .jobDiv{
        display: none;
    }
    .monthFilter{
        float: right !important;
    }

    .monthFilter .select-wrapper input.select-dropdown{
        height: 1.8rem !important;
        font-size: 13px !important;
        margin: 0px 0 0px 0 !important;
    }
</style>
    <div id="main">
        <div class="row">
            
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">Operational Expenses</span>
                            </h5>

                            <?php if($this->session->flashdata('success')): ?>
                                <div class="card-alert card green lighten-5 flashMsg">
                                    <div class="card-content green-text">
                                      <p><?php echo $this->session->flashdata('success'); ?></p>
                                    </div>
                                </div>
                            <?php elseif($this->session->flashdata('error')): ?>
                                <div class="card-alert card red lighten-5 flashMsg">
                                    <div class="card-content red-text">
                                      <p><?php echo $this->session->flashdata('error'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                    This is the area where you can manage <span class="highlightedText">operational expenses</span>.
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#addExpenses">
                                    ADD NEW
                                </a>
                                <div class="col s6 m3 l3 monthFilter">
                                    <select id="month" style="width: 50px">
                                        <?php foreach ($months as $key => $value) { ?>
                                           <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange smallBtn dropdown-trigger right" href="#!" data-target="dropdown562" style="margin-right: 5px;">
                                    JULY, 2020
                                </a>
                                <ul id="dropdown562" class="dropdown-content" tabindex="0" style="top: 30px">
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">June, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">May, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">April, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">March, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">February, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">January, 2020</a>
                                    </li>
                                </ul> -->
                                <table id="scroll-vert-hor2" class="display nowrap" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addExpenses" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>New Expenses</h5>
            <form role="form" id="addOperationalExpenses" method="post" action="<?php echo base_url(); ?>user/addOperationalExpenses" enctype="multipart/form-data" autocomplete="off">
                

                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="title" name="title">
                        <label for="title" style="left: 0px;">Title</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="date" name="date" class="datepicker">
                        <label for="date" style="left: 0px;">Date</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="amount" name="amount">
                        <label for="amount" style="left: 0px;">Amount</label>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="category" name="category">
                        <label for="category" style="left: 0px;">Category</label>
                    </div>
                </div> -->

                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" name="category" id="autocomplete-input" class="autocomplete">
                        <label for="autocomplete-input">Category</label>
                    </div>
                </div>
                  
            
                <div class="row">
                    <div class="file-field input-field">
                      <div class="btn mediumBtn gradient-45deg-purple-deep-orange">
                          <span>File</span>
                          <input type="file" name="file">
                      </div>
                      <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Upload File">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit" name="action">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script type="text/javascript">
var categories= <?php echo json_encode($categories); ?>;

var catObj = {};
categories.forEach(function(item) { 
    catObj[item.category] = null;
});

$(document).ready(function(){
    $('input.autocomplete').autocomplete({
        data: catObj,
    });

    $("#addOperationalExpenses").validate({
        rules: {
            title: {
                required: true
            },
            date:{
                required: true
            },
            category:{
                required: true
            },
            amount:{
                required: true,
                number:true,
                min: 0.00
            }
            // ,
            // file: {
            //     required: true,
            //     extension: "jpg,jpeg,pdf,png",
            // }
        },
        messages: {
          file:{
            extension:"Please upload .jepg, .jpg, .png or .pdf file",
            required:"Please upload file."
          }
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
              $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

    $(document).on('click', '.deleteButton', function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this!",
          icon: 'warning',
          dangerMode: true,
          buttons: {
            cancel: 'Do not delete!',
            delete: 'Yes, delete it.'
          }
        }).then(function (willDelete) {
          if (willDelete) {
            $.ajax({
              url: BASE_URL + 'user/deleteExpenses/' + id,
              type: 'GET',
              success: function (data) {
                swal("Poof! Your data has been deleted!", {
                  icon: "success",
                }).then(results => {
                    location.reload();
                });
              }
            });
          } else {
            swal("Your data is safe", {
              title: 'Cancelled',
              icon: "error",
            });
          }
        });
    });

    var table = $('#scroll-vert-hor2').DataTable({
        "responsive": true,
        "searching": true,
        "bProcessing": true,
        "bServerSide": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [
            [0, "desc"]
        ],
        ajax: {
            url: BASE_URL + 'user/operationalExpensesAjax',
            type: 'POST',
            dataSrc: 'data',
            data: function ( d ) {
                return $.extend( {}, d, {
                    "month":function()
                    {
                        return $(document).find('#month').val();
                    }
                })
            }
        },
        "columnDefs": [{
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        }, ]
    });

    $(document).on('change', '#month', function(){
        table.draw();
    });
})
</script>