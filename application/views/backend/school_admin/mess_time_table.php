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
    <div class="col-md-12 no-padding">
        <div class="col-md-10">
            <div class="form-group col-md-5 no-padding" data-step="5" data-intro="<?php echo get_phrase('Select a class, for which you want to see class routine.');?>" data-position='right'>
                <label class="control-label">Select Class</label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                    <option value=""><?php echo get_phrase("select_mess_name"); ?></option>
                    <?php foreach ($mess_name as $row): ?>
                        <option <?php if ($mess_id == $row['mess_management_id']) {
                        echo 'selected';
                    }
                        ?> value="<?php echo $row['mess_management_id']; ?>">
                        <?php echo $row['name']; ?>
                        </option>
<?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-2 hidden-sm"> 
            <a href="<?php echo base_url(); ?>index.php?school_admin/add_mess_time_table"
               class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Mess Timetable" data-step="6" data-intro="Add Mess Routine from here" data-position='left'> 
                <i class="fa fa-plus"></i>
            </a> 
        </div>
    </div>
</div>


<div class="col-md-12 white-box" data-collapsed="0" data-step="7" data-intro="<?php echo get_phrase('From here you can see the mess timetable.');?>" data-position='top'>
    
   
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Breakfast</th>
                            <th>Lunch</th>
                            <th>Evening Snacks</th>
                            <th>Dinner</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
    foreach ($routines as $array_name => $array) {
        ?>
                            <tr class="gradeA">
                                <td width="100"><?php echo strtoupper($array_name); ?></td>
                                  <?php
                                    foreach ($array as $value) {
                                        ?>
                                <td>
                                  
                                        <div class="btn-group btn-bottom">
                                            <button class="btn btn-default dropdown-toggle btn_whitespace" data-toggle="dropdown">
            <?php echo $value['food']; ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_mess_time_table/<?php echo $value['mess_time_table_id']; ?>');">
                                                        <i class="entypo-pencil"></i>
            <?php echo get_phrase('edit'); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
       

                                </td>
                                 <?php } ?>
                            </tr>
   <?php } ?>

                    </tbody>
                  
                </table>




</div>
