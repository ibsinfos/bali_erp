<div class="row bg-title">
    
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">  
        <h4 class="page-title"><?php echo get_phrase('View_Admission_Form'); ?> </h4></div>i
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('View_Admission_Form'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
  
<div class="row">
        <div class="col-md-12">        
            <div class="panel panel-danger" data-collapsed="0" >
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-info"></i>
                        <?php echo get_phrase("please_furnish_the_below_details.__('*')_shows_mandatory_fields"); ?>
                    </div>
                </div> 
                
                <div class="container">
                    <h2><?php echo get_phrase('student_information'); ?></h2>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-xs-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_first_name");?><span class="error" style="color: red;"> *</span></label>
                                <?php echo form_error('student_fname'); ?>
                                <input class="form-control" type="text" placeholder="First Name" name = "student_fname" value="<?php echo set_value('student_fname'); ?>" required />
                            </div>
                            <div class="col-xs-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_last_name");?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Last Name" name="student_lname" required/>
                            </div>
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("previous_class");?><span class="error" style="color: red;"> *</span></label>                       
                                <select name="previous_class" class="selectpicker" data-style="form-control" data-live-search="true" required>                            
                                    <option value=""><?php echo get_phrase('select_class');?></option>
                                    <?php foreach($classes as $class):?>
                                    <option value="<?php echo $class['class_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
                                    <?php endforeach; ?> 
                                </select>
                            </div>                    
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("previous_school");?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Previous School" name="previous_school" required/>
                            </div>                  
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("category");?><span class="error" style="color: red;"> *</span></label>                        
                                <select  class="selectpicker" data-style="form-control" data-live-search="true" name='category' id ='category' required>
                                    <option value=''>select Category</option>
                                    <option value='1'>GENERAL</option>
                                    <option value='2'>OBC</option>
                                    <option value='3'>ST</option>
                                    <option value='4'>SC</option>
                                </select>
                            </div>
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("class_you_want_to_apply_for");?><span class="error" style="color: red;"> *</span></label>                       
                                <select name="class" class="selectpicker" data-style="form-control" data-live-search="true" required>                            
                                    <option value=""><?php echo get_phrase('select_class');?></option>
                                    <?php foreach($classes as $class):?>
                                    <option value="<?php echo $class['class_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
                                    <?php endforeach; ?> 
                                </select>                       

                            </div>
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("date_of_birth");?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control datepicker" type="text" placeholder="Date of birth" name="birthday" id="datepicker" required/>
                                <!--p id="age"></p-->
                            </div>                    
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("gender");?><span class="error" style="color: red;"> *</span></label>                        
                                <select class="selectpicker" data-style="form-control" data-live-search="true" name='gender' id ='category' required>
                                    <option value=''>select Gender</option>
                                    <option value='1'>Male</option>
                                    <option value='2'>Female</option>                          
                                </select>
                            </div>                
                            </div> 
                        </div>
                    </div>
                    <h2><?php echo get_phrase('student_information'); ?></h2>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-xs-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_first_name");?><span class="error" style="color: red;"> *</span></label>
                                <?php echo form_error('student_fname'); ?>
                                <input class="form-control" type="text" placeholder="First Name" name = "student_fname" value="<?php echo set_value('student_fname'); ?>" required />
                            </div>
                            <div class="col-xs-6 form-group">
                                <label for="field-2" class="col-sm-0"><?php echo get_phrase("student's_last_name");?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control" type="text" placeholder="Last Name" name="student_lname" required/>
                            </div>
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("previous_class");?><span class="error" style="color: red;"> *</span></label>                       
                                <select name="previous_class" class="selectpicker" data-style="form-control" data-live-search="true" required>                            
                                    <option value=""><?php echo get_phrase('select_class');?></option>
                                    <?php foreach($classes as $class):?>
                                    <option value="<?php echo $class['class_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
                                    <?php endforeach; ?> 
                                </select>
                            </div>                    
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("previous_school");?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control numeric" maxlength="10" type="tel" placeholder="Previous School" name="previous_school" required/>
                            </div>                  
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("category");?><span class="error" style="color: red;"> *</span></label>                        
                                <select  class="selectpicker" data-style="form-control" data-live-search="true" name='category' id ='category' required>
                                    <option value=''>select Category</option>
                                    <option value='1'>GENERAL</option>
                                    <option value='2'>OBC</option>
                                    <option value='3'>ST</option>
                                    <option value='4'>SC</option>
                                </select>
                            </div>
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("class_you_want_to_apply_for");?><span class="error" style="color: red;"> *</span></label>                       
                                <select name="class" class="selectpicker" data-style="form-control" data-live-search="true" required>                            
                                    <option value=""><?php echo get_phrase('select_class');?></option>
                                    <?php foreach($classes as $class):?>
                                    <option value="<?php echo $class['class_id'];?>"><?php echo get_phrase('class');?><?php echo " ".$class['name'];?></option> 
                                    <?php endforeach; ?> 
                                </select>                       

                            </div>
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("date_of_birth");?><span class="error" style="color: red;"> *</span></label>
                                <input class="form-control datepicker" type="text" placeholder="Date of birth" name="birthday" id="datepicker" required/>
                                <!--p id="age"></p-->
                            </div>                    
                            <div class="col-xs-3 form-group">
                                <label><?php echo get_phrase("gender");?><span class="error" style="color: red;"> *</span></label>                        
                                <select  class="selectpicker" data-style="form-control" data-live-search="true" name='gender' id ='category' required>
                                    <option value=''>select Gender</option>
                                    <option value='1'>Male</option>
                                    <option value='2'>Female</option>                          
                                </select>
                            </div> 
                                
                                <table class="table table-bordered table-hover" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center">
							#
						</th>
						<th class="text-center">
							Name
						</th>
						<th class="text-center">
							Mail
						</th>
						<th class="text-center">
							Mobile
						</th>
					</tr>
				</thead>
				<tbody>
					<tr id='addr0'>
						<td>
						1
						</td>
						<td>
						<input type="text" name='name0'  placeholder='Name' class="form-control"/>
						</td>
						<td>
						<input type="text" name='mail0' placeholder='Mail' class="form-control"/>
						</td>
						<td>
						<input type="text" name='mobile0' placeholder='Mobile' class="form-control numeric"/>
						</td>
					</tr>
                    <tr id='addr1'></tr>
				</tbody>
			</table>
                                
                        <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a>        
                                
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="container">
    <div class="row clearfix">
		<div class="col-md-12 column">
			
		</div>
	</div>
	
</div>



<script>
     $(document).ready(function(){
      var i=1;
     $("#add_row").click(function(){
      $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='name"+i+"' type='text' placeholder='Name' class='form-control input-md'  /> </td><td><input  name='mail"+i+"' type='text' placeholder='Mail'  class='form-control input-md'></td><td><input  name='mobile"+i+"' type='text' placeholder='Mobile'  class='form-control input-md'></td>");

      $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
      i++; 
  });
     $("#delete_row").click(function(){
    	 if(i>1){
		 $("#addr"+(i-1)).html('');
		 i--;
		 }
	 });

});
</script>