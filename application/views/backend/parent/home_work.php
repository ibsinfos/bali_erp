    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
            <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>index.php?teacher/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
                <li class="active"><?php echo get_phrase($page_title); ?></li>
            </ol>
        </div>
    </div>
           
  
     <?php
     $msg=$this->session->flashdata('flash_message_error');
     if ($msg) { ?>        
        <div class="alert alert-danger">
            <?php echo $msg; ?>
        </div>
    <?php } ?>
    <div class="col-md-12 white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>
                            <li id="section1">
                                <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="You can see list of home work you created." data-position='right'><span><?php echo get_phrase('home_works'); ?></span></a></li>

                        </ul>
                    </nav>                                    
                    <div class="content-wrap">
                        <section id="section-flip-1">

                        <table id="example23" class="table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div><?php echo get_phrase('no'); ?></div></th>
                                    <th><div><?php echo get_phrase('name'); ?></div></th>
                                    <th><div><?php echo get_phrase('subject'); ?></div></th>
                                    <th><div><?php echo get_phrase('description'); ?></div></th>
                                    <th><div><?php echo get_phrase('start_date'); ?></div></th>
                                    <th><div><?php echo get_phrase('end_date'); ?></div></th>
                                    <th><div><?php echo get_phrase('submitted_date'); ?></div></th>
                                    <th><div><?php echo get_phrase('marks'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(!empty($student_home_works)) {
                                   // pre($student_home_works);
                                    $count  =   1;
                                    foreach($student_home_works as $key=>$row) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['hw_name'];?></td>
                                        <td><?php echo $row['subject'];?></td>
                                        <td><?php echo $row['hw_description'];?></td>
                                        <td><?php echo $row['start_date'];?></td>
                                        <td><?php echo $row['end_date'];?></td>
                                        <td><?php echo $row['updated_date'];?></td>
                                        <td><?php echo $row['marks'];?></td>
                                       
                                    </tr>
                                <?php    
                                    }
                                } else { ?>


                               <?php  }
                               ?>
                            </tbody>
                        </table>

                        </section>


        </div>
    </div>
            </section>
    </div>
    
<script>
    $(document).ready(function(){

    });
    
    function onclasschange(class_id){
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response);
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }
    
    function onsectionchange(section_id){
        jQuery('#subject_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response){
                jQuery('#subject_holder').append(response);
            }
        });
        $('#subject_holder').trigger("chosen:updated");
    }
    
    jQuery("#subject_holder").change(function () {
        var section=$("#section_holder option:selected").val();
        var subject=$("#subject_holder option:selected").val();
        var classname=$("#class_holder option:selected").val();
        location.href = "<?php echo base_url(); ?>index.php?teacher/home_works/"+classname+"/"+section+"/"+subject;
    });
</script>
<script type="text/javascript">
</script>