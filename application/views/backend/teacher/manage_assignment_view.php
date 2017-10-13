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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li>Assignment
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/verify_assignment"><?php echo get_phrase('verify_assignments'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('manage_assignments'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="col-md-12 white-box no-padding">
    <?php echo form_open(base_url() . 'index.php?teacher/assignment_selector'); ?>   
    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Please Select Your Class '); ?>" data-position='bottom'>
        <label class="control-label"><?php echo get_phrase('Select Class'); ?></label><span class="mandatory">*</span>	
        <select id="class_holder" name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this);" required="required">
            <option value="">Select Class</option>
            <?php foreach ($classes as $row): ?>
                <option  value="<?php echo $row['class_id']; ?>">
                    <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['class_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>


    <?php if ($class_id != ''): ?>
        <div class="form-group col-sm-4" >
            <label class="control-label" ><?php echo get_phrase('select_section'); ?></label><span class="mandatory">*</span>
            <select id="section_holder" name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsectionchange(this.value);" required="required">
                <option value="">Select Section</option>
            </select>
        </div>

    <?php endif; ?> 
    <div class="form-group col-sm-4" >
        <label class="control-label"><?php echo get_phrase('subject'); ?></label><span class="mandatory">*</span>
        <select id="subject_holder" name="subject_id" data-style="form-control" data-live-search="true" class="selectpicker" required="required">
            <option value="">Select subject</option>
        </select>
    </div>  

    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('manage_assignment'); ?></button>
    </div>
</div>  

<?php echo form_close(); ?>  
<!--<div class="row">-->
<div class="col-md-12 white-box">
    <div class="text-center">
        <h3><?php echo get_phrase('manage_assignment_class_for'); ?> <?php echo $class_name_cc; ?></h3>

        <h4>
            <?php echo get_phrase('section'); ?> <?php echo $sec_name; ?><?php get_phrase('subject'); ?><?php echo ' : ' . $sub_name; ?>  
        </h4>
    </div>
    <div class="text-right m-b-10">
        <input type="button" class="fcbtn btn btn-danger btn-outline btn-1d" id="toggle" value="Select All" onClick="do_this();" />
    </div>
    <?php echo form_open(base_url() . 'index.php?teacher/allot_assignment/add/' . $subject_id); ?>
    <input type="hidden" name="selected_class" id="selected_class" value="<?php echo $class_id; ?>">
    <input type="hidden" name="selected_section" id="selected_section" value="<?php echo $section_id; ?>">
    <input type="hidden" name="selected_subject" id="selected_subject" value="<?php echo $subject_id; ?>">
    <table id="table" class="table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th><div><?php echo get_phrase('roll_#'); ?></div></th>
                <th><div><?php echo get_phrase('name'); ?></div></th>                            
                <th><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>       
    <br>
    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d text-right"><?php echo get_phrase('allot_assignment'); ?> </button>
    </div>
    <?php echo form_close(); ?>
</div>
<!--</div>-->


<script type="text/javascript">

    function do_this() {

        var checkboxes = document.getElementsByName('allot_assigment[]');
        var button = document.getElementById('toggle');

        if (button.value == 'Select All') {
            for (var i in checkboxes) {
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'Deselect'
        } else {
            for (var i in checkboxes) {
                checkboxes[i].checked = '';
            }
            button.value = 'Select All';
        }
    }
</script>
<script>
    function onclasschange(class_id) {
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }

    function onsectionchange(section_id) {
        jQuery('#subject_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response) {
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
        $('#subject_holder').trigger("chosen:updated");
    }

</script>

<script>
    var class_id = $("#selected_class").val();
    var section_id = $("#selected_section").val();
    var subject_id = $("#selected_subject").val();
    var table;
    $(document).ready(function () {
        table = $('#table').DataTable({
            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source

            "ajax": {
                "url": "<?php echo base_url(); ?>index.php?ajax_controller/manage_assignment_list/",
                "type": "POST",
                data: {class_id: class_id, section_id: section_id, subject_id: subject_id},
                "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 0);
                    return data.data;
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0, 3], "orderable": false},
            ],

        });
        table.$('tr').tooltip({selector: '[data-toggle="tooltip"]'});

    });
</script>
