<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <div>
                <section id="add">
                    <?php foreach($programs as $row): ?>
                    <div class="form-horizontal form-material">
                        <?php echo form_open(base_url() . 'index.php?school_admin/ibo_program/update/'.$row['program_id'], array('id'=>'program_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                            <?php echo get_phrase('program_name'); ?>
                            <span class="error" style="color: red;"> *</span>
                            </label>
                            
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="program_name" value="<?php echo $row['program_name'];?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="text-right">
                                <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d">
                                <?php echo get_phrase('update'); ?>
                                </button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <?php endforeach; ?>
                </section>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function handleClick() {

       $('form#program_add').submit();
    }
    

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });

</script>