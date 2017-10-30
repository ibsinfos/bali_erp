<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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

<?php echo form_open(base_url() . 'index.php?school_admin/clinical_records', array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data', 'id' => 'ClinicalRecords', 'method' => 'POST')); ?>
<div class="col-xs-12 white-box">
    <div class="col-xs-6">
        <div data-step="5" data-intro="<?php echo get_phrase('Please_select_class_here.');?>" data-position='top'>
            <label><?php echo get_phrase('select_class'); ?></label>
            <select name="class_id" id="class_id"  class="selectpicker" data-style="form-control" data-live-search="true" required="" >
                <option value=""><?php echo get_phrase('select'); ?></option><?php $selected = '';
foreach ($classes as $row): if (isset($formSubmit)) {
        $selected = ($class_id == $row['class_id'] ? 'selected' : '');
    } ?>                        <option <?php echo $selected ?> value="<?php echo $row['class_id']; ?>"><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></option><?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-xs-6">
        <div data-step="6" data-intro="<?php echo get_phrase('Please_select_section_here/');?>" data-position='top'>
            <label><?php echo get_phrase('select_section'); ?></label>
            <select name="from_section_id" id="from_section_selector_holder" class="selectpicker" data-style="form-control" data-live-search="true">
<?php if (isset($formSubmit)) {
    $selected = '';
    foreach ($sections as $key => $section) {
        $selected = ($section_id == $section->section_id ? 'selected' : '' ); ?>
                        <option <?php echo $selected ?> value="<?php echo $section->section_id; ?>"><?php echo get_phrase('Section'); ?>&nbsp;<?php echo $section->name; ?></option> <?php }
} else { ?>
                    <option value=""><?php echo get_phrase('select_class_first'); ?></option><?php } ?>
            </select>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <div class="btn-center-in-sm clinical-record"><button class="btn btn-danger m-t-20" type="submit" name="get_list" value="get_list" onclick="get_students_to_promote()" data-step="7" data-intro="<?php echo get_phrase('Click_here_to_get_records.');?>" data-position='bottom'>VIEW STUDENTS</button></div>
        <div id="students_for_promotion_holder"></div>
    </div>
</div>
<?php echo form_close(); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="table-responsive" data-step="8" data-intro="<?php echo get_phrase('Here_records_display');?>" data-position='top'>
                <table id="example23" class="table display nowrap">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('No'); ?></div></th>
                            <th><div><?php echo get_phrase('student_name'); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                            <th><div><?php echo get_phrase('section'); ?></div></th>
                            <th><div><?php echo get_phrase('Emirates_id'); ?></div></th>
                            <th><div><?php echo get_phrase('blood_group'); ?></div></th>
                            <th><div><?php echo get_phrase('emergency_contact'); ?></div></th>
                            <th><div><?php echo get_phrase('records'); ?></div></th>
                            <th><div><?php echo get_phrase('action'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody><?php $count = 1;
if (!empty($student_details)) {
    foreach ($student_details as $key => $student_rec): $student = $student_rec['details']; ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>               
                                    <td><?php echo $student['name']; ?></td>
                                    <td><?php echo $student['class_name']; ?></td>
                                    <td><?php echo $student['section_name']; ?></td>
                                    <td><?php echo $student['emirates_id']; ?></td>
                                    <td><?php echo (!empty($student['blood_group']) ? $student['blood_group'] : 'Blood group is not updated'); ?></td>
                                    <td><?php echo (!empty($student['emergency_contact_number']) ? $student['emergency_contact_number'] : 'No Emergency Contact'); ?></td>
                                    <td><?php echo (!empty($student_rec['medical_records']) ? count($student_rec['medical_records']) : 'No records') ?></td>
                                    <td>
                                        <span>
                                            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/add_medical_record/' . $key; ?>');" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Medical Record">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </span>
        <?php if (!empty($student_rec['medical_records'])) { ?>
                                            <span><a class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/view_all_medical_record/' . $key.'/'.$class_id.'/'.$section_id; ?>');"><i class="fa fa-eye"></i></a></span><?php } ?></td>
                                </tr><?php endforeach;
} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    $('#class_id').change(get_from_class_sections);
    function get_from_class_sections() {
        var class_id = $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#from_section_selector_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>
