<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
<!-- /.row -->
<div class="col-md-12 white-box">
<?php echo form_open(base_url().'index.php?fees/transaction/revert/search'); if($this->session->flashdata('flash_message_error')) {?><div class="alert alert-danger"><?php echo $this->session->flashdata('flash_message_error'); ?></div><?php }?>                       
    <div class="col-md-4">
        <label for="revert_type"><?php echo get_phrase("revert_type"); ?><span class="error" style="color: red;">*</span></label>
        <select class="form-control" name="revert_type" required="required">
            <option value=""><?php echo get_phrase("select"); ?></option>
            <option value="1" <?php if($revert_type=='1'){ echo 'selected';}?> ><?php echo get_phrase("income"); ?></option>
            <option value="2" <?php if($revert_type=='2'){ echo 'selected';}?>><?php echo get_phrase("expenditure"); ?></option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="start_date"><?php echo get_phrase("start_date"); ?><span class="mandatory">*</span></label>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                  
            <input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("enter_start_date"); ?>" required="required" name="start_date" value="<?php echo $start_date;?>">
        </div> 
    </div>

    <div class="col-md-4">
        <label for="end_date"><?php echo get_phrase("end_date"); ?><span class="mandatory">*</span></label>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                  
            <input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("enter_end_date"); ?>" required="required" name="end_date" value="<?php echo $end_date;?>">
        </div> 
    </div>

    <div class="col-md-12 text-center"><br>
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase("search");?></button>
    </div>
    <?php echo form_close();?>
</div>

<?php if(count($data)){?>

<div class="col-md-12 white-box">
    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('sl_no'); ?></div></th>
                <th><div><?php echo get_phrase('amount'); ?></div></th>
                <th><div><?php echo get_phrase('cancelled_by'); ?></div></th>
                <th><div><?php echo get_phrase('reason'); ?></div></th>
                <th><div><?php echo get_phrase('revert_date'); ?></div></th>
                <th><div><?php echo get_phrase('type'); ?></div></th>
            </tr>
        </thead>
        <tbody><?php $n =1; foreach($data as $datum){?>
            <tr>
                <td><?php echo $n++;?></td>
                <td><?php echo round($datum['amount'], 2);?></td>
                <td><?php echo @$datum['deleted_by_user_name'];?></td>
                <td><?php echo ucfirst($datum['delete_reason']);?></td>
                <td><?php echo ucfirst($datum['deleted_at']);?></td>
                <td><?php echo ucwords($datum['category_name']);?></td>
            </tr><?php }?>
        </tbody>
    </table>
</div> <?php }?>

<script type="text/javascript">
    function GetData(){
        var RevertType = $('#revert_type').val();
        var StartDate = $('#start_date').val();
        var EndDate = $('#end_date').val();
        if((RevertType!='') && (StartDate) && (EndDate)){
            $.ajax({
                url : '<?php echo base_url();?>index.php?ajax_controller/get_revert_data',
                type: 'POST',
                data :{RevertType: RevertType, StartDate: StartDate, EndDate: EndDate},
                success: function(response){
                    if(response){
                        data = JSON.parse(response);
                        if(data.length){
                            /*for(k in data){
                                category+='<option value="'+data[k]['fi_category_id']+'">'+data[k]['category_name']+'</option>';
                            }*/
                        }else{
                            alert('Category not found');
                        }                 
                    }else{
                        alert('Category not found');
                    }
                    // $('#fi_category_id').empty();
                    // $('#fi_category_id').html(category); 
                },
                error: function(){
                    alert('Category not found');
                    $('#fi_category_id').empty();
                    $('#fi_category_id').html(category);
                }
            });
        }
    }
</script>