     
<div class="row">
<div class="col-sm-12 white-box">
    <?php echo get_phrase('list_of_students_applied_to_class'); ?> <?php echo $class_name; ?>
</div>
</div>

    

<div class="row">
<div class="col-sm-12 white-box">    
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead align="center">
                <tr>
                    <td align="center"><?php echo get_phrase('name_of_the_student'); ?></td>
                    <td align="center"><?php echo get_phrase('class_applied_for'); ?></td>                    
                    <td align="center"><?php echo get_phrase('grade_info'); ?></td>
                    <td align="center"><?php echo get_phrase('transport_info'); ?></td>
                    <td align="center"><?php echo get_phrase('dormitory_info'); ?></td>
                    <td align="center"><?php echo get_phrase('enroll_class'); ?></td>
                    <td align="center"><?php echo get_phrase('select_student'); ?></td>
            </thead>
            
            <tbody>
                <?php   
                    foreach ($applied_students_list as $row):?>
                        <tr>
                            <td align="center">
                                <?php echo $row["student_fname"]." ".$row["student_lname"];?>
                                <input type="hidden" name="route_id[]" id="route_id<?php echo $row['student_id'];?>"  value=""/>

<input type="hidden" name="room_id[]" id="room_id<?php echo $row['student_id'];?>"  value=""/>

                            </td>
                            <td align="center">
                                <?php echo $class_name;?>
                            </td>
                            <td align="center">
                                <select name ="grade[]" id="grade" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                                    <option value="">Grade</option>
                                    <option value="A+">A+</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </td>
                            <td align="center">
                                <select onchange="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_transport_routes/<?php echo $row['student_id'];?>');" name ="transport[]" id="transport" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                                    <option value="">Transport</option>
                                    <option value="Auto"><?php echo get_phrase('Auto');?></option>
                                    <option value="Bus"><?php echo get_phrase('Bus');?></option>
                                    <option value="Not required"><?php echo get_phrase('Others');?></option>
                                </select>
                            </td>
                            <td align="center">
                                <select onchange="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_dormitory_rooms/'+this.value+'/<?php echo $row['student_id'];?>');" name ="dormitory[]" id="dormitory" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                                    <option value="Not required">Not required</option>
                                    <?php foreach ($hostels as $hostel):?>
                                    <option value="<?php echo $hostel['dormitory_id'];?>"><?php echo $hostel['name']; ?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td>
                                <?php //if ($query->num_rows() < 1): ?>
                                <select class="selectpicker" data-style="form-control" data-live-search="true" name="enroll_class[]" id="enroll_student" required="required">
                                    <option value="">Select Class</option>
                                    <?php foreach($classes_list as $enroll):?>
                                    <option value="<?php echo $enroll['class_id'];?>" <?php if($enroll['class_id']==$class_id_from){ echo "selected";}?>><?php echo get_phrase('enroll_to_class') . " - " . $enroll['name']; ?>
                                    </option> 
                                    <?php endforeach;?>
                                </select>
                            <?php //endif; ?>
   
                            </td>
                            <td><input type="checkbox" name="student_ids[]" value="<?php echo $row['student_id'];?> " required="required"></td>
                        <tr>
                <?php endforeach;?>       
            </tbody>
</table>


<div class="text-right col-xs-12 p-t-20">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
           <?php echo get_phrase('enroll_students'); ?>
        </button>
</div>


</div>
</div> 

<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();


$('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });