<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_assignment'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_assignments'); ?></li>
        </ol>  
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if(!empty($first_subject)){ $subject_id = $first_subject[0]['subject_id'];
}else{ $subject_id = '';  }

?>
<div class="row" >
    <div class="col-md-10">
    <div class="form-group col-sm-6" style="padding: 0;" data-step="5" data-intro="<?php echo get_phrase('Here you can see select the subject for which you want to see the assignmemt list.');?>" data-position='top'>
        <label class="control-label"><?php echo get_phrase('select_subject');?></label>
        <select data-style="form-control" data-live-search="true" class="selectpicker" onchange="return get_assignments(this.value);">
            <option value=""><?php echo get_phrase('select_subject');?></option>
                <?php foreach ($subjects as $row):?>
                <option <?php if ($subject_id == $row['subject_id']) {  echo 'selected'; }?> value="<?php echo $row['subject_id']; ?>">
                <?php echo $row['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    </div>
</div>
<input type="hidden" value ="<?php echo $student_id;?>" id ="student_id" name = "student_id">

<div id="assignment_display">
    
</div>
<script type="text/javascript">
    var first_subject = "<?php echo $first_subject[0]['subject_id']; ?>";
    if(first_subject!='' && first_subject>0) {
    get_assignments(first_subject);
    }
function get_assignments(subject_id){
    var student_id  =  $('#student_id').val();
    //alert(subject_id+student_id); exit;
    $.ajax({
        type   : 'POST',
        url : '<?php echo base_url(); ?>index.php?ajax_controller/get_subject_wise_assignment/',
        data : {student_id:student_id, subject_id:subject_id },
        success: function (response){
            if(response)
                jQuery('#assignment_display').html(response); 
        },
//        error:function(xhr,status,error){
//            alert('not');
//        } 
    });
}    
</script>

