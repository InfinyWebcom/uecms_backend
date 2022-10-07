
    <div id="main">
        <div class="row">
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                
                                <span class="highlightedText">
                                    <a href="<?php echo base_url(); ?>home/contracts">Workorder Contracts</a>
                                     > 
                                    <a href="<?php echo base_url(); ?>contract/groups/<?php echo $job['contract_id']; ?>"><?php echo $job['c_title']; ?></a>
                                     > 
                                    <a href="<?php echo base_url(); ?>contract/sites/<?php echo $job['group_id']; ?>"><?php echo $job['g_title']; ?></a> 
                                    >
                                    <a href="<?php echo base_url(); ?>contract/siteDetails/<?php echo $job['site_id']; ?>"><?php echo $job['s_title']; ?></a> 
                                    > <?php echo $job['title']; ?> (Daily Progress)
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
        </div>
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                    	<div class="card">
                            <div class="card-content">
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                	This is the area where you can manage <span class="highlightedText">daily progress</span> 
                                	of your jobs at a site.
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>
                        <div class="card m-0">
                            <div class="card-content">
                                <h4 class="card-title col s6">
                                	Job Progress
                                </h4>
                                <?php if($job['status'] == 'ongoing' && $job['jobStatus'] == 'ongoing'){ ?>
                                    <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange smallBtn right modal-trigger" href="#closeJob">
                                       	CLOSE JOB
                                    </a>
                                <?php } ?>
                                
                                <?php if($job['status'] == 'ongoing' && $job['jobStatus'] == 'ongoing'){ ?>
                                    <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#modal1" style="margin-right: 5px;">
                                        ADD NEW
                                    </a>
                                <?php } ?>
                                <br style="clear: both;" />
                                <div class="row">
                                    <div class="col s12">
                                    	<table id="scroll-vert-hor" class="display nowrap" style="table-layout: fixed;">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
		                                            <th>Date</th>
		                                            <th>Description</th>
		                                            <th>Worker</th>
		                                            <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $i=1; 
                                                foreach ($jobs as $key => $value) { ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
		                                                <td><?php echo date("d/m/Y",strtotime($value['date'])); ?></td>
		                                                <td><?php echo $value['description']; ?></td>
		                                                <td><?php echo ucwords($value['worker']); ?></td>
		                                                <td>
                                                            <?php if($job['status'] == 'ongoing' && $job['jobStatus'] == 'ongoing'){ ?>
		                                                	<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger editButton"
                                                            data-id="<?php echo $value['id']; ?>"
                                                            data-description="<?php echo $value['description']; ?>"
                                                            data-date="<?php echo date("d/m/Y",strtotime($value['date'])); ?>"
                                                            data-worker_id="<?php echo $value['worker_id']; ?>"
                                                            href="#modal2">
		                                                        EDIT
		                                                    </a>
                                                            <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="<?php echo $value['id']; ?>">
                                                                DELETE
                                                            </a>
                                                        <?php }else{ ?>
                                                            N/A
                                                        <?php } ?>
		                                                </td>
		                                            </tr>
		                                        <?php } ?>
                                            </tbody>
                                            <tfoot>
		                                        <tr>
		                                            <th>Sr. No.</th>
		                                            <th>Date</th>
		                                            <th>Description</th>
		                                            <th>Worker</th>
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
        </div>
    </div>

    <div id="modal1" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>New Progress</h5>
            <form role="form" class="addJobProgress" method="post" action="<?php echo base_url(); ?>contract/addjobDetails">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="job_id" name="job_id" type="hidden" value="<?php echo $job['id']; ?>">
                        <input type="text" id="date" name="date" class="datepicker">
                        <label for="date" style="left: 0px;">Date</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea id="textarea2" name="description" class="materialize-textarea"></textarea>
                        <label for="description" style="left: 0px;">Description</label>
                    </div>
                </div>
                <div class="row">
                    <select id="worker" name="worker_id[]" multiple required>
                        <option value="" disabled>Workers</option>
                        <?php foreach ($workers as $key => $value) { ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
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
            <h5>Edit Progress</h5>
            <form role="form" class="addJobProgress" method="post" action="<?php echo base_url(); ?>contract/addjobDetails">

                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="id" name="id" type="hidden" value="0">
                        <input id="job_id" name="job_id" type="hidden" value="<?php echo $job['id']; ?>">
                        <input type="text" id="date1" name="date" class="datepicker">
                        <label for="date" style="left: 0px;">Date</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea id="textarea3" name="description" class="materialize-textarea"></textarea>
                        <label for="description" style="left: 0px;">Description</label>
                    </div>
                </div>
                <div class="row worker1">

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

    <div id="closeJob" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Close Job</h5>
            <form role="form" class="closeJob" method="post" action="<?php echo base_url(); ?>contract/closeJob">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="job_id" name="job_id" type="hidden" value="<?php echo $job['id']; ?>">
                        <input type="text" name="closed_date" value="<?php echo date("d/m/Y"); ?>" class="datepicker">
                        <label for="closed_date" style="left: 0px;">Date</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea id="textarea2" name="description" class="materialize-textarea"></textarea>
                        <label for="description" style="left: 0px;">Description</label>
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
$(document).ready(function(){
    $(".addJobProgress").validate({
        rules: {
          description: {
            required: true
          },
          worker_id:{
            required: true
          },
          date:{
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

    $(".closeJob").validate({
        rules: {
          description: {
            required: true
          },
          date:{
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

    $(document).on('click', '.editButton', function(){
        $('#textarea3').val($(this).data('description'));
        $('#date1').val($(this).data('date'));
        var worker_id = $(this).data('worker_id');
        var html ='<select id="worker1" name="worker_id">';
        workers.forEach(function(item) {
            if(item.id == worker_id){
                html += '<option value="'+item.id+'" selected>'+item.name+'</option>';
            }else{
                html += '<option value="'+item.id+'">'+item.name+'</option>';
            }
        });
        html += '</select>';
        $('.worker1').html(html);
        $('#worker1').show();
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
              url: BASE_URL + 'contract/deleteJobDetails/' + id,
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