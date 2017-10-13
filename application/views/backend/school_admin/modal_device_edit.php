<?php if (!empty($rs)){ ?>
<div class="modal-body">
    <?php echo form_open(base_url() . 'index.php?school_admin/device/do_update/'.$rs[0]->Device_ID , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add Device Name</label>
            <input type="text" class="form-control" name="Name" required value="<?php echo $rs[0]->Name;?>" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add IMEI Number</label>
            <input type="text" class="form-control" name="Imei" required value="<?php echo $rs[0]->Imei;?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add SIM Number</label>
            <input type="text" class="form-control" name="SIM" required value="<?php echo $rs[0]->SIM;?>">
            </div>
        </div>
        <div class="col-sm-12 m-b-20">
            <label>Select Location</label>
            <?php
            $deviceLocationData = array(
                'india' => 'India',
                'dubai' => 'Dubai',
                'saudi_aribia' => 'Saudi Arabia'
            );  ?>
            <select class="selectpicker1" data-style="form-control" data-live-search="true" name="Location" id="Location" >
                <?php foreach($deviceLocationData as $k=> $v){?>
                <option value="<?php echo $k;?>" <?php if($k==$rs[0]->Location){?>selected<?php }?>><?php echo $v;?></option>
                <?php }?>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_device');?></button>
        </div>
    </div>
    <?php echo form_close();?>
<?php } ?>
</div>
