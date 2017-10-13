<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('transport'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if (!empty($details)) { ?>
        <div class="row m-0">
        <div class="col-md-12 white-box">
            <?php foreach ($details as $row) { ?>
                <table class="table table-bordered margin-no-bottom">
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-6 m-b-20">
                            <img width="150px" src="<?php echo $row['student_image']; ?>" />
                        </div>
                        <div class="col-lg-10 col-md-8 col-sm-6 m-t-40">
                            <h2 class="stu-name-margin"><?php echo $row['student_name']; ?></h2>
                        </div>
                    </div>

                    <tr>
                        <th><b><?php echo get_phrase('bus_name:'); ?></b></th>
                        <td>
                            <?php echo $row['bus_name']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('route:'); ?></b></th>
                        <td>
                            <?php echo $row['route_name']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('route_from:'); ?></b></th>
                        <td>
                            <?php echo $row['route_from']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('route_to:'); ?></b></th>
                        <td>
                            <?php echo $row['route_to']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('no_of_stops:'); ?></b></th>
                        <td>
                            <?php echo $row['no_of_stops']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('route_fare:'); ?></b></th>
                        <td>
                            <?php echo $row['route_fare']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('start_date:'); ?></b></th>
                        <td>
                            <?php echo $row['start_date']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th><b><?php echo get_phrase('end_date:'); ?></b></th>
                        <td>
                            <?php echo $row['end_date']; ?>
                        </td>
                    </tr>

                </table>
            <?php } ?>
        <?php } else { ?>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="panel-title text-white">
                        <?php echo get_phrase("No information available as your child is not using transport facility!!!"); ?>
                    </div>
                </div> 
            </div>
        <?php } ?>
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