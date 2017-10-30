<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_faculty_feedback'); ?></h4>
    </div>
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
</div>

<div class="row">
<div class="col-md-12">
        <div class="form-group col-sm-5 p-0" data-step="5" data-intro="<?php echo get_phrase('Select_a_teacher_you_wanted_to_see_the_feedback!!');?>" data-position='top'>
            <label class="control-label"><?php echo get_phrase('Select_Teacher'); ?></label> 
            <select id="teacher_id" class="selectpicker" data-style="form-control"  data-live-search="true">
                <option value="">Select Teacher</option>
                <?php foreach ($teacher_details as $row): ?>
                    <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['name'] ." ". ($row['middle_name']!=''?$row['middle_name']:'') ." ". $row['last_name']; ?></option>                    
                <?php endforeach; ?>
            </select>
        </div>
<div class="col-md-2 pull-right">
    <a href="<?php echo base_url(); ?>index.php?school_admin/faculty_feedback" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Feedback for Teacher" >
        <i class="fa fa-plus"></i>
    </a>        
</div>
</div>  
</div>
<div id="feedback_display">
    
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">    
    jQuery("#teacher_id").change(function () {
        var teacher_id     =   $("#teacher_id option:selected").val();
        $.ajax({
            type   : 'POST',
            url : '<?php echo base_url(); ?>index.php?ajax_controller/get_teacher_details/',
            data : {teacher_id:teacher_id },
            success: function (response){
                if(response)
                    jQuery('#feedback_display').html(response); 
            },
            error:function(xhr,status,error){
                alert('not');
            } 
        });
    });
</script>

