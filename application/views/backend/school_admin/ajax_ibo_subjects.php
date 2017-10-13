<div class="row">
    <div class="col-md-12">        
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                <!------CONTROL TABS START------>
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('subject_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_subjects'); ?></a></li>
                        </ul>
                    </nav>
                <!------CONTROL TABS END------>

                    <div class="content-wrap">
                <!----TABLE LISTING STARTS-->
                        <section id="list">
                            <table class="table table-hover manage-u-table table_edjust" id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('NO'); ?></div></th>
                                        <th><div><?php echo get_phrase('subject_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('weekly_classes'); ?></div></th>
                                        <th><div><?php echo get_phrase('sixth_subject'); ?></div></th>
                                        <th><div><?php echo get_phrase('asl'); ?></div></th>
                                        <th><div><?php echo get_phrase('no_exam_subject'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; if(count($subjects)){ foreach ($subjects as $row): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['weekly_classes']; ?></td>
                                        <td><?php if( $row['sixth_subject'])
                                                    echo "Yes";
                                                  else
                                                      echo 'No';?></td>
                                        <td><?php if( $row['asl'])
                                                    echo "Yes";
                                                  else
                                                      echo 'No';?></td>
                                        <td><?php if( $row['no_exam'])
                                                    echo "Yes";
                                                  else
                                                      echo 'No';?></td>
                                        <td>
                                            
											<!-- edit -->
                                            <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_cce_subject/<?php echo $row['subject_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Class" title="Edit Class"><i class="fa fa-pencil-square-o"></i></button>
											</a>

											<!-- delete -->
											<a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/cce_subjects/delete/<?php echo $row['subject_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Class" title="Delete Class"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                            
                                        </td>
                                </tr><?php endforeach; } ?>
                                </tbody>
                            </table>
                        </section>
            <!----TABLE LISTING ENDS--->

            <!----CREATION FORM STARTS---->
                        <section id="add">
                            <?php echo form_open(base_url() . 'index.php?school_admin/ibo_subjects/'.$cce_class_id.'/add', array('id'=>'subject_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                                <table class="table table-hover manage-u-table">
                                    <thead>
                                        <tr>
                                            <th><div>#</div></th>
                                            <th><div><?php echo get_phrase('subject_name'); ?></div></th>
                                            <th><div><?php echo get_phrase('weekly_classes'); ?>
                                                <span class="error" style="color: red;"> *
                                            </span>
                                            </div></th>
                                            <th><div><?php echo get_phrase('sixth_subject'); ?></div></th>
                                            <th><div><?php echo get_phrase('asl'); ?></div></th>
                                            <th><div><?php echo get_phrase('no_exam_subject'); ?></div></th>                                            </tr>
                                    </thead>
                                    <tbody>
<?php $cce_subject_id=array(); if(count($subjects)){ foreach ($subjects as $row){ $cce_subject_id[]=$row['subject_id'];}} if(count($class_subjects)){ foreach ($class_subjects as $row): if(!in_array($row['subject_id'], $cce_subject_id)){ ?>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="col-sm-5">
                                                        <div class="checkbox-danger"><input type="checkbox" onclick="handleClick(this)" name="selected_subject[]" id="subject_check<?php echo $row['subject_id'];?>" value="<?php echo $row['subject_id'];?>"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $row['name'];?></td>
                                            <td><input type="text" disabled name="selected_weekly_classes[]" id="weekly<?php echo $row['subject_id'];?>" value="" class="form-control" onkeypress="return isNumber(event)" required/></td>
                                            <td>
                                                <div class="checkbox-danger"><input type="checkbox" disabled id="sixth<?php echo $row['subject_id'];?>" disabled name="selected_sixth_subject[]" value="<?php echo $row['subject_id'];?>"></div>
                                            </td>
                                            <td>
                                                <div class="checkbox-danger"><input type="checkbox" disabled id="asl<?php echo $row['subject_id'];?>" disabled name="selected_asl[]" value="<?php echo $row['subject_id'];?>"></div>    
                                            <td>                                            
                                                <div class="checkbox-danger"><input type="checkbox" id="no<?php echo $row['subject_id'];?>" disabled name="selected_no_exam[]" value="<?php echo $row['subject_id'];?>"></div>                                
                                            </td>
                                    </tr><?php } endforeach; }?>
                                   </tbody>
                                </table>
                            
                                <div class="text-right">
                                    <button type="submit" id="add_subject" disabled="disabled" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_subjects'); ?></button>
                                </div>       
                        </section>
                    </div>
                </div>
            </section>        
            <!----CREATION FORM ENDS-->
        </div>
    </div>
</div>
<script type="text/javascript">
function handleClick(cb) {
  if(cb.checked)
  {
      
       $('#weekly'+cb.value).prop('disabled', false);
       $('#weekly'+cb.value).prop('required', true);
       $('#asl'+cb.value).prop('disabled', false);
       $('#no'+cb.value).prop('disabled', false);
       $('#sixth'+cb.value).prop('disabled', false);
       $('#add_subject').prop("disabled", false);
       $('#Form_no'+cb.value).prop('name', "form_no[]");
  }
  else
  {
       $('#weekly'+cb.value).prop('disabled', true);
       $('#weekly'+cb.value).prop('required', false);
       $('#asl'+cb.value).prop('disabled', true);
       $('#no'+cb.value).prop('disabled', true);
       $('#add_subject').prop("disabled", true);
       $('#sixth'+cb.value).prop('disabled', true);
  }
} 

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

(function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
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