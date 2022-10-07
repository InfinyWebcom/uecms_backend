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
    .addMore{
        margin-top: 15px;
    }
    .removeItem{
        color: red;
        margin-top: 20px;
        cursor: pointer;
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
                                        > <?php echo $job['title']; ?> (Material Orders)
                                    </span>
                                <?php }else{ ?>
                                    <span class="highlightedText">Material Orders</span>
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
                                        This is the area where you can manage <span class="highlightedText">material orders</span> of your jobs at a site.
                                    <?php }else{ ?>
                                        This is the area where you can manage <span class="highlightedText">material orders</span>.
                                    <?php } ?>
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger addOrderBtn" href="#addMaterialOrders">
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
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Cost</th>
                                            <th width="230px">Actions</th>
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
                                            <th>Name</th>
                                            <th>Cost</th>
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

    <div id="addMaterialOrders" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>New Material Orders</h5>
            <form role="form" class="addMaterialOrders" method="post" action="<?php echo base_url(); ?>user/addMaterialOrders" enctype="multipart/form-data">
                <input type="hidden" name="id" value="0">
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
                        <input type="text" id="name" name="name">
                        <label for="name" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row itemFirst">
                    <div class="input-field col s4" style="padding: 0px;">
                        <input type="text" name="item_name[]">
                        <label for="item_name" style="left: 0px;">Item Name</label>
                    </div>
                    <div class="input-field col s3" style="padding-left: 10px;">
                        <input type="text" name="quantity[]">
                        <label for="quantity" style="left: 10px;">Quantity</label>
                    </div>
                    <div class="input-field col s3" style="padding-left: 10px;">
                        <input type="text" name="rate[]">
                        <label for="rate" style="left: 10px;">Rate</label>
                    </div>
                    <div class="input-field col s2">
                        <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn addMore">
                            ADD
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editMaterialOrder" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Edit Material Orders</h5>
            <form role="form" class="addMaterialOrders" method="post" action="<?php echo base_url(); ?>user/addMaterialOrders" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="0">
                <input type="hidden" id="job_id1" name="job_id" value="0">
                <div class="row name1Div">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="name1" name="name">
                        <label for="name1" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit">
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
    $(".addMaterialOrders").validate({
        rules: {
            contract_id: {
                required: true
            },
            job_id: {
                required: true
            },
            name:{
                required: true
            },
            'item_name[]':{
                required: true
            },
            'quantity[]':{
                required: true,
                integer:true,
                min: 0
            },
            'rate[]':{
                required: true,
                number:true,
                min: 0.00
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
              url: BASE_URL + 'user/deleteMaterialOrders/' + id,
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

    $(document).on('click', '.addOrderBtn', function(){
        $(document).find('.orderItems').remove();
    });
    $(document).on('click', '.editBtn', function(){
        
        $(document).find('.orderItems').remove();
        $('#name1').val($(this).data('name'));
        $('#job_id1').val($(this).data('jobid'));
        $('#id').val($(this).data('id'));
        $.ajax({
            url: BASE_URL + 'user/getItems/'+$(this).data('id'),
            type: 'GET',
            dataType: "json",
            success: function (data) {
                $(".name1Div").after(data.result);
                $('#editMaterialOrder label').addClass('active');
            }
        });
        $('#editMaterialOrder label').addClass('active');
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
            url: BASE_URL + 'user/materialOrdersAjax',
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
            "targets": [5,6], //last column
            "orderable": false, //set not orderable
        }, ]
    });

    $(document).on('change', '#Contract', function(){
        table.draw();
    });

    

    $(document).on('click','.addMore',function(){
        var html ='';
        html += '<div class="row orderItems">'+
            '<div class="input-field col s4" style="padding: 0px;">'+
                '<input type="text" name="item_name[]">'+
                '<label for="item_name" style="left: 0px;">Item Name</label>'+
            '</div>'+
            '<div class="input-field col s3" style="padding-left: 10px;">'+
                '<input type="text" name="quantity[]">'+
                '<label for="quantity" style="left: 10px;">Quantity</label>'+
            '</div>'+
            '<div class="input-field col s3" style="padding-left: 10px;">'+
                '<input type="text" name="rate[]">'+
                '<label for="rate" style="left: 10px;">Rate</label>'+
            '</div>'+
            '<div class="input-field col s2">'+
                '<i class="material-icons dp48 removeItem">remove_circle</i>'+
            '</div>'+
        '</div>';
      
        $(".itemFirst").after(html);
    });
    $(document).on("click", ".removeItem", function() {
          $(this).fadeOut(600, function(){ $(this).parent().parent().remove();});
      });
})
</script>