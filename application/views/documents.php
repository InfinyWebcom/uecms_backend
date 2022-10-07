
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/app-file-manager.css">
<style type="text/css">
  .actions-icons{
    position: absolute;
    top: 8px;
    right: 8px;
  }

  .app-file-content-logo img{
    height: 80px;
    width: 80px;
    margin: 45px auto !important;
  }
  .docTitle{
    white-space: nowrap;
    overflow: hidden;
    text-overflow:ellipsis
  }
</style>
<div id="main">
      <div class="row">
        <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <h5 class="breadcrumbs-title mt-0 mb-0">
                            <span class="highlightedText">Documents</span>
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
            <div class="section app-file-manager-wrapper">
  <!-- content-right start -->
  <div class="content-right" style="width: 100%">
    <div class="app-file-area">
      <div class="app-file-content">
        <h6 class="font-weight-700 mb-3">All Files <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#upload">
            Upload Document
        </a>
        </h6>
        <div class="row app-file-recent-access mb-3">
          <?php foreach ($documents as $key => $value) { ?>
            <div class="col xl3 l6 m3 s12 cardDiv" data-id="<?php echo $value['id']; ?>">
              <div class="card box-shadow-none mb-1 app-file-info">
                <div class="card-content">
                  <a href="<?php echo base_url(); ?>uploads/documents/<?php echo $value['file']; ?>" target="_balck">
                    <div class="app-file-content-logo grey lighten-4">
                      <?php if (strpos($value['file'], 'pdf') !== false) {?>
                        <img class="recent-file" src="<?php echo base_url(); ?>app-assets/images/icon/pdf-image.png" height="38" width="30" alt="Card image cap">
                      <?php }else {?>
                        <img class="recent-file" src="<?php echo base_url(); ?>app-assets/images/icon/jpg-image.png" height="38" width="30" alt="Card image cap">
                      <?php }?>
                    </div>
                  </a>
                  <div class="actions-icons">
                    <i class="material-icons editButton modal-trigger"
                    href="#upload"
                    data-id="<?php echo $value['id']; ?>"
                    data-title="<?php echo $value['title']; ?>"
                    style="font-size: 18px;margin-right: -3px;"
                    >edit</i>
                    <i class="material-icons deleteButton" style="font-size:20px" data-id="<?php echo $value['id']; ?>">delete</i>
                  </div>
                  <div class="app-file-recent-details">
                    <div class="app-file-name font-weight-700 docTitle" title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></div>
                    <div class="app-file-last-access">Date: <?php echo date("Y-m-d",strtotime($value['added_on'])); ?></div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <!-- App File - Recent Accessed Files Section Ends -->
      </div>
    <!-- file manager main content end  -->
  </div>
  <!-- content-right end -->

</div>
          </div>
          <div class="content-overlay"></div>
        </div>
      </div>
    </div>
    <!-- END: Page Main-->
</div>
<div id="upload" class="modal" style="width: 50%;">
  <div class="modal-content">
      <h5>Upload Document</h5>
      <form role="form" id="uploadDocument" method="post" action="<?php echo base_url(); ?>home/uploadDocument" enctype="multipart/form-data">
          <div class="row">
              <div class="input-field col s12" style="padding: 0px;">
                  <input type="hidden" name="id" id="id" value="0">
                  <input type="text" name="title" id="title">
                  <label for="title" style="left: 0px;" class="active">Title</label>
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
              <div class="row">
                  <div class="input-field col s12" style="padding: 0px;">
                      <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit" name="action">
                        Upload
                      </button>
                  </div>
              </div>
          </div>
      </form>
  </div>
</div>

<script src="<?php echo base_url(); ?>app-assets/js/scripts/app-file-manager.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#uploadDocument").validate({
    rules: {
      title: {
        required: true
      },
      file: {
        required: true,
        extension: "jpg,jpeg,pdf,png",
      }
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
  
  $(document).on('click', '.editButton', function(){
    $('#title').val($(this).data('title'));
    $('#id').val($(this).data('id'));
    $('#uploadDocument label').addClass('active');
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
          url: BASE_URL + 'home/deleteDocument/' + id,
          type: 'GET',
          success: function (data) {
            $('.cardDiv').filter('[data-id="'+id+'"]').remove();
            swal("Poof! Your data has been deleted!", {
              icon: "success",
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