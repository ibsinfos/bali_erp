<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Progress Report Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p><b>Exceeding Level (Ex):</b> The Child is able to understand, apply  and complete the expected task independently.</p>
            <p><b>Expected Level (Exp):</b>The child is able to understand and complete the expected task independently.</p>
            <p><b>Emerging Level (Em):</b>The child needs assistance to understand and complete the expected task.</p>
        </div>
    </div>
</div>   
<?php if ($selected_section != '') { ?>
    <form method="post" action="<?php echo base_url() . 'index.php?teacher/save_progress_report_heading_wise/' . $selected_class . '/' . $selected_section . '/' . $selected_student . "/" . $selected_heading ."/".$selected_term ?>" class="form">
    <?php } ?>
    <!--<div class="row">-->
    <div class="col-md-12 white-box no-padding">
        <div class="col-sm-2 form-group">
            <label class="control-label"><?php echo get_phrase('select_class'); ?></label>
            <select id="class_holder" name="class_id" class="selectpicker class_id" data-style="form-control" data-live-search="true" onchange="return onclasschange(this);" data-step="6" data-intro="<?php echo get_phrase('Here select you class for which you want to progress detail');?> " data-position='top'>
                <option value="">Select Class</option>
                <?php
                //pre($classes);
                foreach ($classes as $row):
                    ?>
                    <option <?php
                    if ($selected_class == $row['class_id']) {
                        echo "selected='selected'";
                    }
                    ?> value="<?php echo $row['class_id']; ?>">
                        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['class_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-2 form-group">
            <label class="control-label"><?php echo get_phrase('select_section'); ?></label>
            <select id="section_holder" name="section_id" class="form-control" data-style="form-control" data-live-search="true" onchange="onsectionchange(this);" data-step="7" data-intro="<?php echo get_phrase('Here select you section for which you want to progress detail');?> " data-position='top'><option value="">Select Section</option>
                <?php foreach ($sections as $section) { ?>
                    <option value="<?php echo $section['section_id'] ?>" <?php if ($selected_section == $section['section_id']) echo "selected"; ?>><?php echo $section['name']; ?></option>';
                    ?>

                <?php } ?>
            </select>
        </div>
        <div class="col-sm-3 form-group">
            <?php // echo $selected_heading; pre($headings); ?>
            <label class="control-label"><?php echo get_phrase('Assessment'); ?></label>
            <select id="heading_holder" name="heading_id" class="selectpicker"  data-style="form-control" data-live-search="true" data-step="8" data-intro="<?php echo get_phrase('Here select you heading for which you want to progress detail');?> " data-position='top'><option value="">Select Assessment</option>
                <?php foreach ($headings as $heading): ?>
                    <option value="<?php echo $heading['heading_id']; ?>"<?php
                    if ($selected_heading == $heading['heading_id']) {
                        echo 'selected=selected';
                    }
                    ?>><?php echo $heading['heading_description']; ?> </option>
<?php endforeach ?>
            </select>
        </div>
         <div class="col-sm-2 form-group">
            <?php // echo $selected_heading; pre($headings); ?>
            <label class="control-label"><?php echo get_phrase('term'); ?></label>
            <select id="term_holder" name="term_id" class="selectpicker" data-style="form-control" data-live-search="true" data-step="9" data-intro="<?php echo get_phrase('Here select you term for which you want to progress detail term wise ');?>" data-position='top'><option value="">Select Term</option>
                <?php foreach ($term_list as $row): ?>
                    <option value="<?php echo $row['term_id']; ?>"<?php
                    if ($selected_term == $row['term_id']) {
                        echo 'selected=selected';
                    }
                    ?>><?php echo $row['name']; ?>
                    </option>
<?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-3 form-group">
            <label class="control-label"><?php echo get_phrase('student'); ?></label>
                <?php //pre($students); die;?>
            <select id="student_holder" name="student_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="onstudentchange(this);" data-step="10" data-intro="<?php echo get_phrase('Here select you student for which you want to progress detail ');?>" data-position='top'>  <option value="">Select Student</option>
                <?php foreach ($students as $data) { ?>
                    <option value="<?php echo $data['student_id']; ?>" <?php if ($selected_student == $data['student_id']) echo "selected"; ?>><?php echo $data['name']; ?></option>
<?php } ?>
            </select>
        </div>
    </div>
    <!--   </div>-->
<?php if ($selected_student != ''){
    if(!empty($head_cate_data)){?>
        <div class="row">
            <div class="col-md-12">
                <div class=" white-box">
                <table class="table table-bordered display" data-step="11" data-intro="<?php echo get_phrase('List of progress detail of student');?>" data-position='bottom' > <?php
                
                    $x = 1;
                    foreach ($head_cate_data as $row): $k = 1;
                        $y = 1;
                        ?>
                            <thead>     
                                <tr>
                                    <th><div><?php echo $x; ?></div></th>
                                    <th><div><?php echo $row['category_des']; ?></div></th>
                                    <th><div><?php echo get_phrase('ex'); ?></div></th>
                                    <th><div><?php echo get_phrase('exp'); ?></div></th>
                                    <th><div><?php echo get_phrase('em'); ?></div></th>
                                    <th><div><?php echo get_phrase('comment'); ?></div></th>
                                    <th><div><?php echo get_phrase('all_report'); ?></div></th>
                                </tr>                                     

                            </thead>
                            <tbody>
                                <?php
                                if (!empty($row['subcat'])) {
                                    $j = 1;
                                    $s = 1;
                                    foreach ($row['subcat'] as $row1):
                                        ?>
                                        <tr>
                                            <td><center><?php echo $x . "." . $y; ?></center></td> 
                <?php if ($row1['ex'] == "") { ?>
                                        <td ><?php echo $row1['sub_desc']; ?></td>
                                        <td><input type="checkbox" value="1" name="ex<?php echo $row['category_id'] . $s; ?>" id="ex<?php echo $row['category_id'] . $s; ?>" onclick="check_one_ex(<?php echo $row['category_id'] . $s; ?>);"></td>
                <?php } else { ?>
                                        <td ><?php echo $row1['sub_desc']; ?></td>
                                        <td><input type="checkbox" value="1" name="ex<?php echo $row['category_id'] . $s; ?>" id="ex<?php echo $row['category_id'] . $s; ?>" onclick="check_one_ex(<?php echo $row['category_id'] . $s; ?>);"></td>
                <?php } ?>
                                    <td><input type="checkbox" value="1" name="exp<?php echo $row['category_id'] . $s; ?>" id="exp<?php echo $row['category_id'] . $s; ?>" onclick="check_one_exp(<?php echo $row['category_id'] . $s; ?>);"></td>
                                    <td><input type="checkbox" value="1" name="em<?php echo $row['category_id'] . $s; ?>" id="em<?php echo $row['category_id'] . $s; ?>" onclick="check_one_em(<?php echo $row['category_id'] . $s; ?>);"></td>
                                    <td><textarea class="form-control" id="comment-<?php echo $row['category_id']; ?>" name="comment-<?php echo $row['category_id'] . $s; ?>" rows="2" cols="5"></textarea></td>
                                    <input type="hidden" class="form-control" id="changed<?php echo $row['category_id'] . $s; ?>" name="changed<?php echo $row['category_id'] . $s; ?>" value="changed<?php echo $row['category_id'] . $s; ?>"/>
                                    <td align="center" data-step="9" data-intro="Form here you can see history of rating" data-position='top'>
                                        <?php if ($row1['view_report'] == 1) { ?>
                                            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/get_progress_report/' . $student_id . '/' . $row1['sub_category_id'].'/'.$selected_term ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View History"><i class="fa fa-eye"></i></button></a>
                                    <?php } else { ?>
                                            <button type="button" disabled="" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View History"><i class="fa fa-eye"></i></button>
                                    <?php } ?>
                                    </td>
                                    <?php
                                    $y = $y + 1;
                                    $s = $s+1;
                                endforeach;
                                $x = $x+1;  
        $j = $j + 1;
                                }else{
                                      echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>Please Add Subcategory in Category !!!
                    </div>
                </div> 
            </div></div>";
                                }
    endforeach;
    ?>
                        </tr>
                        </tbody>
                    </table>

                    <div class="text-right">
                        <button id="submit_button" class="fcbtn btn btn-danger btn-outline btn-1d" type="submit">
                            <i class="entypo-check"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
<?php } 
    else{
          echo "<div class='col-md-12 no-padding'> <div class='panel panel-danger'>
                <div class='panel-heading'>
                    <div class='panel-title text-white'>Please Add Category and Subcategory in Assessment !!!
                    </div>
                </div> 
            </div></div>";
    }
    }
?>
</form>

<script>
    function setColor(obj) {
        var rating = parseFloat(obj.text());
        var color;
        var parts = (rating > 5) ? (1 - ((rating - 5) / 5)) : rating / 5;
        parts = Math.round(parts * 255);
        if (rating < 5) {
            color = [255, parts, 0];
        } else if (rating > 5) {
            color = [parts, 255, 0];
        } else {
            color = [255, 255, 0]
        }
        obj.css('color', 'rgb(' + color.join(',') + ')');
        obj.css('background', 'rgb(' + color.join(',') + ')');
    }

    $(function () {
        $('span.rating').each(function () {
            setColor($(this));
        });
    });


    function onclasschange(class_id)
    {
        //alert(class_id.value);
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");

        //FOR SHOW HEADING ACCORDING  TO CLASS

        jQuery('#heading_holder').html('<option value="">Select Assessment</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?teacher/get_teacher_class_heading/' + class_id.value,
            success: function (response)
            {
                jQuery('#heading_holder').append(response).selectpicker('refresh');
            }
        });
        $('#heading_holder').trigger("chosen:updated");
    }
    function onsectionchange(section_id)
    {
        var class_id = $('#class_holder').val();
        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?teacher/get_teacher_student/' + section_id.value + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
        $('#student_holder').trigger("chosen:updated");
    }
    function onstudentchange(student_id)
    {
        // remove the below comment in case you need chnage on document ready
        var section = $("#section_holder option:selected").val();
        var student = student_id.value;
        var classname = $("#class_holder option:selected").val();
        var heading = $("#heading_holder option:selected").val();
        var term = $("#term_holder option:selected").val();
        location.href = "<?php echo base_url(); ?>index.php?teacher/progress_report_heading_wise/" + classname + "/" + section + "/" + student + "/" + heading + "/" +term;
    }

    function check_one_ex(id) {
        $('#em' + id).attr('checked', false);
        $('#exp' + id).attr('checked', false);
        $("#changed" + id).val("1");
    }
    function check_one_exp(id) {
        $('#em' + id).attr('checked', false);
        $('#ex' + id).attr('checked', false);
        $("#changed" + id).val("1");
    }
    function check_one_em(id) {
        $('#exp' + id).attr('checked', false);
        $('#ex' + id).attr('checked', false);
        $("#changed" + id).val("1");
    }



</script>
