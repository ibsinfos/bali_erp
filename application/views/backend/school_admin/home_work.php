<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
           
  
     <?php
     $msg=$this->session->flashdata('flash_message_error');
     if ($msg) { ?>        
        <div class="alert alert-danger">
            <?php echo $msg; ?>
        </div>
    <?php } ?>
    <div class="white-box">        
        <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="section1">
                        <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="<?php echo get_phrase('You can see list of home work type.');?>" data-position='right'><span><?php echo get_phrase('home_work_types'); ?></span></a></li>
                    <li id="section2">
                        <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('Form here you will add a home work type.');?>" data-position='left'><span><?php echo get_phrase('add_home_work_type'); ?></span></a></li>

                </ul>
            </nav>                                    
            <div class="content-wrap">
                <section id="section-flip-1">
               
                <table id="example23" class="table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('no'); ?></div></th>
                            <th><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase('description'); ?></div></th>
                            <!--<th><div><?php echo get_phrase('no_of_home_works'); ?></div></th>-->
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(!empty($homework_types)) {
                            $count  =   1;
                            foreach($homework_types as $key=>$row) { ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['type_name'];?></td>
                                <td><?php echo $row['discriptions'];?></td>
                                <!--<td><?php echo $row['no_of_works'];?></td>-->
                                <td>
                                    <?php  if($row['type'] !=1) { ?>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/home_works/delete/<?php echo $row['homework_typeid']; ?>');">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                    </a>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php    
                            }
                        } else { ?>
                            
                            
                       <?php  }
                       ?>
                    </tbody>
                </table>
               
                </section>
                
                <section id="section-flip-2">
                    <?php echo form_open(base_url() . 'index.php?school_admin/home_works/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-cutlery"></i></div>
                                <input type="text" class="form-control" required="required" data-validate="required"  name="name" placeholder="<?php echo get_phrase('name'); ?>"> 
                            </div>
                             <label class="mandatory"> <?php echo form_error('name'); ?></label>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-text-height"></i></div>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <label> <?php echo form_error('description'); ?></label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                    </div>
                    <?php echo form_close(); ?> 
                </section>             
            </div>
        </div>
        </section>
    </div>
<script>
    $(document).ready(function(){
    if(<?php echo(form_error('name')||form_error('name_numeric')||form_error('teacher_id'))?>){
    $('#section-flip-2').addClass('content-current');
    $('#section-flip-1').removeClass('content-current');
    $('#section2').addClass('tab-current');
    $('#section1').removeClass('tab-current');
}    

    });

</script>
<script type="text/javascript">
//    var table;
//
//    $(document).ready(function() {
//
//        //var SearchName = $('#PublicSearch').val();
//
//        //datatables
//        table = $('#table').DataTable({ 
//
//            "dom": 'Bfrtip',
//            "responsive": true,
//            "buttons": [
//                "pageLength",
//                'copy', 'excel', 'pdf', 'print'
//            ],
//
//            "processing": true, //Feature control the processing indicator.
//            "serverSide": true, //Feature control DataTables' server-side processing mode.
//            "order": [], //Initial no order.
//
//            // Load data for the table's content from an Ajax source
//       
//            "ajax": {
//                "url": "<?php echo base_url().'index.php?ajax_controller/mess_details_admin_login/';?>",
//                "type": "POST"
//            },
//
//            //Set column definition initialisation properties.
//            "columnDefs": [
//                { "targets": [0], "orderable": false },                 
//            ],
//
//        });
//        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
//
//        /*if(SearchName!=''){            
//            table.search(SearchName).draw();
//        }*/
//    });
//    
</script>