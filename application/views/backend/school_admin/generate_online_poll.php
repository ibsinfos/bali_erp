<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

<div class="row m-0">
    <div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can enter the poll details such as title, description, class, date and answers.');?>" data-position="top">

        <?php
        echo form_open(base_url() . 'index.php?school_admin/generate_online_poll', array('class' => 'top-for-tabs'));
        if ($this->session->flashdata('flash_message_error')) {
            ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('flash_message_error'); ?>
            </div>
        <?php } ?>

            <div class="form-group col-md-12">
                <label for="blog_title">
                    <?php echo get_phrase('poll_title'); ?>:<span class="error mandatory"> *</span></label>

                <input type="text" class="form-control" id="poll_title" name="poll_title" placeholder="Poll Title" required>

            </div>



            <div class="form-group col-md-12">
                <label for="poll_content">
                    <?php echo get_phrase('poll_description'); ?>:<span class="error mandatory"> *</span></label>
                    <textarea class='summernote'  name="poll_discription" id="poll_discription" required ></textarea>
            </div>
            <div class="form-group col-md-12" data-step="6"  data-position="top" data-intro="<?php echo get_phrase('You can select one class or multiple classes. To select multiple classes press Ctrl and select the classes.');?>">
                <label for="classes" >
                    <?php echo get_phrase('select class'); ?><span class="error mandatory"> *</span>:</label>
                <select multiple class="selectpicker" data-style="form-control" data-live-search="true" name="classes[]" id="classes" size="10" >
                    <option value="0">All Classes</option>
                    <?php
                        foreach($classes as $class) {
                            echo '<option value="'.$class['class_id'].'">'.$class['name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="poll_date">
                    <?php echo get_phrase('poll_date'); ?><span class="error mandatory"> *:</span></label>
                    <input type='text' class="form-control" name="poll_date" id="poll_date" required value="<?php echo date('d/m/Y');?>" placeholder="<?php echo date('d/m/Y');?>" />
            </div>
        <div id="answer_content">
                <div class="col-md-8 m-b-10">
                    <label for="poll_content">
                        <?php echo get_phrase('poll_answer_1'); ?>:<span class="error mandatory"> *</span>
                    </label>
                    <input type="text" class="form-control poll_count" id="poll_answer1" name="poll_answer[]" placeholder="Poll Answer" required>
                </div>
                <div class="col-md-8 m-b-10">
                    <label for="poll_content">
                        <?php echo get_phrase('poll_answer_2'); ?>:<span class="error mandatory"> *</span>
                    </label>
                    <input type="text" class="form-control poll_count" id="poll_answer2" name="poll_answer[]" placeholder="Poll Answer" required>
                </div>
            </div>
            <br>
            <div class="col-md-12 text-left">
                <div class="col-md-4 text-left addAnswerJS no-padding"  data-position="top" data-step="7" data-intro="<?php echo get_phrase('Click on this button to add a new poll answer.');?>"><button id="add_answer" title="Add Answer" class="fcbtn btn btn-danger btn-outline btn-1d">+</button></div>
            </div>
            <br>
            <div class="col-xs-12 text-right btn-center-in-sm">
                <input type="hidden" id="answer_count" value="0">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"  name="submit_poll" value="save_poll" data-step="8" data-position="left" data-intro="<?php echo get_phrase('Click on the submit button to create an online poll.');?>">
                    <?php echo get_phrase('add_poll'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>

<script>
    $(document).ready(function () {

        $('#poll_date').datepicker({
            format: "dd/mm/yyyy"
        }).on('change', function () {
            $('.datepicker').hide();
        });
        $('.addAnswerJS').removeClass('text-center');
    });
    $("#add_answer").click(function() {
        var answer_count        =   parseInt($("#answer_count").val());
        var next                =   $('.poll_count').length+1;
        answer_count            =   answer_count+1;
        $("#answer_count").val(answer_count);
        add_new_answer(answer_count,next);
    });
    
    $('body').on('click', '.remove_answer', function(){
        /*var remove_elem     =   $(this).attr('id');
        remove_answer(remove_elem);*/
        $(this).parent().remove();
    });
    
    function add_new_answer(count,next) {
        /*var add_answer_html     =   '<div class="col-md-12" id="answer_content'+count+'"><div><label for="poll_content"><span class="error">Poll Answer '+next+' </span></label>'+
                '</div><div class="col-md-8"><input type="text" class="form-control poll_count" id="poll_answer'+next+'" name="poll_answer[]" placeholder="Poll Answer" required>'+
                '<div class="col-md-2"><button type="button" id="'+count+'" class="remove_answer btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Remove"><i class="fa fa-trash-o"></i></button></div></div></div>';*/
    var add_answer_html     =   '<div class="col-md-8 m-b-10"><label for="poll_content">Poll Answer '+next+':</label><input type="text" class="form-control poll_count m-b-10" id="poll_answer'+next+'" name="poll_answer[]" placeholder="Poll Answer" required><button type="button" id="'+count+'" class="remove_answer btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Remove"><i class="fa fa-trash-o"></i></button></div>';
        $('#answer_content').append(add_answer_html);
    }
    
    function remove_answer(element) {
        var remove_elem         =   'answer_content'+element;
        $('#'+remove_elem).remove();
    }
    
    $('#blog_category').change(get_blog_subcategory);
    function get_blog_subcategory() {
        var category_id = $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_blog_subcategories/' + category_id,
            success: function (response) {
                jQuery('#section__holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>
