<style type="text/css">
    .MarkError{border-color: red;}
    .MarkMsgError{color: red;}
</style>

<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php echo form_open(base_url() . 'index.php?school_admin/marks_selector'); ?>
        <div class="col-md-12 white-box">
            <div class="col-sm-3 form-group">
		<div class="form-group col-sm-12 p-0" data-step="5" data-intro=" <?php echo get_phrase('Select a exam, for which you want to manage marks.');?>" data-position='right'>
                <label class="control-label"><?php echo get_phrase('exam'); ?></label><span class="error" style="color: red;"> *</span>
                <select name="exam_id" class="selectpicker" data-style="form-control" data-live-search="true" id="exam_id" required>
        <?php if(count($exams)){ foreach($exams as $row):?>
                    <option value="<?php echo $row['exam_id'];?>"
                        <?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                    <?php endforeach; }?>
                </select>
		</div></div>

            <div class="col-sm-3 form-group">
		<div class="form-group col-sm-12 p-0" data-step="6" data-intro=" <?php echo get_phrase('Select a class, for which you want to manage marks.');?>" data-position='right'>
                <label class="control-label"><?php echo get_phrase('class');?></label><span class="error" style="color: red;"> *</span>
                <select name="class_id" id="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="get_class_subject(this.value)">
                    <option value=""><?php echo get_phrase('select_class');?></option>
    <?php if(count($classes)){ foreach($classes as $row): ?>
                    <option value="<?php echo $row['class_id'];?>"
                        <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option><?php endforeach; }?>
                </select>
		</div></div>

            <div id="subject_holder">
                <div class="col-md-3 col-sm-6 col-xs-12">
		    <div class="form-group col-sm-12 p-0" data-step="7" data-intro="<?php echo get_phrase(' Select a section, for which you want to manage marks.');?>" data-position='right'>
                    <div class="form-group">                    
                        <label class="control-label"><?php echo get_phrase('section');?></label><span class="error" style="color: red;"> *</span>                  
                        <select name="section_id" id="section_id" class="selectpicker" data-style="form-control" data-live-search="true">
    <?php if(count($sections)){ foreach($sections as $row): ?>
                            <option value="<?php echo $row['section_id'];?>" <?php if($section_id == $row['section_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                            <?php endforeach; }?>
                        </select>
                    </div>
		    </div></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
		    <div class="form-group col-sm-12 p-0" data-step="8" data-intro=" <?php echo get_phrase('Select a subject, for which you want to manage marks.');?>" data-position='bottom'>
                    <div class="form-group">                    
                        <label class="control-label"><?php echo get_phrase('subject');?></label><span class="error" style="color: red;"> *</span>              
                        <select name="subject_id" id="subject_id" class="selectpicker" data-style="form-control" data-live-search="true">
<?php if(count($subjects)){ foreach($subjects as $row): ?>
                            <option value="<?php echo $row['subject_id'];?>" <?php if($subject_id == $row['subject_id']) echo 'selected';?>> <?php echo $row['name'];?></option><?php endforeach; }?>
                        </select>
                    </div>
		    </div></div>
<div class="text-right col-xs-12">
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('manage_marks');?></button>
</div>
            </div>
        </div>

<?php echo form_close(); ?>

<?php echo form_open(base_url() . 'index.php?school_admin/marks_update/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id); ?>
  
        <div class="col-md-12 no-padding">
            <div class="col-md-3 no-padding m-b-10" data-step="9" data-intro="<?php echo get_phrase('Maximum Marks');?>" data-position='bottom'>
                <label class="control-label"><?php  echo get_phrase('maximum_marks'); ?></label>
<input type="text" class="form-control" required name="maximum_marks" value="<?php if(!empty($marks_of_students)){ echo $marks_of_students[0]['mark_total'];}else{echo '0';} ?>" data-validate="required" data-message-required ="Please select maximum marks" onchange="ValidateMarks()" id="MaxMarks">
            </div>
        </div>
              
    
<div class="form-group col-sm-12 p-0" data-step="10" data-intro="<?php echo get_phrase('Here you can view and edit exam marks.');?>" data-position='bottom'>
        <div class="col-md-12 white-box">
            <div class="text-center m-b-20">
             <h3><?php echo get_phrase('marks_for_').$exam_name.get_phrase(' class ').$class_name.' : '.get_phrase(' section ').$section_name.get_phrase(' subject ').' : '.$subject_name;?></h3>
            </div>
            <table id="table" class="table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('serial_no.');?></div></th>
                        <th><div><?php echo get_phrase('roll');?></div></th>
                        <th><div><?php echo get_phrase('name');?></div></th>
                        <th><div><?php echo get_phrase('marks_obtained');?></div></th>
                        <th><div><?php echo get_phrase('comment');?></div></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
	    
	    <div class="text-right col-xs-12 p-t-20">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="update_button"><?php echo get_phrase('update_marks');?></button>

            <a href="<?php echo base_url(); ?>index.php?school_admin/exam_settings" class="fcbtn btn btn-danger btn-outline btn-1d" id="submit_button"><?php echo get_phrase('back_to_exam_settings');?></a>
        </div>

	       
        </div>
</div>
<?php echo form_close();?>

<script type="text/javascript">
    function get_class_subject(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/marks_get_subject/' + class_id,
            success: function (response)
            {
                jQuery('#subject_holder').html(response).selectpicker('refresh');
            }
        });

    }
	
</script>

<script>
    var table;

    $(document).ready(function() {

//        var SearchName = $('#PublicSearch').val();
        var exam_id = $('#exam_id').val();
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();

        //datatables
        table = $('#table').DataTable({ 

            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
           
            "ajax": {
                "url": "<?php echo base_url().'index.php?ajax_controller/get_marks_manage_list/';?>",
                "type": "POST",
                 data    :  {exam_id:exam_id, class_id:class_id,section_id:section_id,subject_id:subject_id}
        
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

//        if(SearchName!=''){            
//            table.search(SearchName).draw();
//        }
    });
    
    function ValidateMarks(){
        var maximum_marks = $('#MaxMarks').val();

        var GreenFlag = 0;
        var YellowFlag = 0;

        $(".marks_obtained").each(function() {
            if($(this).val() != ""){
                 GreenFlag+=1;

                var MyMark = $(this).val();
                $(this).next('p').remove();

                if(parseInt(MyMark) > parseInt(maximum_marks)){
                    $(this).addClass('MarkError');
                    $(this).after('<p class="MarkMsgError">Maximum allowed marks'+ ' ' + maximum_marks+'</p>');
                }else{
                    YellowFlag+=1;

                    $(this).removeClass('MarkError');
                    $(this).next('p').remove();
                }
            }
            
        });

        if(GreenFlag == YellowFlag){
            $('#update_button').prop("disabled", false);
        }else{
            $('#update_button').prop("disabled", true);    
        }
    } 



</script>
