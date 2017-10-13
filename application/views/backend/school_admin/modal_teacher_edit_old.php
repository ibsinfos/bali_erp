<?php
pre($teacher_record); die;
    $row = (array) $teacher_record;
    if (!empty($row))
    {
         
?>
        
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('edit_teacher'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/teacher/do_update/' . $row[ 'teacher_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo'); ?></label>

                    <div class="col-sm-5">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                <img src="<?php echo $this->crud_model->get_image_url('teacher', $row['teacher_id']); ?>" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="userfile" accept="image/*">
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('first_name'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="first_name" value="<?php echo $row['name']; ?>" data-validate="required"/>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('middle_name'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="middle_name" value="<?php echo $row['middle_name']; ?>"/>
                    </div>
                </div>               
              
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('last_name'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name']; ?>"data-validate="required"/>
                    </div>
                    
                    <label class="col-sm-2 control-label"><?php echo get_phrase('date_of_birth'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" name="birthday" onchange="return agecalculate();"  value="" data-validate="required">
                    </div>
                                               
                </div>
                
                  <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo get_phrase('gender'); ?></label>
                    <div class="col-sm-4">
                        <select name="gender" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required"
                            <option value="Male" <?php if ($row['gender'] == 'male' ) echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
                            <option value="Female" <?php if ($row['gender'] == 'female' ) echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('religion'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="religion" value="<?php echo $row['religion']; ?>"/>
                    </div>        
                                                     
                </div>
                
                
                 <div class="form-group">
                     <label class="col-sm-2 control-label"><?php echo get_phrase('nationality'); ?></label>
                    <div class="col-sm-4">
                        <select id="" name ="nationality" class="selectpicker1" data-style="form-control" data-live-search="true" class="bfh-countries" data-country="" data-validate="required"></select>
                    </div>

                    <label class="col-sm-2 control-label"><?php echo get_phrase('blood_group'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="blood_group" value="<?php echo $row['blood_group']; ?>"/>
                    </div>       
                   
                    
                </div>
                
                <div class="form-group">
                     <label class="col-sm-2 control-label"><?php echo get_phrase('designation'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="job_title" value="<?php echo $row['job_title']; ?>"data-validate="required"/>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('Highest_degree'); ?></label>
                    <div class="col-sm-4">
                        <select name="qualification" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="<?php echo get_phrase('qualification_required'); ?>">
                            <option value=""><?php echo get_phrase('-Select--'); ?></option>
                            <option value="Phd" <?php if($row['qualification']=="Phd") echo 'selected';?>><?php echo get_phrase('Phd'); ?></option>
                            <option value="MCA" <?php if($row['qualification']=="MCA") echo 'selected';?>><?php echo get_phrase('MCA'); ?></option>
                            <option value="M.A" <?php if($row['qualification']=="M.A") echo 'selected';?>><?php echo get_phrase('M A'); ?></option>
                            <option value="MBA" <?php if($row['qualification']=="MBA") echo 'selected';?>><?php echo get_phrase('MBA'); ?></option>
                            <option value="B.Tech" <?php if($row['qualification']=="B.Tech") echo 'selected';?>><?php echo get_phrase('B.Tech'); ?></option>
                            <option value="M.Sc" <?php if($row['qualification']=="M.Sc") echo 'selected';?>><?php echo get_phrase('M.Sc'); ?></option>
                            <option value="M.Tech" <?php if($row['qualification']=="M.Tech") echo 'selected';?>><?php echo get_phrase('M.Tech'); ?></option>
                            <option value="M.Phill" <?php if($row['qualification']=="M.Phill") echo 'selected';?>><?php echo get_phrase('M.Phill'); ?></option>
                            <option value="MS" <?php if($row['qualification']=="MS") echo 'selected';?>><?php echo get_phrase('B.Sc'); ?></option>                                
                        </select>
                    </div>
                           
                    
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('Specialization'); ?></label>
                    <div class="col-sm-4">                        
                        <select name="stream" class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option value="">Select Subject</option>
                            <?php
                            $subjects = $this->db->get('subject')->result_array();
                            foreach ($subjects as $row2): ?>
                            <option value ="<?php echo $row2['name']; ?>" <?php if ($row['specialisation'] == $row2['name']) echo 'selected'; ?> ><?php echo $row2['name']; ?></option>
                            <?php endforeach; ?>
                        </select>                   
                    </div>          
                    <label class="col-sm-2 control-label"><?php echo get_phrase('Exp in Yrs'); ?></label>
                    <div class="col-sm-4">
                     <select name="expereince" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                        <option value=""><?php echo get_phrase('select'); ?></option>
                        <option value="0-2" <?php if($row['experience']=="0-2") echo 'selected';?>><?php echo get_phrase('0-2 years'); ?></option>
                        <option value="2-4" <?php if($row['experience']=="2-4") echo 'selected';?> ><?php echo get_phrase('2-4 years'); ?></option>
                        <option value="4-6" <?php if($row['experience']=="4-6") echo 'selected';?> ><?php echo get_phrase('4-6 years'); ?></option>
                        <option value="6+" <?php if($row['experience']=="6+") echo 'selected';?> ><?php echo get_phrase('6+ years'); ?></option>
                    </select>  
                    </div>
                    
                </div>    
                
                 <div class="form-group">   
                     <label class="col-sm-2 control-label"><?php echo get_phrase('Awards_&_Honours'); ?></label>
                    <div class="col-sm-4">
                        <textarea rows='1' cols="20" class="form-control" name="awards" data-validate="required"><?php echo $row['awards']; ?></textarea>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('Employement_history'); ?></label>
                    <div class="col-sm-4">
                        <textarea rows='1' cols="20" class="form-control" name="summary" data-validate="required"><?php echo $row['summary']; ?></textarea>
                    </div>
                </div>
                 
                                
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('address'); ?></label>
                    <div class="col-sm-10">
                        <textarea rows='1' cols="20" class="form-control" name="address"data-validate="required"><?php echo $row['address']; ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('country'); ?></label>
                    <div class="col-sm-4">
                        <select id="countries_states1" name ="country" class="selectpicker1" data-style="form-control" data-live-search="true" class="bfh-countries" data-country="US" data-validate="required"></select>
                    </div>
                     <label class="col-sm-2 control-label"><?php echo get_phrase('state'); ?></label>
                    <div class="col-sm-4">
                        <select  name ="state" class="selectpicker1" data-style="form-control" data-live-search="true" class="bfh-states" data-country="countries_states1" data-state="Select State" data-validate="required"></select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('city'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="city" value="<?php echo $row['city']; ?>"data-validate="required"/>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('zip_code'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="zip_code" value="<?php echo $row['zip_code']; ?>"data-validate="required"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('mobile_#'); ?></label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="cell_phone" value="<?php echo $row['cell_phone']; ?>"required maxlength="12"/>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('Residence_#'); ?></label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="home_phone" value="<?php echo $row['home_phone']; ?>" pattern="[\+]\d{3}[\-]\d{5-9}" title="Phone Number (Format: +999-999999)"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('work_#'); ?></label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="work_phone" value="<?php echo $row['work_phone']; ?>" pattern="[\+]\d{3}[\-]\d{5-9}" title="Phone Number (Format: +999-999999)"/>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('card_id'); ?></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="card_id" value="<?php echo $row['card_id']; ?>" required="" maxlength="15" title="Enter card id no"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('save_teacher'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php
    }
?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMYxg14UXa4Hw27bLPNJkPF9_ntDrDLJA&libraries=places"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/new_assets/js/bootstrap-formhelpers.min.js"></script>
<script src="assets/new_assets/css/bootstrap-formhelpers.min.css"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script type="text/javascript">
    $(function() {
    $( "#datepicker" ).datepicker({  maxDate: new Date() });
    });
    function agecalculate(){    
            var dob = $(".datepicker").val();
            var now = new Date();
            var d = new Date();
            var year = d.getFullYear() - 18;
            d.setFullYear(year);
            var birthdate = dob.split("/");
            var born = new Date(birthdate[2], birthdate[1]-1, birthdate[0]);
            age=get_age(born,now);
            if (age<=18)
            {
                alert("Age should be greater than or equal to 18");
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
     
    $('.modal-dialog').css('width:1070px !important;');  
</script>