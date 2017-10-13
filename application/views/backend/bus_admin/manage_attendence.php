<?php echo form_open(base_url() . 'index.php?bus_admin/driver_attendence_view'); ?>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_driver'); ?></label>
            <select name="driver_id" class="form-control selectboxit">
                <option value=""><?php echo get_phrase('select_driver'); ?></option>
                <?php foreach ($list_drivers as $list_driver): ?>
                <option value="<?php echo $list_driver['bus_driver_id']; ?>"><?php echo $list_driver['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_month'); ?></label>
            <select name="month" class="form-control selectboxit" id="month">
                <?php
                for ($i = 1; $i <= 12; $i++):
                    if ($i == 1)
                        $m = 'january';
                    else if ($i == 2)
                        $m = 'february';
                    else if ($i == 3)
                        $m = 'march';
                    else if ($i == 4)
                        $m = 'april';
                    else if ($i == 5)
                        $m = 'may';
                    else if ($i == 6)
                        $m = 'june';
                    else if ($i == 7)
                        $m = 'july';
                    else if ($i == 8)
                        $m = 'august';
                    else if ($i == 9)
                        $m = 'september';
                    else if ($i == 10)
                        $m = 'october';
                    else if ($i == 11)
                        $m = 'november';
                    else if ($i == 12)
                        $m = 'december';
                    ?>
                    <option value="<?php echo $i; ?>" <?php if ($m == $i) { echo 'selected'; } ?>><?php echo $m; ?></option>
                    <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info"><?php echo get_phrase('show_report'); ?></button>
    </div>
</div>
<?php echo form_close(); 