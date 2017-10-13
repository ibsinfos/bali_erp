<link href="<?php echo base_url(); ?>assets/event_assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">	
<div class="no-outline"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="" role="document">
        <div class="">

            <div class="">
                <!-- New Event Creation Form -->
                <form action="<?php echo base_url() . 'index.php?school_admin/event/create' ?>" method="post" enctype="multipart/form-data" class="form-horizontal" name="novoevento">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="title">Title<span class="error" style="color: red;"> *</span></label>
                            <div class="col-md-6">
                                <select name='title' class="selectpicker1 input-md" data-style="form-control" data-live-search="true" id="title" onblur="valid_title();">

                                    <?php
                                    $types = $this->db->get('type')->result_array();

                                    //$query = mysql_query("select * from type ORDER BY id DESC");

                                    echo "<option value='No type Selected' required>Select Type</option>";

                                    foreach ($types as $row) {
                                        echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <span id="title_error" style="color: red"></span>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="color">Color<span class="error" style="color: red;"> *</span></label>
                            <div class="col-md-4">
                                <div id="cp1" class="input-group colorpicker-component">
                                    <input id="cp1" type="text" class="form-control" name="color" value="#5367ce" required/>
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="start">Start Date<span class="error" style="color: red;"> *</span></label>
                            <div class="col-md-4">
                                <input class="form-control col-md-6 date-close-start" id="start" placeholder="Start date" name="start" value="" type="text" onblur="valid_start_date();">
                                <span id="start_date_error" style="color: red"></span>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="end">End Date<span class="error" style="color: red;"> *</span></label>

                            <div class="col-md-4">

                                <input id="end" class="form-control col-md-6  date-close-end" placeholder="End date" name="end" value="" type="text" onblur="valid_end_date();">
                                <span id="end_date_error" style="color: red"></span>
                            </div>
                        </div>

                        <!-- Image input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="url">Upload Image</label>
                            <div class="col-md-9">
                                <input type="file" name="image" id="image">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="url">Link</label>
                            <div class="col-md-9">
                                <input id="url" name="url" type="text" class="form-control input-md" >

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="description">Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="5" name="description" id="description"></textarea>
                            </div>
                        </div>


                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="singlebutton"></label>
                            <div class="col-md-4 pull-right">
                                <input type="submit" name="novoevento" class="btn btn-success pull-right" value="Submit" onclick="return valid_frm();" />
                            </div>
                        </div>

                    </fieldset>
                </form>  

            </div>

        </div>
    </div>
</div>
<script>
    $(function () {
        $('#cp1').colorpicker();
    });

    $(document).ready(function () {

        $('.date-close-start').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language: 'en'
        }).on('change', function () {
            $('.datetimepicker').hide();
        });

        $('.date-close-end').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language: 'en'
        }).on('change', function () {
            $('.datetimepicker').hide();
        });

    });


    function valid_frm() {
        var title = document.getElementById('title').value;
        var start_date = document.getElementById('start').value;

        var end_date = document.getElementById('end').value;

        if (title == 'No type Selected') {
            document.getElementById('title_error').innerHTML = "Please Enter Title";
            return false;
        }

        if (start_date == "") {
            document.getElementById('start_date_error').innerHTML = "Please Enter Start Date";
            return false;
        }
        if (end_date == "") {
            document.getElementById('end_date_error').innerHTML = "Please Enter End Date";
            return false;
        }

        return true;
    }

    function valid_title() {
        var title = document.getElementById('title').value;
        if (title != 'No type Selected') {
            document.getElementById('title_error').innerHTML = "";
        }
    }
    function valid_start_date() {
        var start_date = document.getElementById('start').value;
        if (start_date != "") {
            document.getElementById('start_date_error').innerHTML = "";
        }
    }

    function valid_end_date() {
        var end_date = document.getElementById('end').value;
        if (end_date != "") {
            document.getElementById('end_date_error').innerHTML = "";
        }
    }

</script>