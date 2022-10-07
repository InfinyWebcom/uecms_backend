<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Universal Enterprises CMS</title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/favicon/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/vendors.min.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/vertical-gradient-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/vertical-gradient-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/login.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/custom/custom.css">

</head>
<script src="<?php echo base_url(); ?>app-assets/js/jQuery-lib/2.0.3/jquery.min.js"></script>

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-gradient-menu" data-col="1-column">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form class="resetPassword" method="POST" action="<?php echo base_url(); ?>home/resetPassword">
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="center-align">Universal Enterprises CMS</h5>
                                </div>
                            </div>
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
                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">lock_outline</i>
                                    <input id="new_password" name="new_password" type="password">
                                    <label for="new_password">New Password</label>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">lock_outline</i>
                                    <input id="confirm_password" name="confirm_password" type="password">
                                    <label for="confirm_password">Confirm Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Change Password</button>
                                	<a class="linkText float-right" style="font-size: 13px; margin: 8px;" href="<?php echo base_url(); ?>home/login">Login to your account</a>
                           			<br style="clear: both;" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>
	<script src="<?php echo base_url(); ?>app-assets/js/vendors.min.js"></script>
    
    <script src="<?php echo base_url(); ?>app-assets/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/jquery-validation/additional-methods.min.js"></script>


    <script>
        $(document).ready(function() {
            $(".resetPassword").validate({
                onfocusout: function(e) {
                    this.element(e);                          
                },
                onkeyup: false,
                rules: {
                    new_password: {
                        minlength: 5,
                        required: true
                    },
                    confirm_password: {
                        minlength: 5,
                        required: true,
                        equalTo : "#new_password"
                    }
                },
                messages: {
                  username:{
                    required: "Enter a username",
                  },
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
        });

        $(document).ready(function(){
            setTimeout(function() {
               $('.flashMsg').fadeOut('fast');
            }, 5000);
        });
    </script>
</body>

</html>