<style>
#dt_table thead{    background: #707cd2;}
#dt_table thead tr th{font-weight:bold;color:#fff}
.show-detail-box{}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('student_wise_fee_report');?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
        <div class="row">
            <form method="post" action="">
                <div class="col-md-3 class-select-box">
                    <label><?php echo get_phrase('select_class')?></label>        
                    <select name="class_id" class="selectpicker" data-live-search="true" data-style="form-control" title="Select Class">
                        <?php foreach($classes as $cls){?>        
                            <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                        <?php }?>    
                    </select>
                </div> 
                
                <div class="col-md-3">
                    <label><?php echo get_phrase('select_student')?></label>        
                    <select name="student_id" class="selectpicker" data-live-search="true" data-style="form-control" title="Select Student"> 
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>    

<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="row mt10  show-detail-box">
            <div class="col-md-12">
                <h3 class="bg-primary text-center">Student Detail</h3>     
                <table class="table no-padding stu-detail">
                    <thead>
                        <tr>
                            <th>Enroll Code</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th class="text-right">Date Of Joining</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
                   
            </div>
        </div>

        <h3>Fee Details</h3>
        <table class="table table-striped table-bordered" width="100%" id="dt_table">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('Name');?></div></th>
                    <th><div><?php echo get_phrase('status');?></div></th>
                    <th><div><?php echo get_phrase('amount');?></div></th>
                    <th><div><?php echo get_phrase('due_date');?></div></th>
                </tr>
            </thead>
            <tbody> 
               
            </tbody>
        </table>
    </div>
</div>

<script>
$(function(){
    $('select[name=class_id]').change(function(){
        $('body').loading('start');
        var class_id = this.value;
        
        class_id = this.value;
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_students')?>',
            data: {student_status:1,class_id:class_id},
            dataType: 'json',
            success:function(res){
                $('body').loading('stop');
    
                //console.log(res);
                $('select[name=student_id]').html('');
                if(res.status=='success'){
                    $('select[name=student_id]').html(res.html);
                    $('select[name=student_id]').selectpicker('refresh');
                }    
            }    
        });    
    });

    $('select[name=student_id]').change(function(){
        var class_id = $('select[name=class_id] option:selected').val();
        var student_id = this.value;
        
        $('body').loading('start');
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_student_wise_dues')?>',
            data: {student_id:student_id},
            dataType: 'json',
            success:function(res){
                $('body').loading('stop');
                $('#dt_table').find('tbody').html(res.html);
                $('.stu-detail').find('tbody').html(res.stu_detail_html);
            }    
        });        
    });
});
</script>