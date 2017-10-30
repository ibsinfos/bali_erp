<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_subject'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb_old(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row m-0">
<div class="form-group col-sm-5 p-0" data-step="5" data-intro="<?php echo get_phrase('Please select class from here and than list of subject will open here');?>" data-position='bottom'>
    <label class="control-label">Select Class</label>
    <select class="selectpicker" data-style="form-control" data-live-search="true"  onchange="window.location = this.options[this.selectedIndex].value">
        <option value="">Select Class</option>
        <?php foreach ($classes as $row): ?>
            <option <?php
            if ($class_id == $row['class_id']) {
                echo 'selected';
            }
            ?> value="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/subject/<?php echo $row['class_id']; ?>">
            <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
            </option>
<?php endforeach; ?>
    </select>
</div>

<div class="text-right col-xs-12 col-sm-7 m-b-20 p-0">	
    <button type="button" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="My Subjects" data-step="5" data-intro="<?php echo get_phrase('You can view your classes list from here.');?>" data-position='left' onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_my_class_details');" >
        <i class="fa fa-book"></i>
    </button> 
</div>
</div>
<?php if (!empty($subjects)) { ?>
    <div class="col-md-12 white-box"> 

        <table class= "custom_table table display" id="example23" data-step="6" data-intro="<?php echo get_phrase('Subject list will show here');?>" data-position='top'>
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('class'); ?></div></th>
                    <th><div><?php echo get_phrase('section'); ?></div></th>
                    <th><div><?php echo get_phrase('subject_name'); ?></div></th>
                    <th><div><?php echo get_phrase('teacher'); ?></div></th>                    		
                </tr>
            </thead>
            <tbody>
    <?php $count = 1;
    foreach ($subjects as $row):
        ?>
            <tr>
                <td><?php
                    echo isset($row['class_name']) ? $row['class_name'] : '';
                    ?></td>
                <td><?php
                    if (!empty($row['section_name'])) {
                        echo $row['section_name'];
                    } else {
                        echo '';
                    }
                    ?>
                </td>
                <td><?php echo isset($row['name']) ? $row['name'] : ''; ?></td>
                <td><?php
            echo isset($row['teacher']) ? $row['teacher'] : '';
                    ?></td>

            </tr>
    <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php } ?>
