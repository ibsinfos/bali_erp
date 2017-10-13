<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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
    <!-- /.breadcrumb -->
</div>
<?php     
if($this->session->flashdata('flash_message_error')) {?>        
<div class="alert alert-danger">
<?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>


<div class="row" >   
    <div class="col-md-12 p-b-20">
         <div class="form-group">      
        <a data-step="5" data-intro="<?php echo get_phrase('You can allocate transport to student from here');?>" data-position='left' href="<?php echo base_url(); ?>index.php?school_admin/student_bus_allocation/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Allocate Bus">
           <i class="fa fa-plus"></i>
            </a>      
         </div>
    </div>
</div>


<div class="col-sm-12 white-box" data-step="6" data-intro="<?php echo get_phrase('You can see the transportation details of students from here');?>" data-position='top'> 
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
<!----TABLE LISTING STARTS-->
        <thead>
            <tr>
                <th><div><?php echo get_phrase('No.'); ?></div></th>
                <th><div><?php echo get_phrase('enroll_code'); ?></div></th>
                <th><div><?php echo get_phrase('student_name'); ?></div></th>
                <th><div><?php echo get_phrase('class'); ?></div></th>
                <th><div><?php echo get_phrase('section'); ?></div></th>
                <th><div><?php echo get_phrase('route'); ?></div></th>
                <th><div><?php echo get_phrase('bus'); ?></div></th>
                <th><div><?php echo get_phrase('start_date'); ?></div></th>
                <th><div><?php echo get_phrase('end_date'); ?></div></th>
                <th><div data-step="7" data-intro="<?php echo get_phrase('You can edit or delete transport allocated to student from here');?>" data-position='left'><?php echo get_phrase('options'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;
            foreach ($student_details as $value){
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $value['enroll_code']; ?></td>
                    <td><?php echo $value['student_name']; ?></td>
                    <td><?php echo $value['class_name']; ?></td>
                    <td><?php echo $value['section_name']; ?></td>
                    <td><?php echo $value['route_name']; ?></td>
                    <td><?php echo $value['bus_name']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($value['start_date'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($value['end_date'])); ?></td>
                     <td>                        
                        <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_student_bus/<?php echo $value['student_bus_id']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="<?php echo get_phrase('edit') ?>" title="<?php echo get_phrase('edit') ?>">  
                            <i class="fa fa-pencil-square-o"></i>
                        </button>
                        </a>
                        <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/student_bus/delete/<?php echo $value['student_bus_id']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="<?php echo get_phrase('delete') ?>" title="<?php echo get_phrase('delete') ?>">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!----TABLE LISTING ENDS--->
</div>

        


