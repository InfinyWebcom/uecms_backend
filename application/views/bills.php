<style type="text/css">
    .siteDiv, .jobDiv{
        display: none;
    }
    .contractFilter{
        float: right !important;
    }

    .contractFilter .select-wrapper input.select-dropdown{
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
                                <?php if(!empty($job)){ ?>
                                    <span class="highlightedText">
                                        <a href="<?php echo base_url(); ?>home/contracts">Workorder Contracts</a>
                                         > 
                                        <a href="<?php echo base_url(); ?>contract/groups/<?php echo $job['contract_id']; ?>"><?php echo $job['c_title']; ?></a>
                                         > 
                                        <a href="<?php echo base_url(); ?>contract/sites/<?php echo $job['group_id']; ?>"><?php echo $job['g_title']; ?></a> 
                                        >
                                        <a href="<?php echo base_url(); ?>contract/siteDetails/<?php echo $job['site_id']; ?>"><?php echo $job['s_title']; ?></a> 
                                        > <?php echo $job['title']; ?> (Bills)
                                    </span>
                                <?php }else{ ?>
                                    <span class="highlightedText">Bills</span>
                                <?php } ?>
                                
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
                                    <?php if(!empty($job)){ ?>
                                        This is the area where you can manage <span class="highlightedText">billd</span> of your jobs at a site.
                                    <?php }else{ ?>
                                        This is the area where you can manage <span class="highlightedText">bills</span>.
                                    <?php } ?>
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#addBill">
                                    ADD NEW
                                </a>
                                <?php if(empty($job)){ ?>
                                    <div class="col s6 m3 l3 contractFilter">
                                        <select id="Contract" style="width: 50px">
                                            <option value="0" selected>Select Contract</option>
                                            <?php foreach ($contracts as $key => $value) { ?>
                                               <option value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <table id="scroll-vert-hor2" class="display nowrap" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Contract Name</th>
                                            <th>Site Name</th>
                                            <th>Job Name</th>
                                            <th width="80px">Date</th>
                                            <th width="80px">Amount</th>
                                            <th width="70px">Status</th>
                                            <th width="170px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Contract Name</th>
                                            <th>Site Name</th>
                                            <th>Job Name</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
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

    <div id="addBill" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>New Bill</h5>
            <form role="form" id="addBills" method="post" action="<?php echo base_url(); ?>user/addBills" enctype="multipart/form-data">
                <?php if(empty($job)){ ?>
                    <div class="row">
                        <select id="contractDD" name="contract_id" required>
                            <option value="" selected disabled>Select Contract</option>
                            <?php foreach ($contracts as $key => $value) { ?>
                               <option value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row siteDiv" style="margin-top: 15px;">
                    
                    </div>

                    <div class="row jobDiv" style="margin-top: 15px;">
                    
                    </div>
                <?php }else{ ?>
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <input type="text" value="<?php echo $job['c_title'];?>" readonly>
                            <label style="left: 0px;">Coontract Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <input type="text" value="<?php echo $job['s_title'];?>" readonly>
                            <label style="left: 0px;">Site Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <input type="hidden" name="job_id" value="<?php echo $job['id'];?>" readonly>
                            <input type="text" value="<?php echo $job['title'];?>" readonly>
                            <label style="left: 0px;">Job Name</label>
                        </div>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="date" name="date" class="datepicker">
                        <label for="date" style="left: 0px;">Date</label>
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
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="amount" name="amount">
                        <label for="amount" style="left: 0px;">Amount</label>
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

    <div id="billReceipt" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5 class="mb-10">Bill Receipt</h5>
            <form role="form" id="addReceipt" method="post" action="<?php echo base_url(); ?>user/addReceipt" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
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
var workers= <?php echo json_encode($workers); ?>;
var id= <?php echo $id; ?>;
$(document).ready(function(){
    $("#addBills").validate({
        rules: {
            contract_id: {
                required: true
            },
            job_id: {
                required: true
            },
            date:{
                required: true
            },
            amount:{
                required: true,
                number:true,
                min: 0.00
            }
            ,
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

    // $("#addReceipt").validate({
    //     rules: {
    //         file: {
    //             required: true,
    //             extension: "jpg,jpeg,pdf,png",
    //         }
    //     },
    //     messages: {
    //       file:{
    //         extension:"Please upload .jepg, .jpg, .png or .pdf file",
    //         required:"Please upload file."
    //       }
    //     },
    //     errorElement : 'div',
    //     errorPlacement: function(error, element) {
    //         var placement = $(element).data('error');
    //         if (placement) {
    //           $(placement).append(error)
    //         } else {
    //             error.insertAfter(element);
    //         }
    //     }
    // });

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
              url: BASE_URL + 'user/deleteBills/' + id,
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

    $(document).on('click', '.payBtn', function(){
        var id = $(this).data('id');
        $(document).find('#id').val(id);
    });

    $(document).on('change', '#contractDD', function(){
        var c_id = $(this).val();
        if(c_id>0){
            $.ajax({
                url: BASE_URL + 'user/getSites',
                type: 'POST',
                dataType: "json",
                data: {id : c_id},
                success: function (data) {
                    if(data.errcode==0){
                        $('.siteDiv').html(data.result);
                        $('#siteDD, .siteDiv').show();
                    }
                }
            });
        }
    });

    $(document).on('change', '#siteDD', function(){
        var c_id = $(this).val();
        if(c_id>0){
            $.ajax({
                url: BASE_URL + 'user/getJobs',
                type: 'POST',
                dataType: "json",
                data: {id : c_id},
                success: function (data) {
                    if(data.errcode==0){
                        $('.jobDiv').html(data.result);
                        $('#jobDD, .jobDiv').show();
                    }
                }
            });
        }
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
            url: BASE_URL + 'user/billsAjax',
            type: 'POST',
            dataSrc: 'data',
            data: function ( d ) {
                return $.extend( {}, d, {
                    "contract_id":function()
                    {
                        return $(document).find('#Contract').val();
                    },
                    "job_id":function()
                    {
                        return id;
                    }
                })
            }
        },
        "columnDefs": [{
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        }, ]
    });

    $(document).on('change', '#Contract', function(){
        table.draw();
    });
})
</script>