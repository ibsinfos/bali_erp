<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12 white-box">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-menu"></i></span> 
                    <span class="hidden-xs"><i class="entypo-menu"></i><?php echo get_phrase('exam_list'); ?></span>
                </a>
            </li>
           
        </ul>
        <!------CONTROL TABS END------>
        <div class="tab-content">
            <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <table  class="table display" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                            <th><div><?php echo get_phrase('date'); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                            <!--<th><div><?php echo get_phrase('Notification'); ?></div></th>-->
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                         
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($online_exam as $row): ?>
                            <tr>
                                <td><?php echo $row['exam_name']; ?></td>
                                <td><?php echo $row['start_date']." to ".$row['end_date']; ?></td>
                                <td><?php echo "Class ".$row['class_name']; ?></td>
    <!--                                                        <td><input type="button" value="Send Notification" class="btn btn-success"
                                           onclick="send_notification('<?php //echo isset($row['name'])?$row['name']:'' ?>','<?php //echo isset($row['date'])?$row['date']:'' ?>','<?php //echo isset($row['comment'])?$row['comment']:'' ?>')">
                                </td>-->   
                                <td>
                                    <?php if($row['status']!= "active"){ ?>
                                    <div class="btn-group">
                                         <a href="<?php echo base_url(); ?>index.php?teacher/view_question/<?php echo $row['class_id']; ?>/<?php echo $row['id']; ?>">
                                        <button type="button" class="btn btn-default btn-sm">
                                            Add Question 
                                        </button>
                                         </a>
                                    </div>
                                    <?php } else{?>
                                    <div class="btn-group">
                                        <?php echo get_phrase("cannot_add_questions_now");?>
                                    </div>
                                    <?php } ?>
                                </td>
                              
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->
        </div>
    </div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->  

<script type="text/javascript">

      function valid_only_numeric(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


    /************ajax fun for notification******************************/
    function send_notification(exam_name, date, comment) {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>index.php?school_admin/send_exam_notification/',
            data: {exam_name: exam_name, exam_date: date, comment: comment, event: 'exam_date'},
            success: function (response) {
                if (response == "OK") {
                    toastr.success('Sent Successfully');
                } else {
                    return false;
                }
            }
        });
    }

</script>
<script type="text/javascript">
    function evaluation_change(type)

    {
        if ((type.options[type.selectedIndex].innerHTML).trim() == "CCE")
        {
            $('#exam_category').prop('hidden', false);
        } else
        {
            $('#exam_category').prop('hidden', true);
        }

    }
    
</script>

<script>
    
  $(function() {
    $('#froala-editor').froalaEditor({
      heightMin: 100,
      heightMax: 200
    });
  });
  
  
  
//$("#start_date, #end_date").datepicker();
$("#end_date").change(function () {
    var startDate = document.getElementById("start_date").value;
    var endDate = document.getElementById("end_date").value;
 
    if ((Date.parse(endDate) <= Date.parse(startDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("end_date").value = "";
    }
});
</script>



