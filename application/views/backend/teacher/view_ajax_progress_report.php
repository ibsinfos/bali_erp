<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase('progress_report-Subject_wise'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('progress_report'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report_heading_wise"><?php echo get_phrase('progress_details'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report_heading_setting"><?php echo get_phrase('progress_report_setting'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/report_term"><?php echo get_phrase('report_term'); ?></a></li>  
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('subject_wise'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<input type="hidden" name="c_id" id="selected_class" value="<?php echo $class_id; ?>">
<input type="hidden" name="selected_section" id="selected_section" value="<?php echo $selected_section; ?>">
<input type="hidden" name="selected_subject" id="selected_subject" value="<?php echo $selected_subject; ?>">
<?php 

if($selected_section!=''){?>
    <form method="post" action="<?php echo base_url() . 'index.php?teacher/save_progress_report/'.$class_id.'/'.$selected_section.'/'.$selected_subject;?>" class="form">
<?php }?>
        <!--<div class="row">-->
	    <div class="col-md-12 white-box no-padding">
<div class="form-group col-xs-12 col-sm-4">
    <label><?php echo get_phrase('select_class');?></label>
    <select id="class_holder" name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this);" data-step="5" data-intro="Here you select class for which you want to see the progress report" data-position='bottom'>
        <option value="">Select Class</option>
        <?php
        foreach ($classes as $row): ?>
        <option <?php if ($class_id==$row['class_id']){echo "selected='selected'"; }?> value="<?php echo $row['class_id']; ?>">
        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $this->crud_model->get_class_name($row['class_id']) ;?>
        </option>
        <?php endforeach; ?>
    </select>
</div>
   <div class="form-group col-xs-12 col-sm-4">
    <label class="control-label"><?php echo get_phrase('select_section');?></label>
    <select id="section_holder" name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsectionchange(this.value);" data-step="6" data-intro="Here you select section for which you want to see the progress report" data-position='bottom'>
        <option value=''>Select Section</option>
        <?php foreach ($sections as $section){ ?>
           <option value="<?php echo $section['section_id']  ?>" <?php if($selected_section == $section['section_id'] ) echo "selected"; ?>><?php echo $section['name']; ?></option>
           <?php } ?>
    </select>
</div>
    <div class="col-xs-12 col-sm-4">
    <div class="form-group">
    <label class="control-label"><?php echo get_phrase('subject');?></label>
    <select id="subject_holder" name="subject_id" data-style="form-control" data-live-search="true" class="selectpicker" data-step="7" data-intro="Here you select subject for which you want to see the progress report" data-position='bottom' onchange="get_progress_report_list();">
<option value="">Select subject</option>        
  <?php     foreach ($subjects as $subject){ ?>
           <option value="<?php echo $subject['subject_id']  ?>" <?php if($selected_subject == $subject['subject_id'] ) echo "selected"; ?>><?php echo $subject['name']; ?></option>';
           <?php } ?>
    </select>
            </div>
    </div>
            </div>
        <!--</div>-->
        <?php if($selected_class!=''){ ?>
<div class="row">
	    <div class="col-md-12">
                <div class="white-box" data-step="8" data-intro="<?php echo get_phrase('Here you can see list of progress report subject wise');?>" data-position='bottom'>
               <table id="table" class="table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"><div><?php echo get_phrase('s_no.');?></div></th>
                            <th width="15%"><div><?php echo get_phrase('photo');?></div></th>
                            <th width="15%"><div><?php echo get_phrase('name');?></div></th>
                            <th width="30%"><div><?php echo get_phrase('rating');?></div></th>
                            <th  width="30%"><div><?php echo get_phrase('comments');?></div></th>
                            <th width="15%" data-step="9" data-intro="<?php echo get_phrase('From here you can see history of rating');?>" data-position='top'>
                                <div><?php echo get_phrase('history');?></div></th>                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                    <br>
              <div class="form-group">
                    <div class="text-right">
        <button id="submit_button" class="fcbtn btn btn-danger btn-outline btn-1d" type="submit">
              Add Progress Report
        </button>
            </div>
              </div>
            </div>
      </div>
</div>
<?php } ?>
</form>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script>
    
    function get_progress_report_list() {
        var section=$("#section_holder option:selected").val();
        var subject=$("#subject_holder option:selected").val();
        var class_id=$("#class_holder option:selected").val();
        window.location = '<?php echo base_url();?>index.php?teacher/progress_report_list/'+class_id+'/'+section+'/'+subject;  
    }
    
    
function setColor(obj) {
    var rating = parseFloat(obj.text());
    var color;
    var parts = (rating > 5) ? (1-((rating-5)/5)) : rating/5;
    parts = Math.round(parts * 255);
    if (rating < 5) {
        color = [255, parts, 0];
    }
    else if (rating > 5){
        color = [parts, 255, 0];
    }
    else {
        color = [255,255,0]
    }
    obj.css('color','rgb(' + color.join(',') + ')');
    obj.css('background','rgb(' + color.join(',') + ')');
}

$(function() {
    $('span.rating').each(function() {
        setColor($(this));
    });
});


function rating(rate,student){ 
$('img[name^='+student+']').each(function(){   
if(this.name.slice(-1)>rate)
{
	this.src="<?php echo base_url();?>assets/images/Blank_star.png";
}
else
{
	this.src="<?php echo base_url();?>assets/images/filled_star"+this.name.slice(-1)+".png";
}
});

$("#rate-"+student).val(rate);
//alert(student);
$("#changed"+student).val("1");
//alert($("#changed"+student).val());

}


function onclasschange(class_id)
{
    //alert(class_id.value);
    jQuery('#section_holder').html('<option value="">Select Section</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
           $('#section_holder').trigger("chosen:updated");
}
function onsectionchange(section_id)
{
    //alert(section_id);
    jQuery('#subject_holder').html('<option value="">Select Subject</option>');
    $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response)
            {
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
           $('#subject_holder').trigger("chosen:updated");
}

        var section=$("#selected_section").val();
        var subject=$("#selected_subject").val();
        var class_id=$("#selected_class").val();
        
    var table;
    $(document).ready(function() {
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
                "url": "<?php echo base_url(); ?>index.php?ajax_controller/progress_report_list/",
                "type": "POST",
                data : { class_id:class_id,section:section, subject:subject },
                "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 0);
                    return data.data;
            }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0,1,3,4,5], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
        
    });
    
</script>