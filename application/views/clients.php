
    <div id="main">
        <div class="row">
            
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">Clients</span>
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
                            <div class="card-content" style="font-size: 18  px;">
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                    You have <span class="highlightedText"><?php if(count($clients) == 1){
                                        echo count($clients) .' client';
                                    }else{
                                        echo count($clients) .' clients';
                                    }?> </span> in your database currently. You can manage them from this page.
                                </p>
                                <br style="clear: both;" />
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#modal1">
                                    ADD NEW
                                </a>
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>No. of Contracts</th>
                                            <th width="200px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; 
                                        foreach ($clients as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td><?php echo $value['email']; ?></td>
                                                <td><?php echo $value['phone']; ?></td>
                                                <td><?php echo $value['contractsCount']; ?></td>
                                                <td>
                                                    <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger editButton" 
                                                    href="#modal2"
                                                    data-id="<?php echo $value['id'];?>"
                                                    data-name="<?php echo $value['name'];?>"
                                                    data-email="<?php echo $value['email'];?>"
                                                    data-phone="<?php echo $value['phone'];?>"
                                                    >
                                                        EDIT
                                                    </a>
                                                    <?php if($value['contractsCount'] > 0){ ?>
                                                        <a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" data-tooltip="Client has active contracts">DELETE</a>
                                                    <?php }else{ ?>
                                                        <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange smallBtn deleteButton" data-id="<?php echo $value['id']; ?>">
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
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>No. of Contracts</th>
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
            <h5>New Client</h5>
            <form role="form" id="addClient" method="post" action="<?php echo base_url(); ?>home/addClient">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="name" name="name" type="text">
                        <label for="name" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="email" name="email" type="email">
                        <label for="email" style="left: 0px;">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="phone" name="phone" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit" name="action">
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
            <h5>Edit Client</h5>
            <form role="form" id="editClient" method="post" action="<?php echo base_url(); ?>home/addClient">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="hidden" name="id" id="id" value="0">
                        <input id="name1" name="name" type="text" value="">
                        <label for="name" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="email1" name="email" type="email" value="">
                        <label for="email" style="left: 0px;">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input id="phone1" name="phone" type="text" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit" name="action">
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
    $("#editClient").validate({
        rules: {
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          phone:{
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
    $('#phone1').formatter({
        'pattern': '+91 {{99999}} {{99999}}',
        'persistent': true
    });
  
    $(document).on('click', '.editButton', function(){
        $('#name1').val($(this).data('name'));
        $('#email1').val($(this).data('email'));
        $('#phone1').val($(this).data('phone'));
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
              url: BASE_URL + 'home/deleteClient/' + id,
              type: 'GET',
              success: function (data) {
                $('.cardDiv').filter('[data-id="'+id+'"]').remove();
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