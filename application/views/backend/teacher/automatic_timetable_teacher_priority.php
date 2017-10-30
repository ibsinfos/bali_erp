<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
       <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
    <!-- /.breadcrumb -->
</div>

<div class="col-xs-12 white-box">
    <form name="add_teacher_priority" id="add_teacher_priority" action="<?php echo base_url();?>index.php?teacher/automatic_timetable_add_teacher_priority" method="POST">
    <input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">

    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a class, then you will get a list of all subjects.');?>" data-position='right'>
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_class'); ?></label><span class="error" style="color: red;"></span>

        <select class="selectpicker classDropdownBox" data-style="form-control" data-live-search="true" class="selectpicker" name="class_id" id="class_id" required="required">
            <?php echo $class_option;?>
        </select>
    </div>
    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section, then you will get a list of all subjects.');?>" data-position='right'>
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section'); ?></label><span class="error" style="color: red;"></span>

        <select class="form-control sectionDropdownBox" name="section_id" id="section_id" required="required">
            <option value=""><?php echo get_phrase('select'); ?></option>
        </select>
    </div>
    <div class="form-group col-sm-4" data-step="7" data-intro="<?php echo get_phrase('Select a subject for set a priority.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_subject'); ?></label>
        <select class="form-control subjectDropdownBox" name="subject_id" id="subject_id" required="required">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_priority'); ?></label>
        <select class="form-control" name="subject_priority" id="subject_priority" required="required">
            <option value=""><?php echo get_phrase('select'); ?></option> 
            <?php for($i=1;$i<11;$i++):?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php endfor;?>
        </select>
    </div>

    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('save'); ?></button>
    </div>
    </form>
</div>

<div class="row">
    <div class="col-sm-12">    
        <div class="white-box" data-step="9" data-intro="Here you can view here priority details" data-position="top"> 
            <table id="ex" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('class'); ?></div></th>
                        <th><div><?php echo get_phrase('subject'); ?></div></th>
                        <th><div><?php echo get_phrase("priority");?></div></th>
                        <th><div><?php echo get_phrase("action"); ?></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($teacher_priority_list AS $k):?>
                    <tr>
                        <td><?php echo $k['class'];?></td>
                        <td><?php echo $k['subject'];?></td>
                        <td><?php echo $k['priority'];?></td>
                        <td>
                            <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?teacher/delete_automatic_timetable_add_teacher_priority/<?php echo $k['teacher_preference_id']; ?>');">
                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                    data-placement="top" data-original-title="<?php echo get_phrase('delete') ?>" title="<?php echo get_phrase('delete') ?>">
                                <i class="fa fa-trash-o"></i>
                            </button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">    
        <div class="white-box" data-step="9" data-intro="Here you can view here priority details" data-position="top"> 
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('class'); ?></div></th>
                        <th><div><?php echo get_phrase('subject'); ?></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($teacher_missing_class_priority_list AS $k):?>
                    <tr>
                        <td><?php echo $k['class_name'];?></td>
                        <td><?php echo $k['subject_name'];?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var TeacherId = '<?php echo $this->session->userdata('login_user_id');?>';

        $('.classDropdownBox').on('change',function(){
            $.ajax({
                url:'<?php echo base_url()?>index.php?ajax_controller/get_sections_by_class/'+$(this).val()+'/'+TeacherId,
                //data:'teacher_id='+$(this).val(),
                type:'POST',
                success:function(sectionData){
                    console.log(sectionData);
                    $('.sectionDropdownBox').html(sectionData);
                }
            });
        });
        
        $('.sectionDropdownBox').on('change',function(){
            $.ajax({
                url:'<?php echo base_url()?>index.php?ajax_controller/get_subjectby_class_section/'+$('.classDropdownBox').val()+'/'+$(this).val()+'/'+TeacherId,
                //data:'teacher_id='+$(this).val(),
                type:'POST',
                success:function(subjectData){
                    console.log(subjectData);
                    $('.subjectDropdownBox').html(subjectData);
                }
            });
        });
    });
</script>