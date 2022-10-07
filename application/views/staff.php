<style type="text/css">
    .badge{
        cursor: pointer;
    }
    .file-input {
      display: none;
    }
    .uploadFile{
        display: inline-block;
    }
   

.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 4px;
  font-size: 14px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

.dropdown {
  float: right;
  position: relative;
  display: inline-block;
}

.myDropdown12 {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    right: 0;
    z-index: 1;
    opacity: unset;
    top: 30px !important;
}


.myDropdown12 a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
    <div id="main">
        <div class="row">
            
        	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">
                                    Staff Employees
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
                            <div class="card-content" style="font-size: 18	px;">
                                <p class="caption mb-0 p-0 col s12 m12 l12">
                                	You have <span class="highlightedText"><?php if($totalUsers == 1){
                                        echo $totalUsers .' staff employee';
                                    }else{
                                        echo $totalUsers .' staff employees';
                                    }?></span> in your database currently. You can manage them from this page.
                                </p>
                                
                                <br style="clear: both;" />
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-content">
                                <a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan smallIcnBtn right dropdown-trigger" style="margin-left: 5px;" data-target="dropdown562">
                                    <i class="material-icons">file_download</i>
                                </a>
                                <ul id="dropdown562" class="dropdown-content" tabindex="0" style="top: 30px">
                                    <li tabindex="0">
                                        <a href="javascript:void(0)" class="btnDDOption modal-trigger">Select Month</a>
                                    </li>
                                    <?php foreach ($months as $key => $value) { ?>
                                        <li tabindex="0">
                                            <a href="<?php echo base_url(); ?>staff/downloadAttendance/<?php echo date('Y-m-d', strtotime($value));?>" class="btnDDOption modal-trigger" target="_blank"><?php echo $value;?></a>
                                        </li>
                                    <?php } ?>
                                    
                                </ul>
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger addStaffBtn" href="#addStaff">
                                    ADD STAFF
                                </a>
                                <table id="staff-table" class="display nowrap" style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th width="150px">Name</th>
                                            <th width="110px">Type</th>
                                            <th width="80px">Daily Wage</th>
                                            <th width="110px">Monthly Salary</th>
                                            <th width="80px">Phone</th>
                                            <th width="150px">Address</th>
                                            <th width="75px">PAN</th>
                                            <th width="75px">Aadhar</th>
                                            <th width="75px">Medical</th>
                                            <th width="75px">Resume</th>
                                            <th width="75px">Passbook</th>
                                            <th width="280px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Daily Wage</th>
                                            <th>Monthly Salary</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>PAN</th>
                                            <th>Aadhar</th>
                                            <th>Medical</th>
                                            <th>Resume</th>
                                            <th>Passbook</th>
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

    <div id="addStaff" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Add Staff</h5>
            <form role="form" class="addStaff" method="post" action="<?php echo base_url(); ?>staff/addStaff" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 p-0">
                        <input type="hidden" name="id" value="0">
                        <input name="name" type="text">
                        <label for="name" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 p-0">
                        <select class="userDropdown" name="user_type" required>
                            <option value="" disabled selected>Type</option>
                            <option value="Site Co-ordinator">Site Co-ordinator</option>
                            <option value="manager">Site Manager</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="worker">Worker</option>
                        </select>
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 25px;">
                        <input type="text" name="phone">
                        <label for="phone" style="left: 25px;">Phone</label>
                    </div>
                </div>
                <div class="row emailDiv" style="display: none;">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea name="email" class="materialize-textarea"></textarea>
                        <label for="email" style="left: 0px;">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea name="address" class="materialize-textarea"></textarea>
                        <label for="address" style="left: 0px;">Address</label>
                    </div>
                </div>
                
                <div class="row wageDiv">
                    <div class="input-field col s12 p-0">
                        <input name="daily_wage" type="text">
                        <label for="daily_wage" style="left: 0px;">Daily Wage</label>
                    </div>
                </div>
                <div class="row salaryDiv">
                    <div class="input-field col s12 p-0">
                        <input name="monthly_salary" type="text">
                        <label for="monthly_salary" style="left: 0px;">Monthly Salary</label>
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

    <div id="editStaff" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Edit Staff</h5>
            <form role="form" class="addStaff" method="post" action="<?php echo base_url(); ?>staff/addStaff" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 p-0">
                        <input type="hidden" name="id" id="id" value="0">
                        <input id="name" name="name" type="text">
                        <label for="name" style="left: 0px;">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6 p-0 user_type">
                        
                    </div>
                    <div class="input-field col s6" style="padding: 0 0 0 25px;">
                        <input type="text" id="phone" name="phone">
                    </div>
                </div>
                <div class="row emailDiv" style="display: none;">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea id="email" name="email" class="materialize-textarea"></textarea>
                        <label for="email" style="left: 0px;">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <textarea id="address" name="address" class="materialize-textarea"></textarea>
                        <label for="address" style="left: 0px;">Address</label>
                    </div>
                </div>
                <div class="row wageDiv">
                    <div class="input-field col s12 p-0">
                        <input id="daily_wage" name="daily_wage" type="text">
                        <label for="daily_wage" style="left: 0px;">Daily Wage</label>
                    </div>
                </div>
                <div class="row salaryDiv">
                    <div class="input-field col s12 p-0">
                        <input id="monthly_salary" name="monthly_salary" type="text">
                        <label for="monthly_salary" style="left: 0px;">Monthly Salary</label>
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

    <div id="daysOfMonth" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Working days in June, 2020</h5>
            <form id="editClient" method="post">
                <div class="row" style="margin: 30px 0px 0px 0px;">
                    Enter the total number of working days for the month of June, 2020 below:    
                </div>
                <div class="row">
                    <div class="input-field col s12 p-0">
                        <input id="workingdays" name="workingdays" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit" name="action">
                                DOWNLOAD
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
<script type="text/javascript">
    
    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          console.log('openDropdown.classList',openDropdown.classList);
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }

