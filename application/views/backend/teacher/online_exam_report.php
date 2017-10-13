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
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-5 no-padding" >
        <div class="form-group " data-step="5" data-intro="Select a class, then you will get a list of all students with their all online exam report." data-position='right'>
            <label class="control-label">Select Class</label>
            <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Class</option>
                <?php foreach ($classes as $row): ?>
                    <option <?php
                    if ($class_id == $row['class_id']) {
                        echo 'selected';
                    }
                    ?> value="<?php echo base_url(); ?>index.php?teacher/online_exam_report/<?php echo $row['class_id']; ?>">
                        <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>  
    </div>  
</div>
<div class="col-md-12 white-box">
    <?php if (!empty($details)) { ?>

        <table class="table datatable" id="example23">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('obtained_percentage'); ?></div></th>
                    <th><div><?php echo get_phrase('passing_percentage'); ?></div></th> 
                    <th><div><?php echo get_phrase('result'); ?></div></th> 
                    <th><div><?php echo get_phrase('time_taken'); ?></div></th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($details as $row):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['exam_name']; ?></td>
                        <td><?php
                            if ($row['result'] < 0) {
                                echo "percentage is in negative";
                            } else {
                                echo $row['result'];
                            }
                            ?></td>
                        <td><?php echo $row['passing_percent']; ?></td>
                        <td><?php
                            if ($row['result'] == "Exam_not_attempted") {
                                echo "no result";
                            } else if ($row['result'] >= $row['passing_percent']) {
                                echo "Pass";
                            } else {
                                echo "Fail";
                            }
                            ?></td>
                        <td><?php echo $row['time_taken']; ?></td>
                    </tr>
        <?php endforeach; ?>
            </tbody>
        </table>

<?php } else { ?>                  
        <table class="table table-bordered responsive" id="norecord">
            <thead>
                <tr>
                    <th><div></div></th> 
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td><div><label><?php echo get_phrase('no_records_found!!'); ?></label></div></td>
                </tr>
            </tbody>
        </table>
<?php } ?>
</div>