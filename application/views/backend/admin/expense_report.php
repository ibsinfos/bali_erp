<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Student common Report'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 white-box">    
        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                <th><div><?php echo get_phrase('sl_no.');?></div></th>
                <th><div><?php echo get_phrase('Account'); ?></div></th> 
                <th><div><?php echo get_phrase('Total Expense'); ?></div></th>
          </tr>
            </thead>
            <tbody> 
                <?php 
                $n = 1;  
                if(count($res)>0){
                    foreach ($res as $row){   ?>
                        <tr>
                            <td><?php echo $n++;?></td>
                            <td><?php echo $row['account']; ?></td>
                            <td><?php echo $row['dr']; ?></td>
                            
                        </tr>
                    <?php }
                }?>
            </tbody>
       </table>
    </div>                     
</div>
<script type="text/javascript">
    
    function select_class(school_id) { 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
            success:function (response){//alert(response);
                jQuery('#class_holder').html(response);
            }
        });
    }
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#section_holder').html(response);
            }
        });
    }
</script>