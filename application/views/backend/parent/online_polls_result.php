<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?parents/online_polls"><?php echo get_phrase('online_polls'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

<?php $count = 0;  if(!empty($online_polls)){$count = 0;/*
    foreach ($online_polls as $row) {  //pre($row);
        if(isset($row['poll_id'])){ $count++;?>

<div class="panel panel-danger block6">
<div class="panel-heading">Polling Topic : <?php echo $row['poll_title'];?> : <?php echo $row['post_date'];?></div>
<div class="panel-wrapper collapse in" aria-expanded="true">
    <div class="panel-body col-md-offset-0">
        <p><strong><?php echo $row['poll_descreption']; ?></strong></p>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<?php if(!empty($row['answer_det'])) { 
                $answ_count         =   1;
                $cHighestPer=0;
                foreach($row['answer_det'] as $answer) { 
                    if($row['total_poll']==0){
                        $answer_poll_percent=0;
                    }else{
                        $answer_poll_percent        =   ($answer['no_of_votes']/$row['total_poll'])*100;
                    }
                    if($cHighestPer<$answer_poll_percent){
                        $cHighestPer=$answer_poll_percent;
                        $winer=$answer['answer'];
                    }
                    ?>            

            <?php } ?>
<div class="input-group"><div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div><h3>&nbsp;Winner is : <?php echo $winer.' : '.round($cHighestPer, 2);?></h3></div>

           <?php  } ?>
        </div>
    </div>
</div>
</div>
<?php  } 
        }*/ }?>
<?php $count = 0;  if(!empty($online_polls)){$count = 0;?>
<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Lists vote result.');?>" data-position='top'>
    <!--<table id="table" class="table_edjust table-responsive display nowrap" cellspacing="0" width="100%" >-->
    <table class="custom_table table display example" id="polls">
        <thead>
            <tr>
                <th width="5%"><div><?php echo get_phrase('s._no.'); ?></div></th>   
                <th width="20%"><div><?php echo get_phrase('title'); ?></div></th>   
                <th width="45%"><div><?php echo get_phrase('description'); ?></div></th>                            
                <th width="17%"><div><?php echo get_phrase('winner'); ?></div></th>
                <th width="12%"><div><?php echo get_phrase('percentage(%)'); ?></div></th>
            </tr>
            <tbody>
                <?php foreach ($online_polls as $row) { $no=0;
                    if(isset($row['poll_id'])){ $count++;?>
                <tr>
                    <td><?php echo ++$no;?></td>
                    <td><?php echo $row['poll_title'];?>  <?php //echo ': '.$row['post_date'];?></td>
                    <td><?php echo $row['poll_descreption']; ?></td>
                    <?php if(!empty($row['answer_det'])) {
                        $answ_count         =   1;
                        $cHighestPer=0;
                    foreach($row['answer_det'] as $answer) { 
                        if($row['total_poll']==0){
                            $answer_poll_percent=0;
                        }else{
                            $answer_poll_percent        =   ($answer['no_of_votes']/$row['total_poll'])*100;
                        }
                        if($cHighestPer<$answer_poll_percent){
                            $cHighestPer=$answer_poll_percent;
                            $winer=$answer['answer'];
                        }
                    } ?>
                    <td><?php echo $winer;?></td>
                    <td><?php echo round($cHighestPer, 2);?></td>
                    <?php }else{?>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php }?>
                </tr>
                <?php }
                }?>
            </tbody>
        </thead>
    </table>
    
</div>
<?php }else{?>
<div class="panel panel-danger block6">
    <div class="panel-heading">Poll result is not available</div>
</div>            
<?php } ?>