<div class="row">
	<div class="col-md-12">
			
			<ul class="nav nav-tabs bordered">
                            
				<li class="active">
					<a href="#unpaid" data-toggle="tab">
                                                <span class="visible-xs"><i class="entypo-plus"></i></span> 
						<span class="hidden-xs"><i class="entypo-plus"></i><?php echo get_phrase('create_single_invoice');?></span>
					</a>
				</li>
				<li>
					<a href="#paid" data-toggle="tab">
                                            <span class="visible-xs"><i class="entypo-plus-circled"></i></span> 
						<span class="hidden-xs"><i class="entypo-plus-circled"></i><?php echo get_phrase('create_mass_invoice');?></span>
					</a>
				</li>
                <li>
					<a href="#credit" data-toggle="tab">
                                            <span class="visible-xs"><i class="entypo-vcard"></i></span> 
						<span class="hidden-xs"><i class="entypo-vcard"></i><?php echo get_phrase('Add_credit_student');?></span>
					</a>
				</li>
			</ul>
			
			<div class="tab-content">
        
				<div class="tab-pane active top-for-tabs" id="unpaid">

				<!-- creation of single invoice -->
				<?php echo form_open(base_url() . 'index.php?school_admin/invoice/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
				<div class="row">
					<div class="col-md-6">
	                        <div class="panel panel-default panel-shadow" data-collapsed="0">
	                            <div class="panel-heading">
	                                <div class="panel-title"><?php echo get_phrase('invoice_informations');?></div>
	                            </div>
	                            <div class="panel-body">
	                                
	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
	                                    <div class="col-sm-9">
	                                        <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return get_class_students(this.value)">
	                                        	<option value=""><?php echo get_phrase('select_class');?></option>
	                                        	<?php foreach ($classes as $row):
	                                        	?>
	                                        	<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
	                                        	<?php endforeach;?>
	                                            
	                                        </select>
	                                    </div>
	                                </div>

	                                <div class="form-group">
		                                <label class="col-sm-3 control-label"><?php echo get_phrase('student');?></label>
		                                <div class="col-sm-9">
		                                    <select name="student_id" class="selectpicker" data-style="form-control" data-live-search="true" style="width:100%;" id="student_selection_holder">
		                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
		                                    	
		                                    </select>
		                                </div>
		                            </div>

	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="form-control" name="title"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
	                                    </div>
	                                </div>
	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="form-control" name="description"/>
	                                    </div>
	                                </div>

	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="datepicker form-control" name="date"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
	                                    </div>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-md-6">
                        <div class="panel panel-default panel-shadow" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo get_phrase('payment_informations');?></div>
                            </div>
                            <div class="panel-body">
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('total');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="amount"
                                            placeholder="<?php echo get_phrase('enter_total_amount');?>"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="amount_paid"
                                            placeholder="<?php echo get_phrase('enter_payment_amount');?>"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                                    <div class="col-sm-9">
                                        <select name="status" class="selectpicker" data-style="form-control" data-live-search="true">
                                            <option value="paid"><?php echo get_phrase('paid');?></option>
                                            <option value="unpaid"><?php echo get_phrase('unpaid');?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                                    <div class="col-sm-9">
                                        <select name="method" class="selectpicker" data-style="form-control" data-live-search="true">
                                            <option value="1"><?php echo get_phrase('cash');?></option>
                                            <option value="2"><?php echo get_phrase('check');?></option>
                                            <option value="3"><?php echo get_phrase('card');?></option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 btn-center-in-sm">
                                <button type="submit" class="btn btn-info btn_float_center pull-right"><?php echo get_phrase('add_invoice');?></button>
                            </div>
                        </div>
                    </div>


	                </div>
	              	<?php echo form_close();?>

				<!-- creation of single invoice -->
					
				</div>
                            
				<div class="tab-pane" id="paid">

				<!-- creation of mass invoice -->
				<?php echo form_open(base_url() . 'index.php?school_admin/invoice/create_mass_invoice' , array('class' => 'form-horizontal form-groups-bordered validate', 'id'=> 'mass' ,'target'=>'_top'));?>
				<br>
				<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-5">

					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                        <div class="col-sm-9">
                            <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return get_class_students_mass(this.value)">
                            	<option value=""><?php echo get_phrase('select_class');?></option>
                            	<?php 
                            		foreach ($classes as $row):
                            	?>
                            	<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                            	<?php endforeach;?>
                                
                            </select>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title"
                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('total');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="amount"
                                placeholder="<?php echo get_phrase('enter_total_amount');?>"
                                    data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('payment');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="amount_paid"
                                placeholder="<?php echo get_phrase('enter_payment_amount');?>"
                                    data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                        <div class="col-sm-9">
                            <select name="status" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value="paid"><?php echo get_phrase('paid');?></option>
                                <option value="unpaid"><?php echo get_phrase('unpaid');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-9">
                            <select name="method" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value="1"><?php echo get_phrase('cash');?></option>
                                <option value="2"><?php echo get_phrase('check');?></option>
                                <option value="3"><?php echo get_phrase('card');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="datepicker form-control" name="date"
                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-6 btn-center-in-sm">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('add_invoice');?></button>
                        </div>
                    </div>
                    


				</div>
				<div class="col-md-6">
					<div id="student_selection_holder_mass"></div>
				</div>
				</div>
				<?php echo form_close();?>

				<!-- creation of mass invoice -->

				</div>
                            
				<div class="tab-pane top-for-tabs" id="credit">

				<!-- creation of single invoice -->
				<?php echo form_open(base_url() . 'index.php?school_admin/dotransaction' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
				<div class="row">
				<div class="col-md-12">
	                        <div class="panel panel-default panel-shadow" data-collapsed="0">
	                            <div class="panel-heading">
	                                <div class="panel-title"><?php echo get_phrase('Student_credit');?></div>
	                            </div>
	                            <div class="panel-body">
                                        <div class="col-xs-12 col-sm-6">  
	                                <div class="">
         
                                                <label class="control-label"><?php echo get_phrase('class');?></label>
	                                   
	                                        <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true"
	                                        	onchange="return get_class_students1(this.value)">
	                                        	<option value=""><?php echo get_phrase('select_class');?></option>
	                                        	<?php
	                                        		foreach ($classes as $row):
	                                        	?>
	                                        	<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
	                                        	<?php endforeach;?>
	                                            
	                                        </select>
                                        </div></div>

	                                <div class="col-xs-12 col-sm-6">
                                        <div class="">
		                                <label class="control-label"><?php echo get_phrase('student');?></label>
		                                
		                                    <select name="studentid" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return get_student_balance(this.value)" style="width:100%;" id="student_selection_holder1">
		                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
		                                    	
		                                    </select>
		                                </div>
		                            </div>

	                               <div class="col-xs-12 col-sm-6">
                                        <div class="">
	                                    <label class="control-label"><?php echo get_phrase('current_amount');?></label>
	                                    
	                                        <input type="text" readonly="readonly" id="student_balance_text" class="form-control" name="title" value=""/>
	                                    </div>
	                                </div>
                                       <div class="col-xs-12 col-sm-6">
	                                <div class="">
	                                    <label class="control-label"><?php echo get_phrase('add_amount');?></label>
	                                    
	                                        <input type="text" class="form-control" name="amount"/>
                                            <input type="hidden" class="form-control" name="type" value="credit"/>
                                            <input type="hidden" class="form-control" name="desc" value="Amount added by admin" />
                                            <input type="hidden" name="timestamp" value="<?php echo date('H:i:s M d, Y'); ?>" readonly="readonly">
	                                    </div>
	                                </div>
                                        
                                        <div class="col-xs-12 btn-center-in-sm" style="margin-top:20px;">
                                                <button type="submit" class="btn btn-info btn_float_center pull-right"><?php echo get_phrase('add_payment');?></button>
                                         </div>  
	                            </div>
	                        </div>
	                    </div>

	                    


	                </div>
	              	<?php echo form_close();?>

				<!-- creation of single invoice -->
					
				</div>
			</div>
			
			
	</div>
</div>

<script type="text/javascript">
	// function check() {
 //    	$("#selectall").click(function () {
 //    		$("input:checkbox").prop('checked', $(this).prop("checked"));
	// 	});
	// }

	function select() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = true ;
			}

		//alert('asasas');
	}
	function unselect() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = false ;
			}
	}
</script>

<script type="text/javascript">
    function get_class_students(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_class_students/' + class_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder').html(response).selectpicker('refresh');
            }
        });
    }
	 function get_class_students1(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_class_students/' + class_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder1').html(response).selectpicker('refresh');
            }
        });
    }
	 function get_student_balance(student_id) {
		 
        $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_student_balance/' + student_id ,
            success: function(response)
            {
               //alert(response);
			    jQuery('#student_balance_text').val(response);
            }
        });
    }
</script>

<script type="text/javascript">
    function get_class_students_mass(class_id) {
    	
        $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_class_students_mass/' + class_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder_mass').html(response).selectpicker('refresh');
            }
        });

        
    }
</script>