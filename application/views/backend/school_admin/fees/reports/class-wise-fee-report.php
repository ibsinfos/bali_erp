<style>
#dt_table thead{    background: #707cd2;}
#dt_table thead tr th{font-weight:bold;color:#fff}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('class_wise_fee_report');?></h4>
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
                    <label><?php echo get_phrase('class')?></label>        
                    <select name="class_id" class="selectpicker" data-live-search="true" data-style="form-control" title="Select Class">
                        <option value="0"><?php echo get_phrase('all_class')?></option>
                        <?php foreach($classes as $cls){?>        
                            <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                        <?php }?>    
                    </select>
                </div> 
                
                <!-- <div class="col-md-3">
                    <label><?php echo get_phrase('student')?></label>        
                    <select class="input-sm form-control" name="student_id"> 
                        <option value=""><?php echo get_phrase('select_student')?></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label><?php echo get_phrase('Fees')?></label>        
                    <select class="input-sm form-control" name="fee"> 
                        <option value=""><?php echo get_phrase('Select Fees')?></option>
                    </select>
                </div>   -->
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
                    <th style="width:20%"><div><?php echo get_phrase('fee_term');?></div></th>
                    <th style="width:20%"><div><?php echo get_phrase('fee_head');?></div></th>
                    <th style="width:10%"><div><?php echo get_phrase('amount');?></div></th>
                    <th style="width:10%"><div><?php echo get_phrase('paid_amount');?></div></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function(){
    /* $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        order: [[ 0, "desc" ]]
    });*/

    $('select[name=class_id]').change(function(){
        var class_id = this.value;
        
        $('body').loading('start');
        $.ajax({
            type:'post',
            url: '<?php echo base_url('index.php?fees/ajax/get_class_wise_due_report')?>',
            data: {class_id:class_id},
            dataType: 'json',
            success:function(res){
                $('body').loading('stop');
                $('#dt_table').find('tbody').html(res.html);
            }    
        });        
    });

});
</script>