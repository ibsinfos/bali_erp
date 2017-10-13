<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css')?>"/>
<style type="text/css">
    #ex tr td div{bacfdkground-color: lightgray; padding: 15px 15px; colfdor: #000;}
    thead th {font-weight:bold;}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> 
    </div>

    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
    <!-- /.page title -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12 white-box">
        <div class="row"> 
            <form method="post" id="collection-form">
                <input type="hidden" name="fee_type"/>
                <div class="col-md-8 col-md-offset-2">

                    <div class="row mt10">
                        <div class="col-md-4 class-select-box">
                            <label><?php echo get_phrase('class')?></label>        
                            <select class="form-control input-sm" name="class_id">
                                <option value=""><?php echo get_phrase('select_class')?></option>
                                <option value="0"><?php echo get_phrase('all_class')?></option>
                                <?php foreach($classes as $cls){?>        
                                    <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                                <?php }?>    
                            </select>
                        </div> 

                        <div class="col-md-4">
                            <label><?php echo get_phrase('Fees')?></label>        
                            <select class="form-control input-sm" name="fee"> 
                                <option value=""><?php echo get_phrase('Select Fees')?></option>
                            </select>
                        </div>      
                    </div>                

                    <div class="row mt10">
                        <div class="col-md-12">

                            <div id="due-students" class="dis-none">
                                <h3>Fee Due Students</h3>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th>S. No.</th>  
                                        <th>Admission No.</th> 
                                        <th>Enroll Code</th> 
                                        <th>Student Name</th>           
                                    </thead>
                                    <tbody>             
                                    </tbody>
                                </table>               
                            </div>            
   
                        </div>
                    </div>        

                </div>
            </form>    
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js')?>"></script>
<script>
$('select[name=class_id]')
.select2({placeholder: 'Select Class'})
.on('select2:select', function (evt) {
    $('body').loading('start');

    class_id = $('select[name=class_id]').val();
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_fees_by_class')?>',
        data: {class_id:class_id},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            
            $('#due-students').hide();
            $('select[name=fee]').html('');
            if(res.status=='success'){
                $('select[name=fee]').html(res.html);
            }
            if(res.status=='error'){
                swal('Error',res.msg,'error');
            }       
        }    
    });    
});

$('select[name=fee]')
.select2({placeholder: 'Select Fee'})
.on('select2:select', function (evt) {
    feeId = this.value;
    classId = $('select[name=class_id] option:selected').val();
    feeType = $('select[name=fee] option:selected').data('type');
    
    $('body').loading('start');
    $.ajax({
        type:'post',
        url: '<?php echo base_url('index.php?fees/ajax/get_due_fee_students')?>',
        data: {class_id:classId,fee_type:feeType,fee_id:feeId,ajax_request:1},
        dataType: 'json',
        success:function(res){
            $('body').loading('stop');
            $('#due-students').show();
            $('#due-students').find('tbody').html(res.html);
            if(res.status=='error'){
                swal('Error',res.msg,'error');
            }   
        }    
    });   
});
 
</script>