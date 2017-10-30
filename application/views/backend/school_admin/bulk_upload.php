<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
</div>
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('Instructions to be followed before uploading a file');?>" data-position='bottom'>
    <div class="panel-heading"> Instructions to be followed:
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p>
                Kindly do the Uploading in order mentioned below:<br>
                1) Parents<br>
                2) Classes and Sections<br>
                3) Students<br>
                Kindly ensure that parents, teachers, class and section are entered properly before uploading students, else data will not be uploaded properly.<br>
                Please follow these rules while entering data in Bulk upload sheets.
            <ol>
                <li>
                    All columns with dark red(<span style="height: 15px; width: 15px; background-color:#8b0000;display:inline-block;"></span>) color are mandatory to fill and the remaining columns are optional to fill.
                </li>
                <li>
                    Please enter the data in exact format specified for that field.For example in email field <br>
                rosalin.asina@gmail.com is different from Rosalin.asina@gmail.com or Rosalin.Asina@gmail.com
                </li>
                <li>
                    After entering all the data, please remove 15 rows from the bottom of the page, even if they do not have any data.
                </li>
                <li>
                    While entering any data of "date type" please follow the rule mentioned below.</b><br>
                First clear the column where you are about to add "Date" type data and then select the whole column and right click on it. Selelct "Format Cells" from menu.
                Then from "Custom" tab select "Type" to be "0". Then add all the dates in the format "dd.mm.yyyy" in the column.
                </li>
            </ol>                
            </p>
        </div>
    </div>
</div>

<div class="col-sm-12 white-box"> 
    <table id="example23" class="custom_table table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="80"><div><?php echo get_phrase('id');?></div></th>
                <th><div><?php echo get_phrase('add');?></div></th>
                <th><div><?php echo get_phrase('download');?></div></th>
                <th><div><?php echo get_phrase('upload');?></div></th>
                <th><div><?php echo get_phrase('submit');?></div></th>
            </tr>
        </thead>
        <tbody>
        <?php $count=1 ;?>  
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/parent/import_excel/' , array('id'=>'userfileParentForm','class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('parents');?></td>
            <td>
                <?php /*<a href="<?php echo base_url();?>uploads/Parent_Upload_Template.xlsx" target="_blank" data-step="6" data-intro="Download the file format and fill the required information" data-position='bottom'>*/?>
                <a href="<?php echo base_url();?>index.php?ajax_controller/downnload_parent_upload_template" target="_blank" data-step="6" data-intro="Download the file format and fill the required information" data-position='bottom'>
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                    </button>
                </a>
            </td>
            <td>
                <div class="form-group" data-step="7" data-intro="<?php echo get_phrase('Upload the template');?>" data-position='bottom'>
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td data-step="8" data-intro="<?php echo get_phrase('Submit the uploaded file')?>" data-position='top'>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
      
       <!-- For Classes & sections-->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/classes/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('classes_&_section');?></div></td>
            <td><div class="btn-group">                    
                <a href="<?php echo base_url();?>uploads/Class_Upload_Template.xlsx" target="_blank">
                 <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                    data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                     <i class="fa fa-download"></i>
                 </button>
                </a> 
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
        <!--For Students-->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/student_bulk_add/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('Students');?></td>
            <td>
                <?php /*<a href="<?php echo base_url();?>uploads/Student_Upload_Template.xlsx" target="_blank">*/?>
                <a href="<?php echo base_url();?>index.php?ajax_controller/downnload_student_upload_template" target="_blank">
                <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                   data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                    <i class="fa fa-download"></i>
                </button>
                </a>
            </td>
                
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        <!--  for student photo bulk upload-->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/student_bulk_photo_upload/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('student_photo_update');?></div></td>
            <td>
                <a href="<?php echo base_url();?>index.php?ajax_controller/download_student_data_for_photo_update" target="_blank">
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i> <?php //echo get_phrase('download_photo_upload');?>
                    </button>
                </a>
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('update_photos');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
        <!--For Grade-->
       <tr> 
        <?php echo form_open(base_url() . 'index.php?school_admin/grade/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('Grade');?></div></td>
            <td>
            <a href="<?php echo base_url();?>uploads/Grade_Upload_Template.xlsx" target="_blank">
                <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                   data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                    <i class="fa fa-download"></i>
                </button>
            </a> 
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
        <!------For Exam ---->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/exam/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('exam');?></div></td>
            <td>
                <a href="<?php echo base_url();?>uploads/Exam_Upload_Template.xlsx" target="_blank">
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                    </button>
                </a> 
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
        <!----For Subjects Upload--->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/subject/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('Subject');?></div></td>
            <td>
                <a href="<?php echo base_url();?>uploads/Subject_Upload_Template.xlsx" target="_blank">
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                    </button>
                </a> 
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
         <!---------For Routes------------>
        
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/transport/import_excel/' , array('class' => ' validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('Bus_stop');?></div></td>
            <td>
                <a href="<?php echo base_url();?>uploads/Route_Details_Upload_Template.xlsx" target="_blank">
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                    </button>
                </a>
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
        
        <!--------------For Bus & Routes---->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/bus/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('bus_details');?></div></td>
            <td>
                <a href="<?php echo base_url();?>uploads/Bus_Details_Upload_Template.xlsx" target="_blank">
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                    </button>
                </a>
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>
        
           <!------For bus_driver Details-->
        <tr>
        <?php echo form_open(base_url() . 'index.php?school_admin/bus_driver/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('bus_drivers');?></div></td>
            <td>
                <a href="<?php echo base_url();?>uploads/Bus_Driver_Upload_Template.xlsx" target="_blank">
                   <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                      data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                       <i class="fa fa-download"></i>
                   </button>
                </a>
            </td>
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('upload_and_import');?></button>
            </td>
        <?php echo form_close();?>
        </tr>    
        <!----For Marks Upload--->
        <tr>
        <?php //echo form_open(base_url() . 'index.php?school_admin/marks_bulk_upload/import_excel/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
        <?php echo form_open(base_url() . 'index.php?school_admin/view_marks_bulk_upload/' , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('Marks Details');?></div></td>
            <td>
                <?php /*<a href="<?php echo base_url();?>uploads/Marks_Upload_Template.xlsx" target="_blank">
                    <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                       data-placement="top" data-original-title="<?php echo get_phrase('download') ?>">
                        <i class="fa fa-download"></i>
                    </button>
                </a> */?>
            </td>
            <td>
                <div class="form-group">
                    <!--<input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>-->
                    
                </div>
            </td>
            <td>
                <button type="submit" class="fcbtn btn btn-danger btn-outline"><?php echo get_phrase('go_for_mark_bulk_upload');?></button>
            </td>
        <?php echo form_close();?>
        </tr>        
    </tbody>
</table>
</div>


