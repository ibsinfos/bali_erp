<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('All Teacher'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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

<div class="row m-0">
    <div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('From here select class and subject.');?>" data-position="top">
        <div class="col-sm-6 form-group">                
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
            <span class="error" style="color: red;"> </span>
            <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id" id="class_id" onchange="showClass(this.value);">
                <option value="">Select Class</option>
                <?php foreach ($class_arr AS $k): ?>
                    <option value="<?php echo $k->class_id; ?>" <?php if ($k->class_id == $class_id) { ?>selected<?php } ?>><?php echo $k->name; ?></option>
                <?php endforeach; ?>
            </select>                
        </div>

        <div class="col-sm-6 form-group subject_selector">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject'); ?></label>
            <span class="error" style="color: red;"> </span>

            <select name="subject_id" id="subject_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value=""><?php echo get_phrase('select_subject'); ?></option>
                <?php foreach ($subject_arr AS $k): ?>
                    <option value="<?php echo $k->subject_id; ?>" <?php if ($k->subject_id == $subject_id) { ?>selected<?php } ?>><?php echo $k->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


</div>


<div class="row m-0">
    <div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('From here you can see the list of teachers.');?>" data-position="top">    
        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('No'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('email'); ?></div></th>
                    <th><div><?php echo get_phrase('phone'); ?></div></th>
                    <th><div><?php echo get_phrase('options'); ?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($teachers as $row):
                    $count++;
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['cell_phone']; ?></td>
                        <td>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_teacher_view/<?php echo $row['teacher_id']; ?>');"> 
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Profile"><i class="fa fa-eye"></i></button>
                            </a>

                            <!--edit-->
                            <a href="<?php echo base_url(); ?>index.php?school_admin/teacher/update_passcode/<?php echo $row['teacher_id']; ?>" target="_blank">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Update Passcode"><i class="fa fa-key"></i></button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">


    function uupdateTeacherFilter() {
        var class_id = $("#class_id").val();
        var subject_id = $('#subject_id').val();
        if (class_id == "undefined" && class_id == "") {
            return false;
        }
        var url = "<?php echo base_url() . "index.php?admin_report/teacher_misc_report/"; ?>" + class_id + "/" + subject_id;
        //alert(url)
        location.href = url;
    }

    function showClass(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/class_get_subject/' + class_id,
            success: function (response) {
                jQuery('.subject_selector').html(response);
                jQuery('#subject_id').selectpicker('refresh');
            },
            error: function (err) {
                console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }
        });
    }

    function UpdateTeacherFilter(SubjectId) {
        var class_id = $("#class_id").val();
        if (class_id == "undefined" || class_id == "") {
            return false;
        }
        if (SubjectId == "undefined" || SubjectId == "") {
            return false;
        }
        var url = "<?php echo base_url() . "index.php?admin_report/teacher_misc_report/"; ?>" + class_id + "/" + SubjectId;
        location.href = url;
    }
</script>

