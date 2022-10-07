
<div id="main">
    <div class="row"> 
    	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <h5 class="breadcrumbs-title mt-0 mb-0">
                            <span class="highlightedText">Change Password</span>
                        </h5>
                        <br>
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
               <div id="html-view-validations">
                    <form role="form" class="form-horizontal changePasswordForm" method="post" action="<?php echo base_url(); ?>home/changePassword">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal">
                               <div class="form-group margin" style="margin-bottom: 5px;">
                                  <span for="field-1" class="col-sm-3 control-label">
                                  Current Password
                                  <span class="required" aria-required="true"></span></span>
                                  <div class="col-sm-5">
                                     <input type="password" name="current_password" class="form-control" style="padding: 10px;" required>
                                  </div>
                               </div>
                               <div class="form-group margin" style="margin-bottom: 5px;">
                                  <span for="field-1" class="col-sm-3 control-label">
                                  New Password
                                  <span class="required" aria-required="true"></span></span>
                                  <div class="col-sm-5">
                                     <input type="password" name="new_password" class="form-control new_password" style="padding: 10px;" required>
                                  </div>
                               </div>
                               <div class="form-group margin">
                                  <span for="field-1" class="col-sm-3 control-label">
                                  Confirm Password
                                  <span class="required" aria-required="true"></span></span>
                                  <div class="col-sm-5">
                                     <input type="password" name="confirm_password" class="form-control editname" style="padding: 10px;" required>
                                  </div>
                               </div>
                               <div class="col-sm-8">
                                  <div class="form-group margin " style="float: right;padding: 20px;">
                                     <button type="submit" class="btn btn-primary" >
                                     Save Details
                                     </button>
                                  </div>
                               </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.changePasswordForm').validate({
        onfocusout: function(e) {
            this.element(e);                          
        },
        onkeyup: false,
        rules: {
            current_password: {
                required: true,
                minlength: 5,
                remote: {
                    url: BASE_URL + "home/checkPassword",
                    type: "post",
                    dataType: "json"
                }
            },
            new_password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo : ".new_password"
            }
        }
    });

})
</script>

