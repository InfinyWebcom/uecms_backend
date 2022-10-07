<style type="text/css">
    .responceText span{
        font-weight: 500;
    }
    .error{
        color: #ff4081;
    }
</style>
    <div id="main">
        <div class="row">
            
        	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">Inventory</span>
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
                            <div class="card-content" style="font-size: 18	px;">
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                	You have <span class="highlightedText"><?php echo $count; ?> items</span> in your inventory currently. You can manage them from this page.
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#addInventory">
                                    ADD NEW
                                </a>
                                <table id="inventories" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Contract</th>
                                            <th>Site</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; 
                                        foreach ($inventories as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo ucwords($value['name']); ?></td>
                                                <?php if(isset($value['site']) && !empty($value['site'])) { ?>
                                                    <td>
                                                        <?php echo $value['site']['c_title'];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['site']['title'];?>
                                                    </td>
                                                    <td>
                                                        <?php if($value['status'] == 'requested') {
                                                            echo "<span class='cyan badge'>".$value['status']."</span>";
                                                        }
                                                        else {
                                                            echo "<span class='green badge'>".$value['status']."</span>";
                                                        } ?>
                                                    </td>
                                                <?php }else{ ?>
                                                    <td>NA</td>
                                                    <td>NA</td>
                                                    <td>NA</td>
                                                <?php } ?>
                
                                                <td>
                                                    <a class="btn waves-effect waves-light orange smallBtn" href="<?php echo base_url(); ?>user/trackInventory/<?php echo $value['id'];?>">
                                                        TRACK
                                                    </a>
                                                	<?php if(isset($value['status']) && $value['status'] == 'requested') {?>
	                                                    <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger respond"
                                                        data-id="<?php echo $value['id']; ?>"
                                                        data-name="<?php echo $value['name']; ?>"
                                                        data-startdate="<?php echo date("d/m/Y",strtotime($value['start_date'])); ?>"
                                                        data-enddate="<?php echo date("d/m/Y",strtotime($value['end_date'])); ?>"
                                                        data-stitle="<?php echo $value['site']['title']; ?>"
                                                        data-ctitle="<?php echo $value['site']['c_title']; ?>"
                                                        data-assign_id="<?php echo $value['assign_id']; ?>"
                                                        data-user="<?php echo ucwords($value['site']['username']); ?>"
                                                        href="#respond">
	                                                        RESPOND
	                                                    </a>
                                                    <?php }else if(isset($value['status']) && $value['status'] == 'assigned'){ ?>
                                                        <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan unassign smallBtn"
                                                        data-id="<?php echo $value['assign_id']; ?>"
                                                        >
                                                            UNASSIGN
                                                        </a>
                                                    <?php } else{ ?>
                                                        <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn assignBtn modal-trigger"
                                                        data-id="<?php echo $value['id']; ?>"
                                                        data-name="<?php echo $value['name']; ?>"
                                                        href="#assignInventory">
                                                            ASSIGN
                                                        </a>
                                                    <?php } ?>
                                                    <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn editButton modal-trigger" 
                                                    data-id="<?php echo $value['id']; ?>"
                                                    data-name="<?php echo $value['name']; ?>"
                                                    href="#editInventory">
                                                        EDIT
                                                    </a>
                                                    <?php if(isset($value['status']) && $value['status'] == 'assigned'){ ?>
                                                        <a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" data-tooltip="Inventory is assigned">DELETE</a>
                                                    <?php }else{ ?>
                                                        <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="<?php echo $value['id']; ?>">
                                                            DELETE
                                                        </a>
                                                    <?php } ?>
                                                    
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Contract</th>
                                            <th>Site</th>
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

    <div id="addInventory" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>New Inventory Item</h5>
            <form role="form" class="addInventory" method="post" action="<?php echo base_url(); ?>user/addInventory">
            <form id="Inventory" method="post">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="name" name="name" type="text">
                        <label for="name" style="left: 0px;">Name</label>
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

    <div id="editInventory" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Edit Inventory Item</h5>
            <form role="form" class="addInventory" method="post" action="<?php echo base_url(); ?>user/addInventory">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="id" name="id" type="hidden" value="0">
                        <input id="name1" name="name" type="text" value="">
                        <label for="name" style="left: 0px;">Name</label>
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

    <div id="respond" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Respond</h5>
            <form role="form" method="post" action="<?php echo base_url(); ?>user/respond">
            	<div class="row responceText" style="margin: 30px 0px 0px 0px;">
            	</div>
                <input class="assign_id" name="assign_id" type="hidden" value="0">

                <div class="row" style="margin: 10px 0px;">
                    <div class="input-field col s6" style="padding: 0px; margin-top: 0px;">
                        <label style="left: 0px;">
					        <input name="group1" type="radio" value="on" checked/>
					        <span>Approve</span>
				      	</label>
                    	<br style="clear: both;" />
                    </div>
                    <div class="input-field col s6" style="padding: 0px; margin-top: 0px;">
                        <label style="left: 0px;">
					        <input name="group1" value="off" type="radio" checked/>
					        <span>Deny</span>
				      	</label>
                    	<br style="clear: both;" />
                    </div>
                    <br style="clear: both;" />
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

    <div id="assignInventory" class="modal">
        <div class="modal-content">
            <h5>Assign Inventory</h5>
            <form role="form" id="assign" method="post" action="<?php echo base_url(); ?>user/assign">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="inventory_id" name="inventory_id" type="hidden" value="Excavator">
                        <input id="inventory_name" type="text" value="" disabled>
                        <label class="inventory_label" for="name" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row">
                    <select id="contractDD" required>
                        <option value="" selected disabled>Select Contract</option>
                        <?php foreach ($contracts as $key => $value) { ?>
                           <option value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row siteDiv" style="margin-top: 15px;">
                
                </div>
                <!-- <div class="row" style="margin-top: 15px;">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="supervisor" name="supervisor" type="text" disabled value="Brendon Rodgers">
                        <label for="supervisor" style="left: 0px;">Supervisor</label>
                    </div>
                </div> -->
                <div class="row">
                    <div class="input-field col s6" style="padding-left: 0px;">
                        <input type="text" id="start_date" name="start_date" class="datepicker">
                        <label for="start_date">Start Date</label>
                    </div>
                    <div class="input-field col s6" style="padding-left: 0px;">
                        <input type="text" id="end_date" name="end_date" class="datepicker">
                        <label for="end_date">End Date</label>
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
$(document).ready(function(){
    $("#assign").validate({
        rules: {
          name: {
            required: true
          },
          contractDD: {
            required: true
          },
          site_id: {
            required: true
          },
          start_date: {
            required: true
          },
          end_date: {
            required: true,
            greaterThan: "#start_date"
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

    $(".addInventory").validate({
        rules: {
          name: {
            required: true
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


    $(document).on('click', '.respond', function(){
        $('.responceText').html('<span>'+$(this).data('user') +'</span> has requested to engage <span>'+$(this).data('name') +'</span> from <span>'+$(this).data('startdate') +'</span> to <span>'+$(this).data('enddate') +'</span> at <span>'+$(this).data('stitle') +'</span> for <span>'+$(this).data('ctitle') +'</span>. Please respond below:');
        $('.assign_id').val($(this).data('assign_id'));
    });

    $(document).on('click', '.editButton', function(){
        $('#name1').val($(this).data('name'));
        $('#id').val($(this).data('id'));
        $('#editInventory label').addClass('active');
    });

    $(document).on('click', '.assignBtn', function(){
        $('#inventory_name').val($(this).data('name'));
        $('#inventory_id').val($(this).data('id'));
        $('.inventory_label').addClass('active');
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
                        $('#siteDD').show();
                    }
                }
            });
        }
    });

    $('.deleteButton').click(function () {
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
              url: BASE_URL + 'user/deleteInventory/' + id,
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

    $('.unassign').click(function () {
        var id = $(this).data('id');
        swal({
          title: "",
          text: "Are you sure you want to unassign this inventory?",
          icon: 'warning',
          dangerMode: true,
          buttons: {
            cancel: 'Do not unassign!',
            delete: 'Yes, unassign it.'
          }
        }).then(function (willDelete) {
          if (willDelete) {
            $.ajax({
              url: BASE_URL + 'user/unassign/' + id,
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

})
</script>