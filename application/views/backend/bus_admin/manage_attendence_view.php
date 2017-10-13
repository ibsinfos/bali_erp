<?php echo form_open(base_url() . 'index.php?bus_admin/driver_attendence_view'); ?>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_driver'); ?></label>
            <select name="driver_id" class="form-control selectboxit">
                <option value=""><?php echo get_phrase('select_driver'); ?></option>
                <?php foreach ($list_drivers as $list_driver): ?>
                    <option <?php if($driver_id == $list_driver['bus_driver_id']){ echo 'selected'; } ?> value="<?php echo $list_driver['bus_driver_id']; ?>"><?php echo $list_driver['name']; ?></option>
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
                    <option value="<?php echo $i; ?>" <?php if ($month == $i) { echo 'selected'; } ?>><?php echo $m; ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info"><?php echo get_phrase('show_report'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<div class="row">
    <div class="col-md-12">
        <h4>Morning Session</h4>
        <table class="table table-bordered" id="my_table">
            <thead>
                <tr>
                    <td style="text-align: center;">
                    <?php echo get_phrase('trips'); ?> <i class="entypo-down-thin"></i> <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                    </td>
                    <?php
                    $year = date('Y');
                    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    for ($i = 1; $i <= $days; $i++) { ?>
                    <td style="text-align: center;"><?php echo $i; ?></td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php for($i = 1; $i <= $trips; $i++) { ?>
                    <tr>
                        <td style="text-align: center;">Group -<?= $i; ?></td>
                        <?php for ($j = 1; $j <= $days; $j++) {
                        $status = 0; 
                        if(count($attendence_morning) != 0) {
                        foreach ($attendence_morning as $row) {
                        $date = date('d', $row['timestamp']);
                        if ($j == $date && $i == $row['route_group']) { $status = 1; } ?>
                        <?php if($status == 1) : ?>
                        <td style="text-align: center;">
                            <i class="entypo-record" style="color: #00a651;"></i>
                        </td>
                        <?php else : ?>
                        <td style="text-align: center;"></td>
                        <?php endif; } } else { echo '<td></td>'; } } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <div class="col-md-12">
        <h4>Evening Session</h4>
        <table class="table table-bordered" id="my_table">
            <thead>
                <tr>
                    <td style="text-align: center;">
                    <?php echo get_phrase('trips'); ?> <i class="entypo-down-thin"></i> <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                    </td>
                    <?php
                    $year = date('Y');
                    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    for ($i = 1; $i <= $days; $i++) { ?>
                    <td style="text-align: center;"><?php echo $i; ?></td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php for($i = 1; $i <= $trips; $i++) { ?>
                    <tr>
                        <td style="text-align: center;">Group -<?= $i; ?></td>
                        <?php for ($j = 1; $j <= $days; $j++) {
                        $status = 0; 
                        if(count($attendence_evening) != 0) {
                        foreach ($attendence_evening as $row) {
                        $date = explode('/', $row['date']);
                        if ($j == $date[0] && $i == $row['route_group']) { $status = 1; } } ?>
                        <?php if($status == 1) : ?>
                        <td style="text-align: center;">
                            <i class="entypo-record" style="color: #00a651;"></i>
                        </td>
                        <?php else : ?>
                        <td style="text-align: center;"></td>
                        <?php endif; } else { echo '<td></td>'; }  } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function (i, el)
            {
                var $this = $(el),
                        opts = {
                            showFirstOption: attrDefault($this, 'first-option', true),
                            'native': attrDefault($this, 'native', false),
                            defaultText: attrDefault($this, 'text', ''),
                        };

                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }
    });
</script>