<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>

</style>
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_classes');?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
   
<?php $msg=$this->session->flashdata('flash_message_error');
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
                    <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="<?php echo get_phrase('Here you can see class list.');?>" data-position='right'><span>
                    <?php echo get_phrase('class_list'); ?></span></a>
                </li>
                <li id="section2">
                    <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('From here you can add a class.');?>" data-position='left'><span>
                    <?php echo get_phrase('add_class'); ?></span></a>
                </li>
                <li id="section3">
                    <a href="#section-flip-3" class="sticon fa fa-bars" data-step="7" data-intro="<?php echo get_phrase('From here you can order classes.');?>" data-position='left'><span>
                    <?php echo get_phrase('manage_order'); ?></span></a>
                </li>
            </ul>
        </nav>                                    
        <div class="content-wrap">
            <section id="section-flip-1">
                <table id="table" class="table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('no'); ?></div></th>
                            <th><div><?php echo get_phrase('class_name'); ?></div></th>
                            <!--<th><div><?php //echo get_phrase('class_teacher');?></div></th>-->
                            <th><div data-step="8" data-intro="<?php echo get_phrase('You can edit or delete a class from here.');?>" data-position='left'><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </section>

            <section id="section-flip-2">
                <?php echo form_open(base_url() . 'index.php?school_admin/classes/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-book"></i></div>
                            <input type="text" class="form-control" data-validate="required"  name="name" placeholder="Class Name"> 
                        </div>
                        <label class="mandatory"> <?php echo form_error('name'); ?></label>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('name_numeric'); ?><span class="mandatory"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-list-ol"></i></div>
                            <input type="text" class="form-control" name="name_numeric" placeholder="Numeric Value" > 
                        </div>
                        <label class="mandatory"> <?php echo form_error('name_numeric'); ?></label>
                    </div>
                </div>
        
                <div class="row">  
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('teacher'); ?><span class="mandatory"> *</span></label>
                        <select data-container="body" class="selectpicker" data-style="form-control" name="teacher_id" data-live-search="true">                                    
                            <option value=""><?php echo get_phrase('select_teachers'); ?></option>
                            <?php foreach ($teachers as $row): ?>
                                <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['name']." ".$row['last_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="mandatory"> <?php echo form_error('teacher_id'); ?></label>
                    </div>
                </div>         
    
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_class'); ?></button>
                </div>
                <?php echo form_close(); ?> 
            </section>             

            <!--<section id="section-flip-3">
                <ul id="sortable2" class="connectedSortable text-center">
                    <?php /* $count = 1; foreach ($classes_record as $row): ?>
                        <li id="<?php echo $row['class_id'];?>" class="badge badge-danger">
                           <?php echo $row['name'];?>
                        </li>
                    <?php endforeach; */?>
                </ul>
            </section>-->
            <section id="section-flip-3">
                <ul id="sortable2" class="connectedSortable">
                    <?php $count = 1; foreach ($classes_record as $row): ?>
                        <li id="<?php echo $row['class_id'];?>" class="ui-state-highlight">
                            <i class="fa fa-bars"></i> <?php echo $row['name'];?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
    </div>
    </section>
</div>
<script>
var table;
$(document).ready(function(){
     if(<?php echo(form_error('name')||form_error('name_numeric')||form_error('teacher_id'))?1:0?>){
        $('#section-flip-2').addClass('content-current');
        $('#section-flip-1').removeClass('content-current');
        $('#section2').addClass('tab-current');
        $('#section1').removeClass('tab-current');
    }  
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    //var SearchName = $('#PublicSearch').val();
    //datatables
    table = $('#table').DataTable({ 
        "dom": 'Bfrtip',
        "responsive": true,
        "buttons": [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ],

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
    
        "ajax": {
            "url": "<?php echo base_url().'index.php?ajax_controller/get_class_list/';?>",
            "type": "POST",
            "dataSrc": function (data) {
                setTimeout(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }, 0);
                return data.data;
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            { "targets": [2], "orderable": false },                 
        ],
       

    });
    //table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

    /*if(SearchName!=''){            
        table.search(SearchName).draw();
    }*/

    $('#sortable2').sortable({
        update: function(event, ui) {
            var newOrder = $(this).sortable('toArray').toString();
            $.post('<?php echo base_url(); ?>index.php?school_admin/save_class_order', {order:newOrder});
        }
    });
});
</script>