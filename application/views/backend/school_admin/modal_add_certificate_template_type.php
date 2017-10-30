<style type="text/css">
    .tabs-style-flip{
        overflow: visible;
    }
    .content-wrap section {
        display: none;
        margin: 0 auto;
        padding: 25px;
        min-height: 300px;
    }
   
</style>
<?php // pre($certificate_type_list); die; ?>
<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">   
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('template_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_template_in_certificate'); ?></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('s._No.'); ?></div></th>
                                        <th><div><?php echo get_phrase('template_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('action'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; foreach ($certificate_template_merge_list as $row): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['template_name']; ?></td>
                                        <td><a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/add_template_inCertificate_type/delete/<?php echo $row['certificate_template_merge_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </section>                        
                        <section id="add" style="height: 50%"> 
                             <?php echo form_open(base_url() . 'index.php?school_admin/add_template_inCertificate_type/create', array('id'=>'merge_template', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?> 
                            <?php // pre($certificate_template_list);  ?>
                               <input type="hidden" name="certificate_type_id" value="<?php echo $certificate_type_id;?>" >
                                <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="field-1"><?php echo get_phrase('certificate_type'); ?><span class="mandatory"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-file"></i></div>
                                        <select name="template_type[]" id="template_type" class="selectpicker1" multiple data-style="form-control" data-live-search="true" data-actions-box="true" required="" style="overflow:visible; z-index: 9999;">
                                          <?php
                                            foreach ($certificate_template_list as $row): ?>
                                            <option value="<?php echo $row['certificate_template_type_id']; ?>"><?php echo $row['template_name']; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <label class="mandatory"> <?php echo form_error('template_type'); ?></label>
                                </div>
                                </div> 
                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id=""><?php echo get_phrase('add_certificate_template_type'); ?></button>
                                    <!--<input type="submit" value="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="">-->
                                </div>
                    </form>
                        </section>
                         </div>
                            </div>               
                    </div>
                </div>
<script type="text/javascript">
   (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });

        <?php if($param2=='cce'){?>
                $('#cce').show();  
        <?php }else{?>
            $('#cce').hide();
            $('#cce_outer').removeClass('tab-current');<?php }?>
        
    })();

    $('#example_cce').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>