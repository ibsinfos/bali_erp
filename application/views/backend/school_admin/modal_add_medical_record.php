<meta name="viewport" content="width=device-width, initial-scale=1">       
<div class="profile-env"><?php if(!isset($data_not_found)) { ?>
    <header class="row">
        <?php
            if(isset($student_details) && $student_details->stud_image != "" && file_exists('uploads/student_image/'.$student_details->stud_image)) {
                $student_image  =   $student_details->stud_image;
            } else {
                $student_image  =   '';
            }
        ?>
        <div class="col-xs-3"><a href="#" class="profile-picture"><img src="<?php echo ($student_image != "" ?'uploads/student_image/'.$student_image:'uploads/user.jpg')?>" class="img-responsive " /></a></div>

        <div class="col-sm-9"><ul class="p-l-20"><li class="list-unstyled">
                <div class="profile-name">
                    <h3><?php echo $student_name; ?></h3>
                    <p><?php echo get_phrase('Class').' : '.$class.'<br>'; ?><?php echo get_phrase('Section').' : '.$section; ?></p>
                </div></li></ul></div>
    </header><br>
    <section class="profile-info-tabs">

        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center"><b><?php echo get_phrase('enter_patients_details'); ?></b></h3>

                <?php echo form_open(base_url().'index.php?Ajax_controller/add_clinical_record', array('class' =>'form-horizontal form-material p-10','id'=>'studentClinicalForm'));?>

                    <div class="form-group">
                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?>">
                        <label class="col-sm-3" for="gender"><?php echo get_phrase('gender'); ?>:</label>
                        <div class="col-sm-9"><?php echo $gender; ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3" for="birthday"><?php echo get_phrase('birthday'); ?>:</label>
                        <div class="col-sm-9"><?php echo $birthday; ?></div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3" for="age"><?php echo get_phrase('age'); ?>:</label>
                        <div class="col-sm-9"><?php echo $age; ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3" for="mobile"><?php echo get_phrase('mobile'); ?>:</label>
                        <div class="col-sm-9"><?php echo $phone_number; ?></div>
                    </div>
                    <div class="form-group col-xs-12 p-r-0">
                         <label for="history"><?php echo get_phrase('disease'); ?>:</label>
                         
                             <select class="selectpicker1" data-style="form-control" data-live-search="true" name="disease" id="disease">
                                 <option value="">Select Disease</option>
                                 <option value="Asthma" >Asthma</option>
                                 <option value="Diabetes" >Diabetes</option>
                                 <option value="Blood pressure" >Blood pressure</option>
                                 <option value="Medication allergies" >Medication allergies</option>
                                 <option value="Food allergies" >Food allergies</option>
                                 <option value="Other" >Other</option>
                            </select>
                            <span id="diseaseError" class="error hide mandatory"><?php echo get_phrase('select_disease'); ?>:</span>
                       
                    </div>     

                    <div class="form-group col-xs-12 p-r-0">
                        <label for="time date"><?php echo get_phrase('consult_date'); ?>:</label>
                     
                            <input type="text" class="form-control datepicker" placeholder="<?php echo get_phrase('consult_date'); ?>" required="required" name="cunsolt_date" type="text">
                            <span id="cunsultDateError" class="error hide mandatory"><?php echo get_phrase('enter_consult_date.'); ?></span>
                       
                    </div>

                    <div class="form-group  col-xs-12 p-r-0">        
                        <label for="surgical_history"><?php echo get_phrase('description'); ?></label>
                        <div>          
                            <textarea class="form-control" rows="5" id="discription" name="discription" ></textarea>
                            <span id="discriptionError" class="error hide mandatory"><?php echo get_phrase('enter_descriptions'); ?>:</span>
                        </div>
                    </div>

                    <div class="form-group  col-xs-12 p-r-0">        
                        <label  for="obstetric_history"><?php echo get_phrase('diagnosis'); ?>:</label>
                        <div >          
                            <textarea class="form-control" rows="5" id="diagnosis"  name="diagnosis" ></textarea>
                            <span id="diagnosisError" class="error hide mandatory"><?php echo get_phrase('enter_diagnosis_details'); ?></span>
                        </div>
                    </div>

                    <div class="form-group  col-xs-12 p-r-0">        
                        <label for="genetic_diseases"><?php echo get_phrase('prescriptions'); ?>:</label>
                                
                              <textarea class="form-control" rows="5" id="prescriptions" name="prescriptions"></textarea>
                              <span id="prescriptionError" class="error hide mandatory"><?php echo get_phrase('enter_prescription_details'); ?></span>   
                    </div>
                   

                    <div class="col-xs-12 text-right">
                        <button type="submit"class="fcbtn btn btn-danger btn-outline btn-1d" id="insert" name="save_details" value="add_medical_record"><?php echo get_phrase('add_medical_record'); ?></button>
                    </div>


                <?php echo form_close();?>
            </div> 
        </div>		
    </section><?php } else { ?>
    <header class="row"><div class="col-xs-3"><?php echo $data_not_found; ?></div></header><?php } ?>
</div>

<script>    
    $( document ).ready(function() {
        $('#studentClinicalForm').submit(function(e) {
            
            e.preventDefault();
            student_id      =   $("#student_id").val();
            disease         =   $("#disease :selected").val();
            discription     =   $("#discription").val();
            diagnosis       =   $("#diagnosis").val();
            prescription    =   $("#prescriptions").val();
            cunsolt_date    =   $("#cunsolt_date").val();
            var myData = $("#studentClinicalForm").serialize();
            var error       =   0;
            $('.error').hide();
            if(disease == '') { 
                $('#diseaseError').removeClass('hide');
                $('#diseaseError').addClass('show');
                error++;
            } if (discription == '') {
                $('#discriptionError').removeClass('hide');
                $('#discriptionError').addClass('show');
                error++;
            } if (diagnosis == '') {
                $('#diagnosisError').removeClass('hide');
                $('#diagnosisError').addClass('show');
                error++;
            } if (cunsolt_date == '') { 
                $('#cunsultDateError').removeClass('hide');
                $('#cunsultDateError').addClass('show');
                error++;
            }
            if (prescription == '') { 
                $('#prescriptionError').removeClass('hide');
                $('#prescriptionError').addClass('show');
                error++;
            }            
            if (student_id == '') {
                alert("Error");
                error++;
            }
            if(error >=1) {
                return false;
            } else {
                    add_clinic_record_url     =   '<?php echo base_url(); ?>index.php?Ajax_controller/add_clinical_record/';
                    $.ajax({
                        url         :   add_clinic_record_url,  
                        type        :   'POST',
                        dataType    :   'json',
                        data        :   myData,
                        success     :   function(response) {
                         if(response.status == 'success') {
                                var class_id    =   $("#class_id").val();
                                var section_id  =   $("#from_section_selector_holder").val();
                                var get_list    =   'get_list';
                                window.location.href = '<?php echo base_url(); ?>index.php?school_admin/clinical_records/add/'+class_id+'/'+section_id+'/'+get_list;
                            } else {
                            }
                        },
                        error       :   function() {
                        }
                    });
            }
        });
    });
</script>

<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();


    $(function () {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    });
    
</script>