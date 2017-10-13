<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Gender Report'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
    <!-- /.breadcrumb -->
</div>



<div class="row">
    <div class="col-sm-12">    
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can view the male and female student in different grade levels.');?>" data-position="top"> 
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('sl_no.'); ?></div></th>
                        <th><div><?php echo get_phrase('grade_level'); ?></div></th>                            
                        <th><div><?php echo get_phrase('male'); ?></div></th>                            
                        <th><div><?php echo get_phrase("female"); ?></div></th>                            
                        <th><div><?php echo get_phrase('total'); ?></div></th>
                        <th><div><?php echo get_phrase('grand_total'); ?></div></th>
                    </tr>
                </thead>
                <tbody><?php
                    //pre($all_students);die;
                    $n = 1;
                    $AllMale = 0;
                    $AllFemale = 0;
                    if (count($all_students)) {
                        foreach ($all_students as $row):
                            $AllMale += $row['male_count'];
                            $AllFemale += $row['female_count'];
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $row['class_name'] . '-' . $row['section_name']; ?></td>
                                <td><?php echo $row['male_count']; ?></td>
                                <td><?php echo $row['female_count']; ?></td>
                                <td><?php echo ($row['male_count'] + $row['female_count']); ?></td>
                                <td><?php echo ($row['male_count'] + $row['female_count']); ?></td>                                                           
                            </tr><?php
                        endforeach;
                    }
                    ?>                        
                </tbody>
                <tfoot>
                <th colspan="2" style="text-align: right;" ><div><?php echo get_phrase('grand_total'); ?></div></th>                            
                <th><div><?php echo $AllMale; ?></div></th>                            
                <th><div><?php echo $AllFemale; ?></div></th>                            
                <th><div><?php echo ($AllMale + $AllFemale); ?></div></th>
                <th><div><?php echo ($AllMale + $AllFemale); ?></div></th>
                </tfoot>
            </table>
        </div>
    </div>                     
</div>
