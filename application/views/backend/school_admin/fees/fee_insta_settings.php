<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_terms_settings'); ?> </h4></div>
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
        <?php echo form_open(base_url('index.php?fees/main/term_setting/'), array('class' => 'form-horizontal form-groups-bordered validate', 
        'target' => '_top')); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"><h5>Term Setting</h5></div>
                    <div class="ibox-content">
                        <?php if (!count($terms)){?>}
                            <div class="form-group  col-lg-12">
                                <span class="col-md-12 alert-danger">
                                    No Terms Added
                                </span>
                            </div>
                        <?php }?>
                        <div class="form-group col-lg-12">
                            <label class="col-lg-4" for="header_scripts"><?php echo get_phrase('school_fee_terms')?></label>
                            <span class="col-md-8">
                                <select multiple="true" id="tutionfee_installments" name="school_fee_terms[]" class="selectpicker" data-style="form-control" data-live-search="true">
                                    <?php foreach($terms as $ti=>$term){?>
                                        <option value="<?php echo $term->id?>" <?php echo in_array($term->id,$school_term_setting)?'selected':''?>>
                                            <?php echo $term->name?>
                                        </option>
                                    <?php }?>
                                </select>
                            </span>
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label class="col-lg-4" for="header_scripts"><?php echo get_phrase('hostel_fee_terms')?></label>
                            <span class="col-md-8">
                                <select multiple="true" id="hostelfee_installments" name="hostel_fee_terms[]" class="selectpicker" data-style="form-control" data-live-search="true">
                                    <?php foreach($terms as $ti=>$term){?>
                                        <option value="<?php echo $term->id?>" <?php echo in_array($term->id,$hostel_term_setting)?'selected':''?>>
                                            <?php echo $term->name?>
                                        </option>
                                    <?php }?>
                                </select>
                            </span>
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label class="col-lg-4" for="header_scripts"><?php echo get_phrase('transport_fee_terms')?></label>
                            <span class="col-md-8">
                                <select multiple="true" id="transpfee_installments" name="transport_fee_terms[]" class="selectpicker" data-style="form-control" data-live-search="true">
                                    <?php foreach($terms as $ti=>$term){?>
                                        <option value="<?php echo $term->id?>" <?php echo in_array($term->id,$transport_term_setting)?'selected':''?>>
                                            <?php echo $term->name?>
                                        </option>
                                    <?php }?>
                                </select>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ibox-title">
                    <h5><?php echo get_phrase('terms_available')?></h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered table-hover sys_table footable" data-page-size="50">
                        <tr>
                            <th>#</th>
                            <th>Term Name</th>
                            <th>No</th>
                            <th>School Fee</th>
                            <th>Hostel Fee</th>
                            <th>Transport Fee</th>
                        </tr>
                        <!-- {if $school_settings['academic_year']==''}
                            <tr>
                                <td colspan="6">{$r_year} Settings Not Added</td>
                            </tr>
                        {else}   -->  
                        <?php foreach($terms as $ti=>$term){?>
                            <tr>
                                <td><?php echo $ti+1?></td>
                                <td><?php echo $term->name?></td>
                                <td><?php echo $term->term_num?></td>
                                <td><?php echo in_array($term->id,$school_term_setting)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'?></td>
                                <td><?php echo in_array($term->id,$hostel_term_setting)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'?></td>
                                <td><?php echo in_array($term->id,$transport_term_setting)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'?></td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
            </div>
        </div>
        <br/>

        <div class="form-group">
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close()?>   
    </div>
</div>
<script>
$('.chkbox').on('change',function(){
    row = $(this).closest('.row');
    if(this.checked){
        row.find('.head-box').removeAttr('disabled','disabled');
    }else{
        row.find('.head-box').val('');
        row.find('.head-box').attr('disabled','disabled');
    }
});
</script>