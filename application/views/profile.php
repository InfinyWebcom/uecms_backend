<style type="text/css">
    form button[type=submit] {
        margin-right: 1rem;
    }
    .imageBtn, .resetBtn{
        height: 2rem !important; 
        line-height: 2rem !important;
        margin-right: 1rem;
    }
</style>
<div id="main">
    <div class="row">    
    	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">Profile</span>
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

        <div class="col s12">
            <div class="container">
                <div id="app-calendar1">
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <form role="form" id="profile" method="post" action="<?php echo base_url(); ?>home/profile" enctype="multipart/form-data">
                                        <div class="col s12" id="account">
                                          <!-- users edit media object start -->
                                          <!-- <div class="media display-flex align-items-center mb-2">
                                            <a class="mr-2" href="#">
                                                <?php if (!empty($user['profile_img'])) {?>
                                                    <img src="<?php echo base_url(); ?>uploads/images/avatars/<?php echo $user['profile_img']; ?>" alt="users avatar" class="z-depth-4 circle avatar"
                                                    height="64" width="64">
                                                <?php }else {?>
                                                    <img src="<?php echo base_url(); ?>app-assets/images/icon/profile.jpg" alt="users avatar" class="z-depth-4 circle avatar"
                                                    height="64" width="64">
                                                <?php }?>
                                            </a>
                                            <div class="media-body">
                                              <h5 class="media-heading mt-0">Avatar</h5>
                                              <div class="user-edit-btns display-flex">
                                                <div class="file-field input-field" style="margin-top: 0px">
                                                  <div class="btn-small indigo imageBtn">
                                                      <span>Change</span>
                                                      <input type="file" name="file">
                                                  </div>
                                                  <div class="file-path-wrapper" style="display: none;">
                                                      <input class="file-path validate" type="text" placeholder="Upload File">
                                                  </div>
                                                </div>
                                                </div>
                                            </div>
                                          </div> -->
                                          <!-- users edit media object ends -->
                                          <!-- users edit account form start -->
                                            <div class="row">
                                              <div class="col s12 m6">
                                                <div class="row">
                                                  <div class="col s12 input-field">
                                                    <input id="name" name="name" type="text" class="validate" value="<?php echo $user['name']; ?>"
                                                      data-error=".errorTxt2">
                                                    <label for="name">Name</label>
                                                    <small class="errorTxt2"></small>
                                                  </div>
                                                  <div class="col s12 input-field">
                                                    <input id="email" name="email" type="email" class="validate" value="<?php echo $user['email']; ?>"
                                                      data-error=".errorTxt3">
                                                    <label for="email">E-mail</label>
                                                    <small class="errorTxt3"></small>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col s12 m6">
                                                <div class="row">
                                                  <div class="col s12 input-field">
                                                    <input id="phone" name="phone" type="text" class="validate" value="<?php echo $user['phone']; ?>">
                                                    <label for="phone">Phone Number</label>
                                                  </div>
                                                </div>
                                              
                                              </div>
                                              <div class="col s12 display-flex justify-content-end mt-3">
                                                <button type="submit" class="btn indigo">
                                                  Save changes</button>
                                                <button type="button" class="btn btn-light">Cancel</button>
                                              </div>
                                            </div>
                                          </form>
                                          <!-- users edit account form ends -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#profile").validate({
        rules: {
          name: {
            required: true
          },
          phone: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          file: {
            extension: "jpg,jpeg,png",
          }
        },
        messages: {
          file:{
            extension:"Please upload .jepg, .jpg, or .png file",
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

    $('input[name="file"]').change(function(){
        if($(this)[0].files.length <= 0){
            return;
        }
        var f = $(this)[0].files[0];
        var reader = new FileReader();
        
        // Closure to capture the file information.
        reader.onload = (function(file) {
            return function(e) {
                $(document).find('.avatar').attr('src',e.target.result);
            }
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    });
});
</script>
