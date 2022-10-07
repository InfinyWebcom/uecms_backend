
    <div id="main">
        <div class="row">
            
        	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span>
                                	<a href="<?php echo base_url(); ?>staff">Staff Employees</a> > Attendance > <?php echo $user['name']; ?>
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
                    <div id="app-calendar">
                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-content">
                                        <div id="basic-calendar-new"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="attendanceModal" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Add User Attendance</h5>
            <form role="form" class="addAttendance" method="post" action="<?php echo base_url(); ?>staff/addAttendance" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <input type="hidden" id ="date" name="date" value="">
                <div class="row">
                    <div class="input-field col s6" style="padding: 0px;">
                        <select class="typeDropdown" name="type" required>
                            <option value="work_hours"> <?php echo $user['user_type'] == 'worker' ? 'Work Hours': 'Attendance'; ?> </option>
                            <option value="ot_hours">OT Hours</option>
                            <option value="travel">Travel</option>
                            <option value="misc">Misc</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>

                    <div class="input-field col s6 valueDiv" style="padding: 0 0 0 25px; <?php echo $user['user_type'] == 'worker'? '':  'display:none'; ?> ">
                        <input type="text" name="value" required>
                        <label for="value" style="left: 25px;">Value</label>
                    </div>
                    
                        
                    <?php if($user['user_type'] != 'worker'){ ?> 
                        <div class="input-field col s6 ynDiv" style="padding: 0 0 0 25px; display: flex;">
                            <p>
                                <label>
                                    <input name="attendance" value="Present" type="radio" checked/>
                                    <span>Yes</span>
                                </label>
                            </p>
                            <p>
                                <label style="margin-left: 20px">
                                    <input name="attendance" value="Absent" type="radio"/>
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    <?php } ?>
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

    <div id="editAttendance" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Edit User Attendance</h5>
            <form role="form" class="addAttendance" method="post" action="<?php echo base_url(); ?>staff/addAttendance" enctype="multipart/form-data">
                <input type="hidden" name="edit" value="1">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <input type="hidden" id ="date1" name="date" value="">
                <div class="row">
                    <div class="input-field col s6 typeDiv" style="padding: 0px;">

                    </div>
                    <div class="input-field col s6 valueDiv" style="padding: 0 0 0 25px;display: none;">
                        <input type="text" id="value1" name="value" required>
                        <label for="value" style="left: 25px;">Value</label>
                    </div>
                    <div class="input-field col s6 ynDiv" style="padding: 0 0 0 25px; display: flex;">
                        <p>
                            <label>
                                <input name="attendance" class="Present" value="Present" type="radio" checked/>
                                <span>Yes</span>
                            </label>
                        </p>
                        <p>
                            <label style="margin-left: 20px">
                                <input name="attendance" class="Absent" value="Absent" type="radio"/>
                                <span>No</span>
                            </label>
                        </p>
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
var attendance = <?php echo json_encode($attendance); ?>;
var user_type = "<?php echo $user['user_type']; ?>";
$(document).ready(function(){
    $(document).on('change', '.typeDropdown', function(){
        if($(this).val() == 'work_hours' && user_type != 'worker'){
            $(".ynDiv").show();
            $(".valueDiv").hide();
        }else{
            $(".ynDiv").hide();
            $(".valueDiv").show();
        }
    });
    $(document).on('change', '#type', function(){
        var selected = $(this).find(':selected').data('value1');
        selected = selected == null ? 0: selected;
        if($(this).val() != 'work_hours' || user_type =='worker'){
            $('#value1').val(selected);
        }else{
            $("."+selected).prop("checked", true);
        }
    });

    $(".addAttendance").validate({
        rules: {
            type: {
                required: true
            },
            value: {
                required: true,
                number:true,
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
    
    var basicCal = document.getElementById('basic-calendar-new');
    var fcCalendar = new FullCalendar.Calendar(basicCal, {
    editable: true,
    plugins: ["dayGrid", "interaction"],
    selectable: true,
    eventLimit: true,
    eventOrder: "id",
    dateClick: function(info) {
        $('.addAttendance').get(0).reset();
        $('#date').val(info.dateStr);
        $('#attendanceModal').modal('open');
    },
    eventClick: function(info) {
        var custom=info.event.extendedProps.custom;
        var title = info.event.title;
        var value =parseInt(title);
        var sd = title.replace(/[^0-9]/gi, ''); // Replace everything that is not a number with nothing
        var value = parseInt(sd, 10);
        
        var html = '<select id="type" class="typeDropdown" name="type" required>';
        if(user_type == 'worker'){
            if(title.includes("Work Hours")){
                html += '<option data-value1="'+custom.work_hours+'" value="work_hours" selected>Work Hours</option>';
            }else{
                html += '<option data-value1="'+custom.work_hours+'" value="work_hours">Work Hours</option>';
            }
            $(".ynDiv").hide();
            $(".valueDiv").show();
            $('#value1').val(value);
        }
        else if(title.includes("Present") || title.includes("Absent")){
            $(".ynDiv").show();
            $(".valueDiv").hide();
            if(title.includes("Present")){
                $(".Present").prop('checked',true);
                $(".Absent").prop('checked',false);
            }else{
                $(".Absent").prop('checked',true);
                $(".Present").prop('checked',false);
            }
            html += '<option data-value1="'+custom.attendance+'" value="work_hours" selected>Attendance</option>';
        }else{
            $(".ynDiv").hide();
            $(".valueDiv").show();
            $('#value1').val(value);
            html += '<option data-value1="'+custom.attendance+'" value="work_hours">Attendance</option>';
        }

        if(title.includes("OT Hours")){
            html += '<option data-value1="'+custom.ot_hours+'" value="ot_hours" selected>OT Hours</option>';
        }else{
            html += '<option data-value1="'+custom.ot_hours+'" value="ot_hours">OT Hours</option>';
        }

        if(title.includes("Travel")){
            html += '<option data-value1="'+custom.travel+'" value="travel" selected>Travel</option>';
        }else{
            html += '<option data-value1="'+custom.travel+'" value="travel">Travel</option>';
        }

        if(title.includes("Misc")){
            html += '<option data-value1="'+custom.misc+'" value="misc" selected>Misc</option>';
        }else{
            html += '<option data-value1="'+custom.misc+'" value="misc">Misc</option>';
        }
        if(title.includes("Debit")){
            html += '<option data-value1="'+custom.debit+'" value="debit" selected>Debit</option>';
        }else{
            html += '<option data-value1="'+custom.debit+'" value="debit">Debit</option>';
        }
        html += '</select>';
        $('.typeDiv').html(html);
        $('#type').show();
        $('#date1').val(info.event.start);
        $('#editAttendance label').addClass('active');
        $('#editAttendance').modal('open');
        
    },
    events: attendance
  });
  fcCalendar.render();
    

})
</script>