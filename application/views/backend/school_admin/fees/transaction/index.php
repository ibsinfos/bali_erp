<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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
                    <li class="active">
                        <a href="#income" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('income'); ?></span></a>
                    </li>
                    <li>
                        <a href="#expense" class="sticon fa fa-list">
                            <span class="hidden-xs"><?php echo get_phrase('expense'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#add" class="sticon fa fa-plus">
                            <span class="hidden-xs"><?php echo get_phrase('add'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="income">            
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('sl_no'); ?></div></th>
                                <th><div><?php echo get_phrase('title'); ?></div></th>
                                <th><div><?php echo get_phrase('amount'); ?></div></th>
                                <th><div><?php echo get_phrase('category'); ?></div></th>
                                <th><div><?php echo get_phrase('transaction_date'); ?></div></th>
                                <th><div><?php echo get_phrase('description'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody><?php $c= 1; $sum = 0; if(count($income_data)){ foreach($income_data as $datum){ ?>
                            <tr>
                                <td><?php echo $c++;?></td>
                                <td><?php echo ucwords($datum['title']);?></td>
                                <td><?php echo round($datum['amount'], 2); $sum+=$datum['amount'];?></td>
                                <td><?php echo ucwords($datum['category_name']);?></td>
                                <td><?php echo date('d-m-Y', strtotime($datum['date']));?></td>
                                <td><?php echo $datum['description'];?></td>
<td><a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_fi_revert_transaction/income/<?php echo $datum['fi_income_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete"><i class="fa fa-trash-o"></i></button></a><?php }?></td>
                            </tr><?php }?>
                        </tbody>                        
                        <tfoot>
                            <th colspan="2" style="text-align: right;">Grand Total</th>    
                            <th><?php echo round($sum, 2);?></th>
                            <th colspan="4"></th>
                        </tfoot>
                    </table>
                </section>
                <section id="expense">
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="MoreTable">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('sl_no'); ?></div></th>
                                <th><div><?php echo get_phrase('title'); ?></div></th>
                                <th><div><?php echo get_phrase('amount'); ?></div></th>
                                <th><div><?php echo get_phrase('category'); ?></div></th>
                                <th><div><?php echo get_phrase('transaction_date'); ?></div></th>
                                <th><div><?php echo get_phrase('description'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody><?php $c= 1; $sum = 0; if(count($expense_data)){ foreach($expense_data as $datum){ ?>
                            <tr>
                                <td><?php echo $c++;?></td>
                                <td><?php echo ucwords($datum['title']);?></td>
                                <td><?php echo round($datum['amount'], 2); $sum+=$datum['amount'];?></td>
                                <td><?php echo ucwords($datum['category_name']);?></td>
                                <td><?php echo date('d-m-Y', strtotime($datum['date']));?></td>
                                <td><?php echo $datum['description'];?></td>
    <td><a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_fi_revert_transaction/expense/<?php echo $datum['fi_expenditure_id'];?>');" ><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete"><i class="fa fa-trash-o"></i></button></a><?php }?></td>
                            </tr><?php }?>
                        </tbody>
                        <tfoot>
                            <th colspan="2" style="text-align: right;">Grand Total</th>    
                            <th><?php echo round($sum, 2);?></th>
                            <th colspan="4"></th>
                        </tfoot>
                    </table>                                    
                </section>
                <section id="add"> 
<?php echo form_open(base_url().'index.php?fees/transaction/add'); if($this->session->flashdata('flash_message_error')) {?><div class="alert alert-danger"><?php echo $this->session->flashdata('flash_message_error'); ?></div><?php }?>

                    <div class="col-md-12">                       
                        <div class="col-md-6 col-md-offset-3">
                            <label for="transaction_type"><?php echo get_phrase("transaction_type"); ?><span class="error" style="color: red;">*</span></label>
                            <select class="form-control" onchange="GetCategory(this.value)" name="transaction_type" required="required">
                                <option value=""><?php echo get_phrase("select"); ?></option>
                                <option value="1"><?php echo get_phrase("income"); ?></option>
                                <option value="2"><?php echo get_phrase("expenditure"); ?></option>
                            </select>
                        </div>                    
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-xs-12 col-md-6 col-md-offset-3">
                            <label for="title"><?php echo get_phrase("title"); ?><span class="mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>                  
    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title')?>" placeholder="Enter title" required="required"><span class="mandantory"><?php echo form_error('title'); ?></span>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-xs-12 col-md-6 col-md-offset-3">
                            <label for="amount"><?php echo get_phrase("amount"); ?><span class="mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-money"></i></div>                  
    <input type="text" class="form-control numeric" id="amount" name="amount" value="<?php echo set_value('amount')?>" placeholder="Enter amount"  required="required"><span class="mandantory"><?php echo form_error('amount'); ?></span>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group col-xs-12 col-md-6 col-md-offset-3">
                            <label for="date"><?php echo get_phrase("date"); ?><span class="mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                  
        <input type="text" class="form-control mydatepicker" id="date" name="date" value="<?php echo set_value('date')?>" placeholder="Enter date" required="required"><span class="mandantory"><?php echo form_error('date'); ?></span>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                            <label for="category"><?php echo get_phrase("category"); ?><span class="error" style="color: red;">*</span></label>
                            <select class="form-control" name="fi_category_id" required="required" id="fi_category_id" onchange="checkself(this.value)">
                                <option value=""><?php echo get_phrase("select"); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6 col-md-offset-3"><br>
                            <label for="description"><?php echo get_phrase('description');?><span class="error" style="color: red;">*</span></label>
                            <textarea class="form-control" rows="8" name="description" required="required"></textarea>
                        </div>
                    </div>

                    <div class="col-md-9 form-group text-right"><br>
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase("submit");?></button>
                    </div>
                <?php echo form_close();?>                            
                </section>                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function GetCategory(id=''){
        var category = '<option value="">Select</option>';
        if(id!=''){ 
            $.ajax({
                url : '<?php echo base_url();?>index.php?ajax_controller/get_fi_category',
                type: 'POST',
                data :{category_type: id},
                success: function(response){
                    if(response){
                        data = JSON.parse(response);
                        if(data.length){
                            for(k in data){
                                category+='<option value="'+data[k]['fi_category_id']+'">'+data[k]['category_name']+'</option>';
                            }
                        }else{
                            alert('Category not found');
                        }                 
                    }else{
                        alert('Category not found');
                    }
                    $('#fi_category_id').empty();
                    $('#fi_category_id').html(category); 
                },
                error: function(){
                    alert('Category not found');
                    $('#fi_category_id').empty();
                    $('#fi_category_id').html(category);
                }
            });
        }else{
            $('#fi_category_id').empty();
            $('#fi_category_id').html(category);    
        }
    }
</script>  