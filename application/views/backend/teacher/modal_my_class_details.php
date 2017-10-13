<div class="row">    
    <div class="col-md-12">
        <div>
            <?php if (!empty($class_teacher)) { ?>
                <?php foreach ($class_teacher as $cls) { ?>
                    <h4><?php echo 'Class Teacher of : ' . $cls['class'] . " - " . $cls['section']; ?></h4>
                <?php } ?>
            <?php } else {
                echo 'No classes assigned';
            } ?>
        </div>

        <table class="table table-bordered" id="table_export_list">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no'); ?></div></th>
                    <th><div><?php echo get_phrase('class'); ?></div></th>
                    <th><div><?php echo get_phrase('section'); ?></div></th>
                    <th><div><?php echo get_phrase('subject'); ?></div></th> 
                </tr>
            </thead>
            <tbody>
<?php $count = 1;
foreach ($subjects as $row): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['class_name']; ?></td>
                        <td><?php echo $row['section_name']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>    