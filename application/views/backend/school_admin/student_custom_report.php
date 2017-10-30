  <div class="row bg-title">    
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Overview_Reports'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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
    <!-- /.breadcrumb -->
</div>   
<!--<div class="row">
    <div class="col-md-12">
        <div class="white-box">
        <a data-toggle="collapse" href="#collapse1" class="collapsed">  </a><span id="tot"></span></h3>
        
        </div>
    </div>
</div>-->
        
      <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a class="head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                                <b><?php echo get_phrase('Student');?></b>&nbsp;&nbsp;<span id="tot"></span>
                            </a>
                        </h4>
                    </div> 
                </div>
            </div>
        </div>
      </div>

        <section id="collapse1">
            <div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('You_can_check_mark_the_required_fields_and_submit_to_get_the_custom_report.');?>" data-position="top">
                <div class="text-right"> <input type="checkbox" value="all" id="CheckAll" class="js-switch" data-color="#99d683" />
    <label><?php echo get_phrase('All'); ?></label>
                </div>
                 <div class="tab-pane active" id="home">
                <?php echo form_open(base_url() . 'index.php?admin_report/student_custom_report/', array('class' => 'form-groups-bordered', 'id' => 'StudentCustomReport')); if(count($filter_fields)){?>
                <div class="row"><?php foreach($filter_fields as $k => $row){?>
                    <div class="col-sm-4 col-xs-12">
                        <div>
                            <label><input type="checkbox" value="<?php echo $k;?>" name="<?php echo $k;?>" <?php if(in_array($k, $filter_keys)){echo 'checked';}?> ><?php echo ' '.$row; ?></label>
                        </div>
                    </div> <?php }?> 
                </div><?php }?>  
                     <div class="text-right">
                         <button type="reset" value="Reset" class="fcbtn btn btn-danger btn-outline btn-1d" id="reset">Reset</button>&nbsp;&nbsp;
                         <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="filter_submit">Submit</button>                     
           </div>
                </div>
            </div>                     
        </div>
</div>    
        </section>
            
<?php echo form_close(); if(count($custom_report_data) && count($filter_keys)){ $n =1;?>
        <table class="table table-bordered datatable" id="table_export">
            <thead>
                <tr>
                    <th><div>Sl No.</div></th>
<?php foreach($filter_fields as $k => $row){ if(in_array($k, $filter_keys)){?>
                    <th><div><?php echo $row;?></div></th><?php }}?>                             
                </tr>
            </thead>
            <tbody><?php foreach ($custom_report_data as $row): ?>
                <tr>
                    <td><?php echo $n++;?></td><?php foreach($filter_keys as $fields){ ?>
                    <td><?php echo $row[$fields];?></td><?php }?>                       
                </tr><?php endforeach;  ?>                        
            </tbody>
        </table> <?php }?>
        
    </div>
    

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    $(document).ready(function() {

        var total_checked= '<?php echo count($filter_keys)?>';        
        if(total_checked > 0){
            $('#tot').html('('+total_checked+')');
        }else{
            $('#tot').empty();
        }
        
        $('#collapse1 > div > div > div > div.text-right > span').click(function(){

            if($('#StudentCustomReport > div.row > div > div > label > input[type="checkbox"]').is(':checked')){
                $('input:checkbox').prop('checked', false);    
            }else{
                $('input:checkbox').prop('checked', true);                
            }

            var count = $("#StudentCustomReport input:checkbox:checked").length;
            if(count > 0){
                $('#tot').html('('+count+')');
            }else{
                $('#tot').empty();
            }
        });
        
        $('input:checkbox').click(function(){
            var count = $("#StudentCustomReport input:checkbox:checked").length;
            if(count > 0){
                $('#tot').html('('+count+')');
            }else{
                $('#tot').empty();
            }

        });
        
        $("#filter_submit").click(function(){
            $('#StudentCustomReport').submit();
        });
        
        $("#reset").click(function(){
            $('input:checkbox').attr('checked', false);
            $('#tot').empty();
        });

        var datatable = $("#table_export").dataTable({
            rowReorder: {
                    selector: 'td:nth-child(2)'
                    },
            responsive: true,

            dom: 'Bfrtip',
            buttons: [
                'pageLength',

                {
                    extend: 'excel',
                    footer: true,
                    exportOptions: {                      
                          columns: ['<?php $t= count($filter_keys); for($i=1; $i <= $t; $i++){ echo $i; if($i < $t){  echo ',';} } ?>']
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: ['<?php $t= count($filter_keys); for($i=1; $i <= $t; $i++){ echo $i; if($i < $t){  echo ',';} } ?>']
                    }
                },
                 {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: ['<?php $t= count($filter_keys); for($i=1; $i <= $t; $i++){ echo $i; if($i < $t){  echo ',';} } ?>']
                    }
                },

            ]
        } );
    } );
</script>
