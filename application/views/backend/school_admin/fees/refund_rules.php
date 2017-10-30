<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo $page_title; ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="listing" class="active">
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('refund_rules_list'); ?></span></a>
                    </li>
                    <li id="create">
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_refund_rule'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no');?></div></th>
                                <th><div><?php echo get_phrase('rule_name');?></div></th>
                                <th><div><?php echo get_phrase('group_name');?></div></th>
                                <th><div><?php echo get_phrase('term_type');?></div></th>
                                <th><div><?php echo get_phrase('term_name');?></div></th>
                                <th><div><?php echo get_phrase('amount');?></div></th>
                                <th><div><?php echo get_phrase('action');?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($refund_rules as $row): ?>
                                <tr>
                                    <td><?php echo $count++;?></td>
                                    <td><?php echo $row['name'];?></td>
                                    <td><?php echo $row['fee_group_name'];?></td>
                                    <td><?php echo $row['term_name'];?></td>
                                    <td><?php echo $row['setup_term_name'];?></td>
                                    <td><?php echo $row['amount_type']==1?$row['amount'].'%':$row['amount']?></td>
                                    <td>
                                        <a href="<?php echo base_url('index.php?fees/refund/refund_rule_edit/'.$row['id']);?>">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                                         </a>
                                         <a href="javascript:void(0)" onclick="confirm_modal('<?php echo base_url();?>index.php?fees/refund/deleterefundrule/<?php echo $row['id']; ?>');">
                                             <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                         </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->


                <!--CREATION FORM STARTS-->
                <section id="add">  
                    <?php echo form_open(base_url('index.php?fees/refund/refund_rule_create'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase("current_session"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <input name="running_year" class="form-control" value="<?php echo sett('running_year')?>" readonly>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('fee_group'); ?><span class="error" style="color: red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="fee_group_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required"
                                    data-title="Select Fee Group">
                                    <?php foreach($fee_groups as $grp){?>
                                        <option value="<?php echo $grp->id?>"><?php echo $grp->name?></option>
                                    <?php }?>                
                                </select>
                            </div>
                        </div> 
                    </div>
                    <br/>
                    
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('term_type'); ?><span class="error" style="color: red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="term_type_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required" 
                                    data-title="Select Term Type">
                                    <?php foreach($term_types as $trm){?>
                                        <option value="<?php echo $trm->id?>"><?php echo $trm->name?></option>
                                    <?php }?>                
                                </select>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('fee_term'); ?><span class="error" style="color: red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="setup_term_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                                </select>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('rule_name'); ?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo set_value('name')?>" required="required" /> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase("valid_from"); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-numeric-desc"></i></div>    
                                <input type="text" class="form-control" id="valid_from" name="valid_from" placeholder="Valid From" 
                                value="<?php echo set_value('valid_from') ?>" required="required" />
                            </div> 
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase("valid_to"); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-numeric-desc"></i></div>    
                                <input type="text" class="form-control" id="valid_to" name="valid_to" placeholder="Valid To" 
                                value="<?php echo set_value('valid_to')?>" required="required" />
                            </div> 
                        </div>
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <div class="input-group">
                                <label for="field-1"><?php echo get_phrase("amount_type"); ?><span class="mandatory"> *</span></label><br/>
                                <input type="radio" name="amount_type" value="1" <?php echo 1==set_value('amount_type',1)?'checked':''; ?> /> Percentage
                                <input type="radio" name="amount_type" value="2" <?php echo 2==set_value('amount_type')?'checked':''; ?> /> Fixed
                                <label class="mandatory"> <?php echo form_error('amount_type'); ?></label>            
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase("amount"); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-numeric-desc"></i></div>    
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="amount" value="<?php set_value('amount'); ?>" required="required" />
                             </div> 
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                        </div>
                    </div>
                    </form>    
                </section>                
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
var formError = "<?php echo @$form_error; ?>";
formError = parseInt(formError);
if(formError == 1) {
    $(document).ready(function(){
        $('#create').addClass('tab-current');
        $('#create a').click();
        $('#add').css('display','block');
        $('#list').css('display','none');
        $('#listing').removeClass('tab-current');
    });
} 

$('#cate a').click(function(){
    $('#add').css('display','none');
    $('#list').css('display','block');
    $('#create').removeClass('tab-current');
    $('#listing').addClass('tab-current');
});

$('#valid_from,#valid_to').datepicker({
    //startDate: new Date(),
    autoclose: true,
    format:'yyyy-mm-dd'
}); 

$(document).on('change','select[name=fee_group_id],select[name=term_type_id]',function (e) {
    var fee_group_id    =  $('select[name=fee_group_id] option:selected').val();
    var term_type_id    =  $('select[name=term_type_id] option:selected').val();
    if(!fee_group_id || !term_type_id){
        return false;
    }
    
    $.ajax({type:'post',  
            url: '<?php echo base_url('index.php?fees/ajax/get_fee_setup_terms_by_group')?>', 
            data:{fee_group_id:fee_group_id,term_type_id:term_type_id},
            dataType:'json',
            success:function (res) {
                if(res.status=='success'){
                    $('select[name=setup_term_id]').html(res.html);
                    $('select[name=setup_term_id]').selectpicker('refresh');
                }else{
                    swal('Error',res.msg,res.status);
                }
            }
        });
}); 
</script>
    