$(document).ready(function(){
    $(document).on('click', '.dropbtn', function(){
        // $(this).parent('.dropdown').find('.myDropdown12').toggle("show");
        $(this).parent('.dropdown').find('.myDropdown12').addClass("show");
    });

    $(".addStaff").validate({
        rules: {
            name: {
                required: true
            },
            phone: {
                required: true,
                number:true,
            },
            email: {
                required: true,
                email:true,
            },
            user_type:{
                required: true
            },
            address:{
                required: true
            },
            daily_wage:{
                required: true
            },
            monthly_salary:{
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
        $('#name').val($(this).data('name'));
        $('#phone').val($(this).data('phone'));
        $('#address').val($(this).data('address'));
        $('#monthly_salary').val($(this).data('monthly_salary'));
        $('#daily_wage').val($(this).data('daily_wage'));
        $('#id').val($(this).data('id'));
        $('.emailDiv').hide();
        var user_type = $(this).data('user_type');
        var html ='<select class="userDropdown" id="user_type" name="user_type" required><option value="" disabled>Type</option>';
        if(user_type == 'Site Co-ordinator'){
            html += '<option value="Site Co-ordinator" selected>Site Co-ordinator</option>';
            $('#email').val($(this).data('email'));
            $('.emailDiv').show();
        }else{
            html += '<option value="Site Co-ordinator">Site Co-ordinator</option>';
        }
        if(user_type == 'manager'){
            html += '<option value="manager" selected>Site Manager</option>';
        }else{
            html += '<option value="manager">Site Manager</option>';
        }
        if(user_type == 'supervisor'){
            html += '<option value="supervisor" selected>Supervisor</option>';
        }else{
            html += '<option value="supervisor">Supervisor</option>';
        }
        if(user_type == 'worker'){
            $(".wageDiv").show();
            $(".salaryDiv").hide();
            html += '<option value="worker" selected>Worker</option>';
        }else{
            $(".wageDiv").hide();
            $(".salaryDiv").show();
            html += '<option value="worker">Worker</option>';
        }
       
        html += '</select>';
        $('.user_type').html(html);
        $('#user_type').show();
        $('#editStaff label').addClass('active');
    });
    $(document).on('click', '.deleteFile', function(){
        var deleteFile = $(this).data('id');
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
              url: BASE_URL + 'staff/deleteFile/' + deleteFile,
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
    
    $(document).on('click', '.addStaffBtn', function(){
        $('.addStaff').get(0).reset();
    });

    $(document).on('change', '.userDropdown', function(){
        if($(this).val() == 'worker'){
            $(".wageDiv").show();
            $(".salaryDiv").hide();
        }else{
            $(".wageDiv").hide();
            $(".salaryDiv").show();
        }

        if($(this).val() == 'Site Co-ordinator'){
            $(".emailDiv").show();
        }else{
            $(".emailDiv").hide();
        }
    });

    $(document).on('change', 'input[name="file"]', function(){
        if($(this)[0].files.length <= 0){
            return;
        }
        var f = $(this)[0].files[0];
        var reader = new FileReader();
        if(f.type.includes("image")){
            $(this).closest('form').submit();
        }else{
            swal("Extension Error!", "Please make sure you upload an image file.");
            //$('#extensionModal').modal('open');
        }
    });

    $(document).on('click', '.deleteButton', function(){
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
              url: BASE_URL + 'staff/deleteStaff/' + id,
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

    
    $('#staff-table').DataTable({
        // "responsive": true,
        "scrollY": false,
        "scrollX": true,
        "searching": true,
        "bProcessing": true,
        "bServerSide": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [
            [0, "desc"]
        ],
        ajax: {
            url: BASE_URL + 'staff/usersAjax',
            type: 'POST',
            dataSrc: 'data'
        },
        "columnDefs": [{
            "targets": [6,7,8,9,10,11], //last column
            "orderable": false, //set not orderable
        }, ]
        
    });

    $(document).on('change', '#Contract', function(){
        table.draw();
    });

    
})
</script>