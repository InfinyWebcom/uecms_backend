
    <div id="main">
        <div class="row">
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">
                                    <a href="<?php echo base_url(); ?>home/contracts">Workorder Contracts</a> > <?php echo $contract['title']; ?> (Site Groups)
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
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                	You have <span class="highlightedText">
                                    <?php if(count($groups) == 1){
                                        echo count($groups) .' site group';
                                    }else{
                                        echo count($groups) .' site groups';
                                    }?></span> for this contract. You can manage them from this page.
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <?php if($contract['status'] == 'ongoing'){ ?>
                                    <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#modal1">
                                        ADD NEW
                                    </a>
                                <?php } ?>
                                <table id="contract-details" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Group Title</th>
                                            <th>No. of Sites</th>
                                            <th>Manager</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; 
                                        foreach ($groups as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $value['title']; ?></td>
                                                <td><?php echo $value['sitesCount']; ?></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td>
                                                	<a class="btn waves-effect waves-light orange smallBtn" href="<?php echo base_url(); ?>contract/sites/<?php echo $value['id']; ?>">
                                                        SITES
                                                    </a>
                                                    <?php if($contract['status'] == 'ongoing'){ ?>
                                                    	<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn editButton modal-trigger" 
                                                        data-id="<?php echo $value['id']; ?>"
                                                        data-title="<?php echo $value['title']; ?>"
                                                        data-managerid="<?php echo $value['manager_id']; ?>"
                                                        href="#modal2">
                                                            EDIT
                                                        </a>
                                                        <?php if($value['sitesCount'] > 0){ ?>
                                                            <a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" data-tooltip="Group has active sites">DELETE</a>
                                                        <?php }else{ ?>
                                                            <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="<?php echo $value['id']; ?>">
                                                                DELETE
                                                            </a>
                                                        <?php }?>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Title</th>
                                            <th>No. of Sites</th>
                                            <th>Manager</th>
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
            <h5>New Group</h5>
            <form role="form" class="addGroup" method="post" action="<?php echo base_url(); ?>contract/addGroup">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="contract_id" name="contract_id" type="hidden" value="<?php echo $contract_id; ?>">
                        <input id="title" name="title" type="text">
                        <label for="title" style="left: 0px;">Title</label>
                    </div>
                </div>
                <div class="row">
                    <select id="manager_id" name="manager_id" required>
                        <option value="" disabled selected>Manager</option>
                        <?php foreach ($managers as $key => $value) { ?>
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
            <h5>edit Group</h5>
            <form role="form" class="addGroup" method="post" action="<?php echo base_url(); ?>contract/addGroup">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="contract_id" name="contract_id" type="hidden" value="<?php echo $contract_id; ?>">
                        <input id="id" name="id" type="hidden" value="0">
                        <input id="title1" name="title" type="text">
                        <label for="title1" style="left: 0px;">Title</label>
                    </div>
                </div>
                <div class="row manager_id1">
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
var managers = <?php echo json_encode($managers); ?>;
$(document).ready(function(){
    $(".addGroup").validate({
        rules: {
          title: {
            required: true
          },
          manager_id: {
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
        $('#title1').val($(this).data('title'));
        var managerid = $(this).data('managerid');
        var html ='<select id="manager_id1" name="manager_id"><option value="" disabled selected>Manager</option>';
        managers.forEach(function(item) {
            if(item.id == managerid){
                html += '<option value="'+item.id+'" selected>'+item.name+'</option>';
            }else{
                html += '<option value="'+item.id+'">'+item.name+'</option>';
            }
        });
        html += '</select>';
        $('.manager_id1').html(html);
        $('#manager_id1').show();
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
              url: BASE_URL + 'contract/deleteGroup/' + id,
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
