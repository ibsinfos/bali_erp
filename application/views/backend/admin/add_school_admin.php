<?php if(@$sc_admin_id) { $heading="Update School Admin"; } else { $heading="Add School Admin"; } ?>


<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo $heading; ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
             <li><a href="<?php echo base_url(); ?>index.php?admin/school_admin"><?php echo get_phrase('school_admin_inforamtion'); ?></a></li>
            <li class="active">
                <?php echo $heading; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php
$msg = $this->session->flashdata('flash_message_error');
if ($msg) {
    ?>        
    <div class="alert alert-danger">
    <?php echo $msg; ?>
    </div>
<?php } ?>

<?php  ?>


<?php if(@$sc_admin_id==""){ ?>
<div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/add_school_admin/create', array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'addSchoolAdminForm')); ?>
        <div class="col-md-12">
            <div class="white-box">
                <section>
                    <div class="sttabs tabs-style-flip" align="left">
                        <nav>
                            <ul>
                                <li class="active text-left" data-step="6" data-intro="Here you can fill School Admin Information" data-position='top'><a href="#section-flip-5" class="sticon fa fa-info-circle"><span>School Admin Information</span></a></li>
                                <input type="hidden" id="hidden"  value="0"/>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-flip-1">

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('First Name'); ?>
                                            <span class="error mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo set_value('fname');?>" placeholder="Enter First Name" data-validate="required" data-message-required="Please enter first name" required> 
                                        </div>
                                        <span id="error_fname" class="mandatory"></span>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('Last Name'); ?>
                                            <span class="error mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" id="lname" name="lname" value="<?=set_value('lname')?>" placeholder="Enter Last Name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('Email Id'); ?>
                                                <span class="error mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                            <input type="email" class="form-control" id="email" name="email" value="<?=set_value('email')?>" placeholder="Enter Email Id" required>
                                        </div>
                                         <span id="error_email" class="mandatory"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('mobile'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>

                                            <input id="mobile" type="number" class="form-control" name="mobile" placeholder="Enter Mobile No." data-validate="required" value="<?=set_value('mobile')?>" data-message-required="Please enter Mobile" required maxlength="10" />
                                        </div>
                                        <span id="error_mobile" class="mandatory"></span>
                                    </div>
                                
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('Profile Picture'); ?><span class="error mandatory"> *</span>
                                       </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <input type="file" id="input-file-now" class="dropify" name="profile_pic" required /> 
                                        </div>
                                        <span id="error_input-file-now" class="mandatory"></span>
                                        <span id="error_profile_pic" class="mandatory"></span>
                                    </div>

                                    <div class="text-right col-xs-12 p-t-20" >
                                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Add School Admin</button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /content -->
        </div>
        <!-- /tabs -->
    <?php echo form_close(); ?>
</div>

<?php } else { ?>

<div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/add_school_admin/update/'.@$sc_admin_id, array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'updateSchoolAdminForm')); ?>
        <div class="col-md-12">
            <div class="white-box">
                <section>
                    <div class="sttabs tabs-style-flip" align="left">
                        <nav>
                            <ul>
                                <li class="active text-left" data-step="6" data-intro="Here you can update School Admin Information" data-position='top'><a href="#section-flip-5" class="sticon fa fa-info-circle"><span>School Admin Information</span></a></li>
                                <input type="hidden" id="hidden"  value="0"/>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-flip-1">

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('First Name'); ?>
                                            <span class="error mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" id="fname" name="fname" value="<?=$adminData['first_name']?>" placeholder="Enter First Name" data-validate="required" data-message-required="Please enter first name" required> 
                                        </div>
                                        <span id="error_fname" class="mandatory"></span>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('Last Name'); ?>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="text" class="form-control" id="lname" name="lname" value="<?=$adminData['last_name']?>" placeholder="Enter Last Name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('Email Id'); ?>
                                                <span class="error mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ti-user"></i></div>
                                            <input type="email" class="form-control" id="email" name="email" value="<?=$adminData['email']?>" placeholder="Enter Email Id" required>
                                        </div>
                                         <span id="error_email" class="mandatory"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('mobile'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>

                                            <input id="mobile" type="number" class="form-control" name="mobile" placeholder="Enter Mobile No." data-validate="required" value="<?=$adminData['mobile']?>" data-message-required="Please enter Mobile" required>
                                        </div>
                                        <span id="error_mobile" class="mandatory"></span>
                                    </div>
                                
                                    <div class="col-sm-4 form-group">
                                        <label for="field-1">
                                            <?php echo get_phrase('Profile Picture'); ?><span class="error mandatory"> *</span>
                                       </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                            <input type="file" id="input-file-now" class="dropify" name="profile_pic" />
                                            <input type="hidden" name="profile_pic_old" value="<?=$adminData['profile_pic']?>" />
                                        </div>
                                        <span id="error_input-file-now" class="mandatory"></span>
                                        <span id="error_profile_pic" class="mandatory"></span>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <?php if($adminData['profile_pic']!="" && file_exists('uploads/sc_admin_images/'.$adminData['profile_pic'])) ?>
                                        <img src="<?php echo base_url();?>uploads/sc_admin_images/<?=$adminData['profile_pic']?>" alt="School Admin Profile Picture"  width="100" height="100" style="margin-top:20px; float: left;"/>
                                    </div>

                                    <div class="text-right col-xs-12 p-t-20" >
                                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Update School Admin</button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /content -->
        </div>
        <!-- /tabs -->
    <?php echo form_close(); ?>
</div>


<?php } ?>

<script type="text/javascript">
    
    $(document).ready(function() {
        $('#transport_id').change(function() { 
            $('#transport_fee_idError').html('');
            var transport_id        =   $(this).val();
            $.ajax({
                dataType    : 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_transportfee/' +transport_id ,
                success: function(response) {
                    if(response.status == "success") {
                        $('#transport_fee_id').val(response.transport_fee);
                    } else {
                        $('#transport_fee_idError').html(response.message);
                    }
                }
            });
        });
        
        $("#route_id").change(function(){ 
            var route_id = $(this).val(); 
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
                    success: function (response)
                    {
                        jQuery('#transport_id').html(response);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
        });
        
        $('#dormitory_id').change(function() {
            var dormitory_id        =   $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' +dormitory_id ,
                success: function(response) {
                    $('#room_id').html(response);
                }
            });
        });
        
        $('#room_id').change(function() {
            $('#room_idError').html('');
            var room_id        =   $(this).val();
            $.ajax({
                dataType    : 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_dormitoryfee/' +room_id ,
                success: function(response) {
                    if(response.status == "success") {
                        $('#dormitory_fee_id').val(response.hostel_fee);
                    } else {
                        $('#room_idError').html(response.message);
                    }
                }
            });
        });
        
    });

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            endDate: '+0d',
            autoclose: true
        });
    });

    function agecalculate() {
        var dob = $(".datepicker").val();
        var now = new Date();
        var d = new Date();
        var year = d.getFullYear() - 3;
        d.setFullYear(year);
        var birthdate = dob.split("/");
        var born = new Date(birthdate[2], birthdate[1] - 1, birthdate[0]);
        age = get_age(born, now);
        if (age <= 3) {
            alert("Age should be greater than or equal to 3");
            return false;
        }
    }

    function get_age(born, now) {
        var birthday = new Date(now.getFullYear(), born.getMonth(), born.getDate());
        if (now >= birthday)
            return now.getFullYear() - born.getFullYear();
        else
            return now.getFullYear() - born.getFullYear() - 1;
    }

    function get_class_sections(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_class_section/' + class_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }

    function checkemail() {
        var email = $("#studentemail").val();
        if (email) {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url();?>index.php?admin/get_class_students_mass/',
                data: {
                    user_name: name
                },
                success: function(response) {
                    $('#name_status').html(response);
                    if (response == "OK") {
                        return true;
                    } else {
                        return false;
                    }
                }
            });
        } else {
            $('#name_status').html("");
            return false;
        }
    }


    $('#btn0').on('click', function() {
    
    var name = $('#name').val();
    var lname = $('#lname').val();
    var sex = $('#sex').val();
        if(name==''){
                      document.getElementById('error_name').innerHTML="Please Enter Name";     
         }else{
             validate_email(encodeURIComponent(email));
             document.getElementById('error_name').innerHTML="";
         }
         
        if(lname==''){
                      document.getElementById('error_lname').innerHTML="Please Enter Last Name";     
         }else{
             validate_email(encodeURIComponent(email));
             document.getElementById('error_lname').innerHTML="";
         }
           if(sex==''){
                      document.getElementById('error_sex').innerHTML="Please Enter Gender";     
         }else{
             validate_email(encodeURIComponent(email));
             document.getElementById('error_sex').innerHTML="";
         }
    
    
         var email = $('#studentemail').val();
        if(email==''){
//              $('#error_studentemail').html('Please Enter Email');
                      document.getElementById('error_studentemail').innerHTML="Please Enter Email";     
         }else{
             validate_email(encodeURIComponent(email));
             document.getElementById('error_studentemail').innerHTML="";
         }
         
         var category = $('#category').val();
        if(category==''){
//              $('#error_studentemail').html('Please Enter Email');
                      document.getElementById('error_category').innerHTML="Please Enter Category";     
         }else{
             validate_email(encodeURIComponent(email));
             document.getElementById('error_category').innerHTML="";
         }

  var parent = $('#parent').val();
        if(category==''){
//              $('#error_studentemail').html('Please Enter Email');
                      document.getElementById('error_parent').innerHTML="Please Enter Parent";     
         }else{
             document.getElementById('error_parent').innerHTML="";
         }
         
         if((name!='') &&(lname!='')&&(lname!='')&&(sex!='')&&(email!='')&&(category!='')&&(parent!='')){
             $('#SecTab').click();
         }
                 

        function validate_email(email) {
            $('#error_studentemail').hide();

            mycontent = $.ajax({
                async: false,
                dataType: 'json',
                type: 'POST',
                url: "<?php echo base_url(); ?>index.php?Ajax_controller/check_email_exist_allusers/",
                data: {
                    email: email
                },
                success: function(response) {
                    if (response.email_exist == "1") {
                        $('#error_studentemail').html(response.message).show();
                        return false;
                    } else {
                        if ($("#addStudentForm").valid()) {
                            $("#tabs").tabs({
                                active: 1
                            });
                            $("ul.nav li.active").removeClass("active");
                            $(this).addClass("active");
                            var current = $('#ui-id-2');
                            current.css('background-color', '#a02d2d');
                            current.css('color', '#ffffff');
                        }
                    }
                },
                error: function(error_param, error_status) {

                }
            });
        }
    });

    $('#btn1').on('click', function() {
    
    var class_id = $('#class_id').val();
        if(class_id==''){
//              $('#error_studentemail').html('Please Enter Email');
                      document.getElementById('error_classid').innerHTML="Please Select Class";     
         }else{
              document.getElementById('error_classid').innerHTML="";
         }
          var section = $('#section_selector_holder').val();
        if(section==''){
                      document.getElementById('availability').innerHTML="Please Select Section";     
         }else{
              document.getElementById('availability').innerHTML="";
         }

         var course = $('#course').val();
        if(course==''){
            document.getElementById('course').innerHTML="Please Enter Course";     
         }else{
              document.getElementById('availability').innerHTML="";
         }

         
         if((class_id!='') &&(section!='') &&(course!='')){
             $('#ThirdTab').click();
         }
    
    
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 2
            });

            var prev = $('#ui-id-2');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-3');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });

    $('#btn2').on('click', function() {
          var city = $('#city').val();
        if(city==''){
                      document.getElementById('error_city').innerHTML="Please Enter City";     
         }else{
             document.getElementById('error_city').innerHTML="";
         }
         
            var address = $('#address').val();
        if(address==''){
                      document.getElementById('error_address').innerHTML="Please Enter Address";     
         }else{
             document.getElementById('error_address').innerHTML="";
         }
         
            var country = $('#country').val();
        if(country==''){
                      document.getElementById('error_country').innerHTML="Please Enter Country";     
         }else{
             document.getElementById('error_country').innerHTML="";
         }
            var nationality = $('#nationality').val();
        if(nationality==''){
                      document.getElementById('error_nationality').innerHTML="Please Enter Nationality";     
         }else{
             document.getElementById('error_nationality').innerHTML="";
         }
             var place_of_birth = $('#place_of_birth').val();
        if(place_of_birth==''){
                      document.getElementById('eror_POB').innerHTML="Please Enter Place of Birth";     
         }else{
             document.getElementById('eror_POB').innerHTML="";
         }
               var phone = $('#phone').val();
        if(phone==''){
                      document.getElementById('error_phone').innerHTML="Please Enter Phone";     
         }else{
             document.getElementById('error_phone').innerHTML="";
         }
         
         
         if((city!='') &&(address!='')&&(country!='')&&(nationality!='')&&(place_of_birth!='')&&(phone!='')){
             $('#ForthTab').click();
         }
        
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 3
            });
            var prev = $('#ui-id-3');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-4');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });


    $('#btn3').on('click', function() {
        
           var card_id = $('#card_id').val();
        if(card_id==''){
                      document.getElementById('error_card_id').innerHTML="Please Enter Card id";     
         }else{
             document.getElementById('error_card_id').innerHTML="";
         }
         
           var icard_no = $('#icard_no').val();
        if(icard_no==''){
                      document.getElementById('error_icard_no').innerHTML="Please Enter ICard No";     
         }else{
             document.getElementById('error_icard_no').innerHTML="";
         }
         
            var type = $('#type').val();
        if(type==''){
                      document.getElementById('error_type').innerHTML="Please Enter Type";     
         }else{
             document.getElementById('error_type').innerHTML="";
         }
         
         
         if((card_id!='') &&(icard_no!='')&&(type!='')){
             $('#FivthTab').click();
         }
        
        
        
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 4
            });

            var prev = $('#ui-id-4');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-5');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });
    $('#btn4').on('click', function() {
          var searchLocation = $('#searchLocation').val();
        if(searchLocation==''){
                      document.getElementById('error_searchLocation').innerHTML="Please Enter Location";     
         }else{
             document.getElementById('error_searchLocation').innerHTML="";
         }
         
         
         if((searchLocation!='')){
             $('#SixTab').click();
         }
        
        
        if ($("#addStudentForm").valid()) {

            $("#tabs").tabs({
                active: 5
            });
            var prev = $('#ui-id-5');
            prev.css('background-color', '#fff');
            prev.css('color', '#555555');
            var current = $('#ui-id-6');
            current.css('background-color', '#a02d2d');
            current.css('color', '#ffffff');
        }
    });


    function allnumeric(inputtxt) {
        var numbers = /^[0-9]+$/;
        if (inputtxt.value.match(numbers)) {
            alert('Your Registration number has accepted....');
            document.form1.text1.focus();
            return true;
        } else {
            alert('Please input numeric characters only');
            document.form1.text1.focus();
            return false;
        }
    }

    function Validate() {
        var phone = $("#phone");
        if (phone.val().length > 10) {
            $('#error_phone').html('Maximum 10 digits are allowed');
            return false;

        } else if (phone.val().length < 7) {
            $('#error_phone').html('Invalid contact number');

            $("#hidden").val('1');
            return false;
        } else if (isNaN(phone.val())) {
            $('#error_phone').html('Enter a valid phone number');
            return false;

        } else {
            $('#error_phone').html('');
            return true;
        }
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var phone = $("#phone");
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            $('#error_phone').html('Enter numeric value only');
            $("#phone").val('');

            $("#hidden").val('1');

            //return false;

        } else if (phone.val().length > 10) {
            $('#error_phone').html('Maximum 10 digits are allowed');
            //return false;
            $("#hidden").val('1');

        } else if (phone.val().length < 7) {
            $('#error_phone').html('Invalid contact number');
            // return false;
            $("#hidden").val('1');

        } else {
            $('#error_phone').html('');
            $("#hidden").val('0');
            return true;
        }
    }

    function checkavailability(section_id) {
        var class_id = $('#class_id').val();
        $.ajax({
            url: '<?php echo base_url();?>index.php?ajax_controller/check_availability',
            type: 'POST',
            data: {
                class_id: class_id,
                section_id: section_id
            },
            success: function(response) {
                count = JSON.parse(response);
                if (count.allowed === 'no') {
                    $('#availability').html('This section is already filled, try another section');
                } else {
                    $('#availability').html('');
                }
            },
            error: function() {
                alert('error');
            }
        });
    }
 jQuery(document).ready(function () {
         $(".numeric").numeric();
     });
</script>