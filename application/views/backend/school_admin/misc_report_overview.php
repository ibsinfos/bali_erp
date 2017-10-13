<div class="row bg-title">
    
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Overview Reports'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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


<div class="panel panel-success" data-collapsed="0" style="border-color:#ddd;">
    <div class="row">
        <div class="col-md-12" data-step="5" data-intro="<?php echo get_phrase('Here you can see the overview of students, parents, teachers and bus drivers of the current session.');?>" data-position="top">        
            <div class="panel panel-success" data-collapsed="0" style="margin-bottom:0px; border-color:#ddd;">
                
                <div class="col-md-12" style="margin-top:30px;">
                    <?php echo $overview_barchart;?>													
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="panel panel-success" data-collapsed="0" style="border-color:#ddd;">
        <div class="row">
             <div class="col-md-12" data-step="6" data-intro="<?php echo get_phrase('Here you can see the overview of students in each class.');?>" data-position="top">        
            <div class="panel panel-success" data-collapsed="0" style="margin-bottom:0px; border-color:#ddd;">       
                <div class="col-md-12" style="margin-top:30px;">
                    <div class="col-md-6">
                        <?php echo $overview_paichart;?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $overview_column_line_mix_linner_chart;?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>