<style>
#dt_table thead{    background: #707cd2;}
#dt_table thead tr th{font-weight:bold;color:#fff}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('term_wise_fee_report');?></h4>
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
                
                <div class="col-md-3 class-select-box">
                    <label><?php echo get_phrase('select_term')?></label>        
                    <select name="fee_id" class="selectpicker" data-live-search="true" data-style="form-control" title="Select Term">
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>    

<div class="row m-0">
    <div class="col-md-12 white-box">
        <table class="table table-striped table-bordered" width="100%" id="dt_table">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no.');?></div></th>
                    <th><div><?php echo get_phrase('student_name');?></div></div></th>
                    <th><div><?php echo get_phrase('class');?></div></th>
                    <th style="width:20%"><div><?php echo get_phrase('fee_head');?></div></th>
                    <th style="width:15%"><div><?php echo get_phrase('amount');?></div></th>
                    <th style="width:15%"><div><?php echo get_phrase('paid_amount');?></div></th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <td colspan="6" class="text-center"><strong>No Records Found</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function(){
    $('select[name=class_id]').change(function(){
        var class_id = this.value;
        
        $('body').loading('start');
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_class_wise_terms')?>',
            data: {class_id:class_id},
            dataType: 'json',
            success:function(res){
                $('body').loading('stop');
                $('select[name=fee_id]').html(res.html);
                $('select[name=fee_id]').selectpicker('refresh');
            }    
        });        
    });

    $('select[name=fee_id]').change(function(){
        var class_id = $('select[name=class_id] option:selected').val();
        var term_id = this.value;
        
        $('body').loading('start');
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_term_wise_dues')?>',
            data: {class_id:class_id,term_id:term_id},
            dataType: 'json',
            success:function(res){
                $('body').loading('stop');
                $('#dt_table').find('tbody').html(res.html);
            }    
        });        
    });
});
</script>