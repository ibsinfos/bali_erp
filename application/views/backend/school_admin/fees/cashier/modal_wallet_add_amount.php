<?php if($wallet) {?>
    <div class="row m-0">
        <div class="col-md-12"> 
        <?php echo form_open(base_url('index.php?fees/main/wallet_add_amount/'.$wallet->id), 
                array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target'=>'_top')); ?>
        <div class="form-horizontal form-material">
            <div class="row">
                <div class="col-xs-12">
                    <label for="running_session"><?php echo get_phrase('wallet_holder'); ?></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                        <input type="text" class="form-control" value="<?php echo $wallet->parent_name?>" readonly/> 
                    </div>
                </div>
            </div>
            <br/>

            <div class="row">          
                <div class="col-xs-12">
                    <label for="field-1"><?php echo get_phrase('add_amount');?><span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                        <input type="number" class="form-control no-neg" name="amount" min="0"/> 
                    </div>
                </div> 
            </div>
            <br/>
                    
            <div class="form-group">
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                </div>
            </div>
        </div>            
        <?php echo form_close(); ?>	   
        </div>    
    </div> 
<?php }?>          

<script type="text/javascript">
$(document).ready(function () {
});
</script>




