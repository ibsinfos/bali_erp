<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

            <?php
            $BRC = get_bread_crumb();
            if (strpos($BRC, '^') !== false) {
                $ExpBrd = explode('^', $BRC);
                ?>
                <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
                </li> <?php
        } else {
            $ExpBrd[2] = $BRC;
        }
            ?>
            <li class="active">
<?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-md-12 text-right form-group" >
        <a href="<?php echo base_url(); ?>index.php?school_admin/generate_online_poll" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo get_phrase('create_new_poll'); ?>">
            <i class="fa fa-plus" data-step="5" data-intro="<?php echo get_phrase('You can create a new  blog here.'); ?>" data-position='left'></i>
        </a>
    </div>
</div>
<?php $msg=$this->session->flashdata('flash_message_error');
    if ($msg) { ?>        
    <div class="alert alert-danger">
        <?php echo $msg; ?>
    </div>
<?php } ?>
<div class="white-box">
    <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="section1">
                        <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="<?php echo get_phrase('List the polls you have published.'); ?>" data-position='right'><span>
                                <?php echo get_phrase('online_polls'); ?></span></a>
                    </li>
                    <li id="section2">
                        <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('From here you can create poll.'); ?>" data-position='left'><span>
<?php echo get_phrase('create_poll'); ?></span></a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">
                <section id="section-flip-1">
                    <table class="custom_table table display example" id="polls">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <div>
                                        <?php echo get_phrase('no.'); ?>
                                    </div>    
                                </th>
                                <th width="20%">
                                    <div>
                                        <?php echo get_phrase('poll_title'); ?>
                                    </div>
                                </th>
                                <th width="15%">
                                    <div>
                                        <?php echo get_phrase('posted_on'); ?>
                                    </div>
                                </th>
                                <th width="25%">
                                    <div>
                                        <?php echo get_phrase('class'); ?>
                                    </div>
                                </th>
                                <th width="10%">
                                    <div>
                                        <?php echo get_phrase('total_vote'); ?>
                                    </div>
                                </th>
                                <th width="8%">
                                    <div>
                                        <?php echo get_phrase('status'); ?>
                                    </div>
                                </th>
                                <th width="17%">
                                    <div>
<?php echo get_phrase('action'); ?>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                                    <?php if (!empty($online_polls)) { ?>
                                        <?php $count = 1;
                                        foreach ($online_polls as $row):
                                            ?>
                                    <tr>
                                        <td>
        <?php echo $count++; ?>
                                        </td>
                                        <td>
        <?php echo $row['poll_title']; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <?php echo $row['post_date']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <?php echo ($row['class_name'] == '') ? 'All Class' : $row['class_name']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <?php echo $row['total_poll']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "Active";
                                                } else if ($row['status'] == 2) {
                                                    echo "Closed";
                                                } else {
                                                    echo "Inactive";
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/modal_online_poll_view/<?php echo $row['poll_id']; ?>');"><button class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></button></a>
                                            <?php if ($row['status'] != 2) { ?>
                                                <a href="javascript:void(0);" onclick="custom_confirm_modal('<?php echo base_url(); ?>index.php?school_admin/online_polls/close/<?php echo $row['poll_id']; ?>', 'Do you want to close this poll');">
                                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Close"><i class="fa fa-window-close-o"></i></button>
                                                </a>
        <?php } else { ?>
                                                <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                    <?php } ?>
                                            <a href="javascript:void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/online_polls/delete/<?php echo $row['poll_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                        <?php endforeach;
                    }
                    ?>
                        </tbody>
                    </table>
                </section>
                <section id="section-flip-2">
                    <?php
                    echo form_open(base_url() . 'index.php?school_admin/generate_online_poll', array('class' => 'top-for-tabs'));
                    //if ($this->session->flashdata('flash_message_error')) {
                        ?>
                        

                    <div class="form-group col-md-8">
                        <label for="blog_title">
<?php echo get_phrase('poll_title'); ?>:<span class="error mandatory"> *</span></label>

                        <input type="text" class="form-control" id="poll_title" name="poll_title" placeholder="Poll Title" required>

                    </div>



                    <div class="form-group col-md-8">
                        <label for="poll_content">
<?php echo get_phrase('poll_description'); ?>:<span class="error mandatory"> *</span></label>
                        <textarea class='summernote'  name="poll_discription" id="poll_discription" required ></textarea>
                    </div>
                    <div class="form-group col-md-8" data-step="6"  data-position="top" data-intro="<?php echo get_phrase('You can select one class or multiple classes. To select multiple classes press Ctrl and select the classes.'); ?>">
                        <label for="classes" >
                            <?php echo get_phrase('select class'); ?><span class="error mandatory"> *</span>:</label>
                        <select multiple class="selectpicker" data-style="form-control" data-live-search="true" name="classes[]" id="classes" size="10" >
                            <option value="0">All Classes</option>
<?php
foreach ($classes as $class) {
    echo '<option value="' . $class['class_id'] . '">' . $class['name'] . '</option>';
}
?>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="poll_date">
                                <?php echo get_phrase('poll_date'); ?><span class="error mandatory"> *:</span></label>
                        <input type='text' class="form-control" name="poll_date" id="poll_date" required value="<?php echo date('d/m/Y'); ?>" placeholder="<?php echo date('d/m/Y'); ?>" />
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
                        <div class="col-md-4 text-left addAnswerJS no-padding"  data-position="top" data-step="7" data-intro="<?php echo get_phrase('Click on this button to add a new poll answer.'); ?>"><button type="button" id="add_answer" title="Add Answer" class="fcbtn btn btn-danger btn-outline btn-1d">+</button></div>
                    </div>
                    <br>
                    <div class="col-xs-12 text-right btn-center-in-sm">
                        <input type="hidden" id="answer_count" value="0">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"  name="submit_poll" value="save_poll" data-step="8" data-position="left" data-intro="<?php echo get_phrase('Click on the submit button to create an online poll.'); ?>">
                <?php echo get_phrase('add_poll'); ?>
                        </button>
                    </div>
            </div>
        <?php echo form_close(); ?>
    </section>
</div>
</div>
</section>
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
    
    function publish_blog(blog_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/blog_available/' + blog_id,
            success: function (response) {
                $("#publish" + blog_id).prop('disabled', true);
                toastr.success('Blog is now public');

            },
            error: function (response) {
                alert("error");
            }
        });
    }
</script>