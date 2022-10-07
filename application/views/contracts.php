
    <div id="main">
        <div class="row">
            
        	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">Workorder Contracts</span>
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
                                	You have <span class="highlightedText"><?php if(count($contracts) == 1){
                                        echo count($contracts) .' workorder contract';
                                    }else{
                                        echo count($contracts) .' workorder contracts';
                                    }?></span> in your database currently. You can manage them from this page.
                                </p>
                                
                                <br style="clear: both;" />
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#modal1">
                                    ADD NEW
                                </a>
                                <table id="contracts" class="display nowrap" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th>Contract #</th>
                                            <th>Title</th>
                                            <th>Client</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($contracts as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $value['contract']; ?></td>
                                                <td><?php echo $value['title']; ?></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td><span class="<?php if($value['status'] == 'closed'){echo 'red';}else{ echo 'green';} ?> badge"><?php echo ucwords($value['status']); ?></span></td>
                                                <td><?php echo date("d/m/Y",strtotime($value['start_date'])); ?></td>
                                                <td><?php echo date("d/m/Y",strtotime($value['end_date'])); ?></td>
                                                <td><?php echo $value['amount']; ?></td>
                                                <td>
                                                    <a class="btn waves-effect waves-light orange smallBtn modal-trigger" href="<?php echo base_url(); ?>contract/groups/<?php echo $value['id']; ?>">
                                                        GROUPS
                                                    </a>
                                                    <?php if($value['status'] == 'closed'){ ?>
                                                        <?php if(!empty($value['certificate_name'])){ ?>
                                                            <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn" href="<?php echo base_url(); ?>uploads/documents/<?php echo $value['certificate_name']; ?>" target="_blank">
                                                                VIEW CERTIFICATE
                                                            </a>
                                                        <?php }else{ ?>
                                                            <a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" data-tooltip="Certificate not uploaded">VIEW CERTIFICATE</a>
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <?php if(!empty($value['document_name'])){ ?>
                                                            <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn" href="<?php echo base_url(); ?>uploads/documents/<?php echo $value['document_name']; ?>" target="_blank">
                                                                VIEW DOCUMENT
                                                            </a>
                                                        <?php }else{ ?>
                                                            <a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" data-tooltip="Document not uploaded">VIEW DOCUMENT</a>
                                                        <?php } ?>
                                                        
                                                        <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange smallBtn modal-trigger closeBtn" 
                                                        data-id="<?php echo $value['id']; ?>"
                                                        href="#modal2">
                                                            CLOSE
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Contract #</th>
                                            <th>Title</th>
                                            <th>Client</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Amount</th>
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
            <h5>New Contract</h5>
            <form role="form" id="addContract" method="post" action="<?php echo base_url(); ?>home/addContract" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 p-0">
                        <input id="contract" name="contract" type="text">
                        <label for="contract" style="left: 0px;">Contract #</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 p-0">
                        <input id="title" name="title" type="text">
                        <label for="title" style="left: 0px;">Title</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 p-0">
                        <select id="client_id" name="client_id">
                            <?php foreach ($clients as $key => $value) { ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 25px;">
                        <input type="text" id="start_date" name="start_date" class="datepicker">
                        <label for="start_date" style="left: 25px;">Start Date</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="padding: 0px;">
                        <input type="text" id="amount" name="amount">
                        <label for="amount" style="left: 0px;">Amount</label>
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 25px;">
                        <input type="text" id="end_date" name="end_date" class="datepicker">
                        <label for="end_date" style="left: 25px;">End Date</label>
                    </div>
                </div>
                <div class="row">
                    <div class="file-field input-field">
                      <div class="btn mediumBtn gradient-45deg-purple-deep-orange">
                          <span>Contract Document</span>
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
            <h5>Close Contract</h5>
            <form role="form" id="closeContract" method="post" action="<?php echo base_url(); ?>home/closeContract" enctype="multipart/form-data">
                <br>
                <input id="id" name="id" type="hidden" value="0">
                <div class="row">
                    <div class="file-field input-field">
                      <div class="btn mediumBtn gradient-45deg-purple-deep-orange">
                          <span>Certificate</span>
                          <input type="file" name="file">
                      </div>
                      <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Upload Certificate File">
                      </div>
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
    $("#addContract").validate({
        rules: {
          contract: {
            required: true,
            number:true
          },
          title: {
            required: true
          },
          client_id: {
            required: true
          },
          amount:{
            required: true,
            number:true
          },
          start_date:{
            required: true
          },
          end_date:{
            required: true,
            greaterThan: "#start_date"
          }
          // ,
          // file: {
          //   required: true,
          //   extension: "jpg,jpeg,pdf,png",
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

    // $("#closeContract").validate({
    //     rules: {
    //       file: {
    //         required: true,
    //         extension: "jpg,jpeg,pdf,png",
    //       }
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
    
    $(document).on('click','.closeBtn', function(){
        $('#id').val($(this).data('id'));
    })

})
</script>