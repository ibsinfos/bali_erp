<style type="text/css">
    .user_type_outer{display: none;}
</style>
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

<?php echo form_open(base_url() . 'index.php?super_admin/permission/create'); ?>
<div class="row m-0">
<div class="col-xs-12 white-box">
    <div class="col-xs-12 col-md-4 form-group">
        <label for="field-2"><?php echo get_phrase('school'); ?><span class="error mandatory"> *</span></label>
        <select name="school_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required" onchange="GetUserType(this.value);" id="school_id">
            <option value=""><?php echo get_phrase('select_school'); ?></option>
<?php foreach ($school as $row): ?>
            <option value="<?php echo $row['school_id']; ?>" <?php if($this->uri->segment(5)==$row['school_id']){ echo 'selected';}?>><?php echo ucwords($row['name']); ?></option><?php endforeach; ?>
        </select>
    </div>

    <div class="col-xs-12 col-md-4 form-group">
        <label class="control-label">Select Role</label>
        <select  data-style="form-control" data-live-search="true" class="selectpicker" id="role_id" name="role_id" onchange="GetRolePermission()">
            <option value="">Select</option><?php if(count($roles)){ foreach($roles as $role){ ?>
            <option value="<?php echo $role['id'];?>" <?php if($this->uri->segment(3)==$role['id']){ echo 'selected';}?>><?php echo ucwords($role['name']);?></option><?php  } } ?>
        </select>
    </div>

    <div class="col-xs-12 col-md-4 form-group <?php if($this->uri->segment(4)==''){echo 'user_type_outer';}?>">
        <label class="control-label">Select User Type</label>
        <select class="selectpicker" data-style="form-control" id="user_type" data-live-search="true" onchange="GetRolePermission()" name="user_type">
            <option value="">Select</option>
            <option value="A" <?php if($this->uri->segment(4)=='A'){echo 'selected';}?>>Admin</option>
            <option value="T" <?php if($this->uri->segment(4)=='T'){echo 'selected';}?>>Teacher</option>
            <option value="P" <?php if($this->uri->segment(4)=='P'){echo 'selected';}?>>Parent</option>
            <option value="S" <?php if($this->uri->segment(4)=='S'){echo 'selected';}?>>Student</option>
            <option value="SA" <?php if($this->uri->segment(4)=='SA'){echo 'selected';}?>>School Admin</option>
            <option value="ACCT" <?php if($this->uri->segment(4)=='ACCT'){echo 'selected';}?>>Accountant</option>
            <option value="CASH" <?php if($this->uri->segment(4)=='CASH'){echo 'selected';}?>>Cashier</option>
        </select>
    </div>
</div>
    </div>

<?php if(isset($data) && count($data)){?>

<div class="col-md-12 white-box"><?php $i =1; foreach($data as $datum){ ?>
    <div class="checkbox checkbox-danger col-md-offset-1">
        <input type="checkbox" name="link_id[]" value="<?php echo $datum['id'];?>" <?php if(isset($exist_role_link_data)){ if(in_array($datum['id'], $exist_role_link_data)){ echo 'checked';}}?> class="par_<?php echo $i;?>">
        <label><b><?php echo ucfirst($datum['name']); ?></b></label>
       <?php if(count($datum['link_data'])){ foreach($datum['link_data'] as $link_datum){?>
            <div class="checkbox checkbox-danger col-md-offset-1">
                <input type="checkbox" name="link_id[]" value="<?php echo $link_datum['id']; ?>" <?php if(isset($exist_role_link_data)){ if(in_array($link_datum['id'], $exist_role_link_data)){ echo 'checked';}}?> class="par_<?php echo $i.'child';?>">
                <label><?php echo ucfirst($link_datum['name']); ?></label>
            </div>
            <br/><?php }}?>
    </div><hr/><?php $i++;}?>

    <div class="text-right col-xs-12 p-t-20">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="assign_role"><?php echo get_phrase('Save'); ?></button>
    </div>

</div><?php }?>

<?php echo form_close(); ?>

<script type="text/javascript">
    function GetRolePermission(){
        var UserRole = $('#role_id').val();
        if(UserRole!=''){
            $('.user_type_outer').show();
        }else{
            $('.user_type_outer').hide();
        }
        var UserType = $('#user_type').val();

        var school_id = $('#school_id').val();

        if((UserRole!='') && (UserType!='') && (school_id!='')){
            var url ='<?php echo base_url(); ?>index.php?super_admin/permission/'+UserRole+'/'+UserType+'/'+school_id;
            window.location.href = url; 
        }
    }

    $('#page-wrapper :checkbox').change(function() {  
        var MyClass = $(this).attr("class");
        var ExpMyClass = MyClass.split('_');
        if (this.checked) {
            $('.par'+'_'+ExpMyClass[1]+'child').click();
        } else {
            $('.par'+'_'+ExpMyClass[1]+'child').click();
        }
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
                                school+='<option value="'+data[k]['id']+'">'+data[k]['name']+'</option>';
                            }
                        }else{
                            alert('No any user role is created for this school.');
                        }                 
                    }else{
                        alert('No any user role is created for this school.');
                    }
                    $('#role_id').empty();
                    $('#role_id').html(school).selectpicker('refresh'); 
                    GetRolePermission();
                },
                error: function(){
                    alert('No any user role is created for this school.');
                    $('#role_id').empty();
                    $('#role_id').html(school).selectpicker('refresh');
                }
            });
        }
    }

</script>