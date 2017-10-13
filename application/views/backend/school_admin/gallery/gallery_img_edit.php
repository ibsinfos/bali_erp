<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_gallery_image'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/dashboard');?>"><?php echo get_phrase('Dashboard');?></a></li>

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
<div class="row m-0">
    <div class="col-md-12 white-box">
        <?php echo form_open(base_url('index.php?school_admin/gallery_img_edit/'.$img->id), array('class' => 'form-horizontal form-groups-bordered validate', 
        'target' => '_top')); ?>
        
        <div class="row">          
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <img src="<?php echo $img->bucket.$img->main?>" class="img-thumbnail">
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <label for="field-1"><strong><?php echo get_phrase('photo_caption');?></strong><span class="error mandatory">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-road"></i></div>
                    <input type="text" class="form-control" name="title" required="required" value="<?php echo $img->title?>"/> 
                </div>
            </div> 
        </div>
        <br/>

        <div class="row">          
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <label for="field-1"><strong><?php echo get_phrase('photo_brief');?></strong></label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
                    <textarea class="form-control" name="brief"><?php echo $img->brief?></textarea>
                </div> 
            </div>
        </div>
        <br>
        
        <div class="row">          
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <label for="field-1"><strong><?php echo get_phrase('tagged_people');?></strong></label>
                <div class="">
                    <h3>No one tagged!</h3>
                </div>
            </div>
        </div>   

        <div class="row">          
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <label for="field-1"><strong><?php echo get_phrase('photo_tagging');?></strong></label>
                <div class="row">
                    <div class="col-md-4">
                        <select name="user-type" class="selectpicker" data-style="form-control">
                            <option value="1">Student</option>
                            <option value="2">Teacher</option>
                            <option value="3">Parent[father]</option>
                            <option value="4">Parent[mother]</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="user-val" class="selectpicker" data-style="form-control" data-live-search="true">
                            <?php foreach($students as $stu){?>
                                <option value="<?php echo $stu->student_id?>" data-type="teacher"><?php echo $stu->name.' '.$stu->lname?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-primary"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="form-group">
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit');?></button>
            </div>
        </div>
    <?php echo form_close()?> 
    </div>
</div>
<script>
$(function(){
    $(document).on('change','select[name=user-type]',function(){
        $obj = $(this);
        $.ajax({
            type:'POST',
            url:'<?php echo base_url('index.php?school_admin/get_users_by_user_type')?>',
            data:{'class_id':'<?php echo $img->class_id?>','type':$obj.val()},
            dataType:'json',
            success:function(res){
                $('select[name=user-val]').html(res.html);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });
});

$(document).on('change','input[name=non_enroll]',function(){
    if(this.checked){
        $('input[name=amount]').val('');
        $('.amt-box').show();            
    }else{
        $('input[name=amount]').val('');          
        $('.amt-box').hide();
    }
});
</script>