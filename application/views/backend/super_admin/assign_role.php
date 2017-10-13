<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <a href="student_information.php"></a>
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>

<?php echo form_open(base_url() . 'index.php?super_admin/assign_role/create'); ?>

<div class="row">
    <div class="col-xs-12 col-md-6 form-group">
        <label for="field-2"><?php echo get_phrase('school'); ?><span class="error mandatory"> *</span></label>
        <select name="school_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required" onchange="GetUserType(this.value);">
            <option value=""><?php echo get_phrase('select_school'); ?></option>
<?php foreach ($school as $row): ?>
            <option value="<?php echo $row['school_id']; ?>" <?php if($this->uri->segment(4)==$row['school_id']){ echo 'selected';}?>><?php echo ucwords($row['name']); ?></option><?php endforeach; ?>
        </select>
    </div>

    <div class="col-xs-12 col-md-6 form-group">
        <label class="control-label">Select User Type</label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value" name="original_user_type" id="original_user_type">
            <option value="">Select</option>
<?php if(count($roles)){ foreach($roles as $role){ ?>
                <option value="<?php echo base_url().'index.php?super_admin/assign_role/'.$role['id'].'/'.$this->uri->segment(4);?>" <?php if($this->uri->segment(3)==$role['id']){ echo 'selected';}?> ><?php echo ucwords($role['name']);?></option>
<?php }}?>            
        </select>
    </div>
</div>


<?php if(isset($data)){?>

<?php if ($this->session->flashdata('flash_message_error')) { ?>        
<div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
</div>
<?php } ?>
<div class="col-md-12 white-box">
    <div class="table-responsive">
        <table class="display nowrap" cellspacing="0" width="100%" id="SkipPagination">
            <thead>
                <tr>
                    <th><div><input type="checkbox">&nbsp;&nbsp;<?php echo get_phrase('select_all'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('email'); ?></div></th>
                    <th><div><?php echo get_phrase('phone'); ?></div></th>
                    <th><div><?php echo get_phrase('assign_role'); ?></div></th>
                </tr>
            </thead>

            <tbody><?php
            $n=1; if(count($data)){ foreach($data as $datum){
                if(isset($datum['school_admin_id']) && $datum['school_admin_id'] > 0) {
                    $datum['id'] = $datum['school_admin_id'];
                }
                ?>
                <tr>
                    <td><input type="checkbox" name="assigned_user[]" value="<?php echo $datum['id']; ?>" <?php if(isset($datum['role_id']) && $datum['role_id'] !=''){ echo 'checked'; } ?> class="checkboxall"></td>
                    <td><?php echo ucwords((@$datum['fname']!='' ? @$datum['fname'] : (@$datum['mname']!='' ? ' '.@$datum['mname'] : (@$datum['lname']!='' ? ' '.@$datum['lname'] : '')))); ?></td>
                    <td><?php echo $datum['email']; ?></td>
                    <td><?php echo @$datum['cell_phone']; ?></td>
                    <td>
                        <select class="col-md-12 selectpicker" data-style="form-control" data-live-search="true" name="assign_role[<?php echo $datum['id'];?>]">
<?php if(count($roles)){ if($datum['role_id']!=''){ foreach($roles as $role){ ?>
                            <option value="<?php echo $role['id'];?>" <?php if($datum['role_id']==$role['id']){ echo 'selected';}?> ><?php echo ucwords($role['name']);?></option>
<?php }}else{ foreach($roles as $role){ ?>
                            <option value="<?php echo $role['id'];?>" <?php if($this->uri->segment(3)==$role['id']){ echo 'selected';} ?> ><?php echo ucwords($role['name']); ?></option><?php }}} ?>
                        </select>
                    </td>
                </tr><?php }} ?>
            </tbody>
        </table>
        <div class="text-right col-xs-12 p-t-20">
            <button class="fcbtn btn btn-danger btn-outline btn-1d" id="assign_role"><?php echo get_phrase('assign_role'); ?></button>
        </div>
    </div>
</div><?php }?>

<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#SkipPagination thead div input[type="checkbox"]').click(function(){
            if(this.checked){
                $('.checkboxall').each(function(){
                    this.checked = true;
                })
            }else{
                $('.checkboxall').each(function(){
                    this.checked = false;
                })
            }
        });


        $('#SkipPagination').DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "bPaginate": false,
        });
    });

    function GetUserType(school_id=''){
        if(school_id!=''){
            var school = '<option value="">Select</option>';
            $.ajax({
                url : '<?php echo base_url();?>index.php?ajax_controller/get_user_type',
                type: 'POST',
                data :{school_id: school_id},
                success: function(response){
                    debugger;
                    if(response){
                        data = JSON.parse(response);
                        if(data.length){
                            for(k in data){
                                school+='<option value="<?php echo base_url();?>index.php?super_admin/assign_role/'+data[k]['id']+'/'+data[k]['school_id']+'">'+data[k]['name']+'</option>';
                            }
                        }else{
                            alert('No any user role is created for this school.');
                        }                 
                    }else{
                        alert('No any user role is created for this school.');
                    }
                    $('#original_user_type').empty();
                    $('#original_user_type').html(school).selectpicker('refresh'); 
                },
                error: function(){
                    alert('No any user role is created for this school.');
                    $('#original_user_type').empty();
                    $('#original_user_type').html(school).selectpicker('refresh');
                }
            });
        }
    }
</script>