<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Dormitory'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('Dormitory'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>



<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-body" style="color:black;">

                <h2><?php echo get_phrase('students_details'); ?></h2>
                <?php foreach ($students_name as $row) { ?>

                    <button class="accordion"><span class="text"><strong><?php echo get_phrase('name:'); ?></span>
                        <?php echo $row['name']; ?></strong><br></button>
                    <div class="panel" id="section">

                        <div class="row">
                            <br>
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('class:'); ?></span></b>
                                <?php echo "   " . $row['classname']; ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('section:'); ?></span></b>
                                <?php echo "   " . $row['section_name']; ?><br>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('hostel_name:'); ?></span></b><?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['name'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('type:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['hostel_type'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('floor_name:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['floor_name'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('room_no:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['room_no'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('food:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['food'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('register_date:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['register_date'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('vacating_date:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['vacating_date'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('transfer_date:'); ?></span></b>
                                <?php
                                foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                    echo $hostel_value['transfer_date'] . ",";
                                }
                                ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="text"><b><?php echo get_phrase('status:'); ?></span></b>
                                    <?php
                                    foreach ($row['hostel_details'] as $hostel_key => $hostel_value) {
                                        echo $hostel_value['status'] . ",";
                                    }
                                    ?><br>
                            </div>
                        </div>    
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>






<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        }
    }
</script>

