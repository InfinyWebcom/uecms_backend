
    <div id="main">
        <div class="row">
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">
                                    <a href="<?php echo base_url(); ?>home/contracts">Workorder Contracts</a> > <a href="<?php echo base_url(); ?>contract/groups/<?php echo $site['contract_id']; ?>"><?php echo $site['c_title']; ?></a> > <a href="<?php echo base_url(); ?>contract/sites/<?php echo $site['group_id']; ?>"><?php echo $site['g_title']; ?></a> > <?php echo $site['title']; ?> (Jobs)
                                </span>
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
                                <p class="caption mb-0 p-0 col s8 m8 l8">
                                	You have <span class="highlightedText"><?php if(count($jobs) == 1){
                                        echo count($jobs) .' job';
                                    }else{
                                        echo count($jobs) .' jobs';
                                    }?>
                                    </span> at this site. You can manage them from this page.
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>

                        <div class="card m-0">
                            <div class="card-content">
                                <h4 class="card-title col s6 p-0">
                                    List of Jobs
                                </h4>
                                <?php if($site['status'] == 'ongoing'){ ?>
                                    <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#modal1">
                                        NEW JOB
                                    </a>
                                <?php } ?>
                                <table id="site-details" class="display" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Job Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; 
                                        foreach ($jobs as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $value['title']; ?></td>
                                                <td><?php echo date("d/m/Y",strtotime($value['start_date'])); ?></td>
                                                <td>
                                                    <?php if($value['status'] == 'ongoing'){ ?>
                                                        <?php echo date("d/m/Y",strtotime($value['end_date'])); ?>
                                                    <?php }else{?>
                                                        <?php echo date("d/m/Y",strtotime($value['closed_date'])); ?>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if($value['status'] == 'ongoing'){ ?>
                                                        <span class="green badge"><?php echo $value['status']; ?></span>
                                                    <?php }else{?>
                                                        <span class="red badge tooltipped" data-tooltip="<?php echo $value['description']; ?>"><?php echo $value['status']; ?></span>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <a class="btn waves-effect waves-light orange smallBtn" href="<?php echo base_url(); ?>contract/jobDetails/<?php echo $value['id']; ?>">
                                                        PROGRESS
                                                    </a>
                                                    <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn dropdown-trigger" href="#!" data-target="dropdown562<?php echo $value['id']; ?>">
                                                        MORE
                                                    </a>
                                                    <ul id="dropdown562<?php echo $value['id']; ?>" class="dropdown-content" tabindex="0" style="">
                                                        <li tabindex="0">
                                                            <a href="<?php echo base_url(); ?>user/measurements/<?php echo $value['id']; ?>" target="_blank" class="btnDDOption">Measurements (<?php echo $value['measurements']; ?>)</a>
                                                        </li>
                                                        <li tabindex="0">
                                                            <a href="<?php echo base_url(); ?>user/bills/<?php echo $value['id']; ?>" target="_blank" class="btnDDOption">Bills (<?php echo $value['paid_bills'] .'/'.$value['bills']; ?>)</a>
                                                        </li>
                                                        <li tabindex="0">
                                                            <a href="<?php echo base_url(); ?>user/materialOrders/<?php echo $value['id']; ?>" target="_blank" class="btnDDOption">Material Orders (<?php echo $value['material_orders']; ?>)</a>
                                                        </li>
                                                        <li tabindex="0">
                                                            <a href="<?php echo base_url(); ?>user/contractExpenses/<?php echo $value['id']; ?>" target="_blank" class="btnDDOption">Expenses (<?php echo $value['expenses']; ?>)</a>
                                                        </li>
                                                    </ul>
                                                    <?php if($site['status'] == 'ongoing'){ ?>
                                                        <?php if($value['status'] == 'ongoing'){ ?>
                                                            <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn editButton modal-trigger" 
                                                            data-id="<?php echo $value['id']; ?>"
                                                            data-title="<?php echo $value['title']; ?>"
                                                            data-startdate="<?php echo $value['start_date']; ?>"
                                                            data-enddate="<?php echo $value['end_date']; ?>"
                                                            href="#modal2">
                                                                EDIT
                                                            </a>
                                                        <?php }?>

                                                        <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="<?php echo $value['id']; ?>">
                                                            DELETE
                                                        </a>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Job Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
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
            <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card m-0">
                            <div class="card-content">
                                <h4 class="card-title col s6 p-0">
                                    Engaged Inventory
                                </h4>
                                <?php if($site['status'] == 'ongoing'){ ?>
                                    <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#reqInv">
                                        REQUEST NEW
                                    </a>
                                <?php } ?>
                                <table id="site-inventory" class="display" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; 
                                        foreach ($assignedInventories as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td><?php echo date("d/m/Y",strtotime($value['start_date'])); ?></td>
                                                <td><?php echo date("d/m/Y",strtotime($value['end_date'])); ?></td>
                                                <td>
                                                    <?php if($value['status'] == 'assigned') {?>
                                                        <span class="green badge">approved</span>
                                                    <?php } else if($value['status'] == 'requested') { ?>
                                                        <span class="cyan badge">requested</span>
                                                    <?php }else{ ?>
                                                        <span class="red badge">denied</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                <?php if($value['status'] == 'assigned'){ ?>
                                                    <a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" data-tooltip="Inventory is assigned">DELETE</a>
                                                <?php }else{ ?>
                                                    <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton1 smallBtn" data-id="<?php echo $value['id']; ?>">
                                                        DELETE
                                                    </a>
                                                <?php }?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
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

    <div id="modal1" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>New Job</h5>
            <form role="form" class="addJob" method="post" action="<?php echo base_url(); ?>contract/addJob">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="site_id" name="site_id" type="hidden" value="<?php echo $site['id']; ?>">
                        <input id="title" name="title" type="text">
                        <label for="name" style="left: 0px;">Title</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="padding: 0 12px 0 0;">
                        <input type="text" id="start_date" name="start_date" class="datepicker">
                        <label for="start_date" style="left: 0px;">Start Date</label>
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 12px;">
                        <input type="text" id="end_date" name="end_date" class="datepicker">
                        <label for="end_date" style="left: 12px;">End Date</label>
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

    <div id="reqInv" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Request Inventory</h5>
            <form role="form" id="assign" method="post" action="<?php echo base_url(); ?>contract/request">
                <div class="row">
                    <input type="hidden" id="site_id" name="site_id" value="<?php echo $site['id'] ; ?>">

                    <select id="inventory_id" name="inventory_id" required>
                        <option value="" selected disabled>Select Inventory</option>
                        <?php foreach ($inventories as $key => $value) { ?>
                            <option value="<?php echo $value['id']; ?>" ><?php echo $value['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="padding: 0 12px 0 0;">
                        <input type="text" id="start_date2" name="start_date" class="datepicker">
                        <label for="start_date2" style="left: 0px;">Start Date</label>
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 12px;">
                        <input type="text" id="end_date" name="end_date" class="datepicker">
                        <label for="end_date" style="left: 12px;">End Date</label>
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

    <div id="modal2" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Edit Job</h5>
            <form role="form" class="addJob" method="post" action="<?php echo base_url(); ?>contract/addJob">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="id" name="id" type="hidden" value="0">
                        <input id="site_id" name="site_id" type="hidden" value="<?php echo $site['id']; ?>">
                        <input id="title1" name="title" type="text" value="">
                        <label for="name" style="left: 0px;">Title</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="padding: 0 12px 0 0;">
                        <input type="text" id="start_date1" name="start_date" class="datepicker" value="">
                        <label for="start_date" style="left: 0px;">Start Date</label>
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 12px;">
                        <input type="text" id="end_date1" name="end_date" class="datepicker" value="">
                        <label for="end_date" style="left: 12px;">End Date</label>
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
    $(".addJob").validate({
        rules: {
          title: {
            required: true
          },
          start_date:{
            required: true
          },
          end_date:{
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

    $("#assign").validate({
        rules: {
          inventory_id: {
            required: true
          },
          start_date: {
            required: true
          },
          end_date: {
            required: true,
            greaterThan: "#start_date2"
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

  
    $(document).on('click', '.editButton', function(){
        $('#title1').val($(this).data('title'));
        $('#start_date1').val($(this).data('startdate'));
        $('#end_date1').val($(this).data('enddate'));
        $('#id').val($(this).data('id'));
        $('#modal2 label').addClass('active');
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
              url: BASE_URL + 'contract/deleteJob/' + id,
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

    $('.deleteButton1').click(function () {
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
              url: BASE_URL + 'contract/deleteRequest/' + id,
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
