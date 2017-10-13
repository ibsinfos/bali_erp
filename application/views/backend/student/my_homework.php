<?php
?>
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
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>


<div class="row">
       <div class="col-md-12" data-step="5" data-intro="<?php echo get_phrase('Here you can see the list of previous homework.');?>" data-position='top'>
        <div class="panel panel-primary panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">Previous Homework</div>
            </div>
            <div class="panel-body">
               <div class="col-md-12">
                   <table class="table table-bordered">
                       <thead>
                        <tr>
                            <td style="text-align: center;"><?php echo get_phrase('homework');?></td>
                            <td style="text-align: center;"><?php echo get_phrase('section_name');?></td>
<!--                            <td style="text-align: center;"><?php echo get_phrase('subject_name');?></td>-->
     
                            <td style="text-align: center;" colspan="2"><?php echo get_phrase('start_date');?></td>
                            <td style="text-align: center;" colspan="2"><?php echo get_phrase('end_date');?></td>
                            <td style="text-align: center;" colspan="2"><?php echo get_phrase('action');?></td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total_marks = 0;
                            $total_grade_point = 0;
                            /*$subjects = $this->db->get_where('subject' , array(
                                'class_id' => $class_id , 'year' => $running_year
                            ))->result_array();*/
                            foreach ($online_exam as $row3):
                              if($row3['end_date'] < date('Y-m-d')){
                           
                                if($row3['start_date'])
                        ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $row3['hw_name'];?></td>
                                <td style="text-align: center;">
                                    <?php
                                       echo "Section ".$row3['section_name'];
                                       ?></td>
<!--                                <td style="text-align: center;">
                                     <?php  echo $row3['subject_name']; ?>                           
                                </td>-->
                                
                                <td style="text-align: center;"><?php echo $row3['start_date']?></td>
                                <td style="text-align: center;"><?php echo $row3['end_date']?></td>
                                    
                                <td style="text-align: center;">
                                <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_homework/<?php echo $row3['home_work_id']; ?>');">
                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view_details');?>">
                                    <i class="fa fa-eye"></i></button></a>
                                </td>
<!--                                <td style="text-align: center;">
                                    <a href="<?php echo base_url(); ?>index.php?student/attempt_exam/<?php echo $row3['id']; ?>">
                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('attempt_now'); ?>">
                                    <i class="fa fa-sign-in"></i></button></a>
                                </td>-->
                            </tr>
                              <?php } endforeach;?>
                    </tbody>
                   </table>
                   
               </div>              
        
            </div>
        </div>  
    </div>
    <div class="col-md-12" data-step="6" data-intro="<?php echo get_phrase('Here you can see homework list of today.');?>" data-position='top'>
        <div class="panel panel-primary panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">Today homework</div>
            </div>
            <div class="panel-body">
               <div class="col-md-12">
                   <table class="table table-bordered">
                       <thead>
                        <tr>
                            <td style="text-align: center;"><?php echo get_phrase('home_work');?></td>
                            <td style="text-align: center;"><?php echo get_phrase('section_name');?></td>
<!--                            <td style="text-align: center;"><?php echo get_phrase('subject_name');?></td>-->
                            <td style="text-align: center;"><?php echo get_phrase('start_date');?></td> 
                            <td style="text-align: center;"><?php echo get_phrase('end_date');?></td>
                            <td style="text-align: center;" colspan="3"><?php echo get_phrase('action');?></td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            
                            /*$subjects = $this->db->get_where('subject' , array(
                                'class_id' => $class_id , 'year' => $running_year
                            ))->result_array();*/
                            foreach ($online_exam as $row3):
//                                $now > $end && $now < $start;
                              if($row3['start_date'] <= date("Y-m-d") && $row3['end_date'] >= date("Y-m-d") ){
                           
                                if($row3['start_date'])
                        ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $row3['hw_name'];?></td>
                                <td style="text-align: center;">
                                    <?php
                                       echo "Section ".$row3['section_name'];
                                       ?></td>
<!--                                <td style="text-align: center;">
                                     <?php  echo $row3['subject_name']; ?> !-->
                                <td style="text-align: center;"><?php echo $row3['start_date']?></td>
                                <td style="text-align: center;"><?php echo $row3['end_date']?></td>
                                </td>
                                <td style="text-align: center;">
                                    <?php //echo $row3['passing_percent']?></td>
                                    
                                <td style="text-align: center;">
                                <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_homework/<?php echo $row3['home_work_id']; ?>');">
                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view_details');?>">
                                    <i class="fa fa-eye"></i></button></a>
                                </td>
                                <?php if($row3['status']    ==  "can attempt"){?>
                                <td style="text-align: center;">
                                    <a href="<?php echo base_url(); ?>index.php?student/homework_submit/<?php echo $row3['home_work_id']; ?>">
                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('attempt_now'); ?>">
                                    <i class="fa fa-sign-in"></i></button></a>
                                </td>
                                <?php } else{ ?>
                                <td style="text-align: center;">
                                    <?php echo get_phrase("done"); ?>
                                </td>
                                <?php } ?>
                            </tr>
                              <?php } endforeach;?>
                    </tbody>
                   </table>
                   
               </div>              
        
            </div>
        </div>  
    </div>
  
</div>

<script language='javascript'>
(function (global) { 

    if(typeof (global) === "undefined") {
        throw new Error("window is undefined");
    }

    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";

        // making sure we have the fruit available for juice (^__^)
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };

    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };

    global.onload = function () {            
        noBackPlease();

        // disables backspace on page except on input fields and textarea..
        document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };          
    }

})(window);

</script>    
