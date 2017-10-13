<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-10 form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text"  data-step="5" data-position="top" data-intro="<?php echo get_phrase('Select a date to view the subject updates.');?>" id="topic_date" class="form-control datepicker" style="width:20%;" value="<?php echo date('d-m-Y');?>" onchange="return show_records(<?php echo $this->session->userdata('login_user_id');?>);">
        </div>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="white-box"  data-step="6" data-position="top" data-intro="<?php echo get_phrase('Here you can view the details of topics that are teached on a specific date.');?>">	
            <table  class="custom_table display nowrap" id="example23">
            <thead>
                <tr>      
                    <th width="80"><div><?php echo get_phrase('No:'); ?></div></th>           
                    <th><div><?php echo get_phrase('title'); ?></div></th>
                    <th><div><?php echo get_phrase('description'); ?></div></th>
                    <th><div><?php echo get_phrase('teacher'); ?></div></th>
                    <th><div><?php echo get_phrase('subject'); ?></div></th>
                    <th><div><?php echo get_phrase('date'); ?></div></th>
                </tr>
            </thead>
            <tbody id="topic_updates_display">        
                <?php $count = 0; foreach ($topic_details as $row): 
                $count++;  ?>
                <tr>            
                    <td><?php echo $count; ?></td>                
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td> 
                    <td><?php echo $row['teacher_name']; ?></td> 
                    <td><?php echo $row['name']; ?></td> 
                    <td><?php echo $row['created_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    $(document).ready(function () {
        $('#topic_date').datepicker({
            format: "dd-mm-yyyy",
             changeMonth: true,
            changeYear: true,
            startDate: new Date(),
            autoclose: true
        });
    });

function show_records(student_id){
    var date  =  $('#topic_date').val();
    $.ajax({
        type   : 'POST',
        url : '<?php echo base_url(); ?>index.php?ajax_controller/get_topics_by_date/',
        data : {date:date, student_id:student_id },
        success: function (response){
            if(response)
                jQuery('#topic_updates_display').html(response); 
        },
        error:function(xhr,status,error){
            alert('error');
        } 
    });
}
</script>





