<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('allot_assignment'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('allot_assignment'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php    
 $student_id1 = 1; 
    if($this->session->flashdata('flash_message_error')) {?>        
    <div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
<?php } ?>

<div class="row">    
    <div class="col-md-12">
        <div class="white-box">
               <?php //if (!empty($classes)){ ?>                          
                <?php echo form_open(base_url().'index.php?teacher/allot_assignment/create/'.$student_id1.'/'.$subject_id , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
              
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('title'); ?><span class="error mandatory"> *</span></label>
                        <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-text-width"></i></div>
                            <input type="hidden" value="<?php echo $student_id;?>" name="student_id">
                            <input type="hidden" value="<?php echo $subject_id;?>" name="subject_id">
                            <input type="text" name="title" class="form-control" id="field-1" required>
                        </div>
                    </div>
                    </div>
        <br>
                    
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-ta">
                            <?php echo get_phrase('description'); ?><span class="error mandatory">*</span></label>
                       <textarea name="description" class="form-control wysihtml5" id="field-ta" data-stylesheet-url="assets/css/wysihtml5-color.css" required></textarea>
                        </div>
                    </div>
        <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                             <label><?php echo get_phrase('date_of_creation'); ?><span class="error mandatory"> *</span></label>
                            <div class="input-group date datetimepicker1">
    			    <span class="input-group-addon">
    				<span class="glyphicon glyphicon-calendar"></span>
    			    </span>
			    <input name="date_of_creation" required="required" class="form-control" type="text">
    			    </div>
                             
                             
<!--                       <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                        
                        <input type="text" name="date_of_creation" class="form-control date-close-start1" id="date_of_creation" required>
                        </div>-->
                        </div> 
                    </div>
        <br>
                
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label><?php echo get_phrase('date_of_submission'); ?><span class="error" style="color: red;"> *</span></label>
                       <div class="input-group date datetimepicker1">
    			    <span class="input-group-addon">
    				<span class="glyphicon glyphicon-calendar"></span>
    			    </span>
                           <input type="text" name="date_of_submission" class="form-control date-close-start1" id="date_of_submission" required>
                        </div>
                    </div>
                    </div>
        <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label><?php echo get_phrase('file_to_upload'); ?></label>
                        <div class="input-group">
                        <input type="file" name="file_name" class="form-control file2 inline btn " data-label="<i class='entypo-upload'></i> Browse"/>
                       </div>                        
                    </div>
                        
                    </div>
        <div class="col-xs-12 col-md-offset-3 col-md-6">
        <span class="mandatory"><?php echo get_phrase('supported_types_:_.doc_.xls_.pdf_.img');?></span>
        </div>      
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('allot_assignment');?></button>
                    </div>
                <?php echo form_close();?>           
            </div>  
                <?php //} else {?>
<!--            <div class="panel-body">
                <label>No class assigned for this teacher </label>
            </div>-->
            <?php //}?>
        </div>
    </div>
<script>
    
      $(document).ready(function () {
        $('.date-close-start1').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language: 'en',
            changeMonth: true,
            changeYear: true,
            startDate: new Date(),
            autoclose: true
        }).on('change', function () {
            $('.datetimepicker').hide();
        });
    });
        $(function () {
            $('.datetimepicker1').datetimepicker({
                startDate:new Date(),
                format: 'yyyy-mm-dd hh:ii'
            });
        });
    
   /* $( function() {
         $("#date_of_creation,#date_of_submission").datepicker({ 
            changeMonth: true,
            changeYear: true,
            startDate: new Date(),
            autoclose: true
        });
        */
//        $( "#date_of_creation" ).datepicker();
//        $( "#date_of_submission" ).datepicker();
//    });
</script>