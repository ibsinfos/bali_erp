<?php foreach ($data as $value) { ?>
    <div class="modal-body"> 
        <from class="form-horizontal form-material">  
            <div class="form-group">
                <div class="col-md-6 m-b-20"> 
                    <label for="field-1"><?php echo get_phrase('name'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['exam_name']; ?>" readonly="readonly">
                </div>

                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('passing_percentage'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['passing_percent'] . '%'; ?>" readonly="readonly">
                </div>

                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('duration'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['duration'] ?>" readonly="readonly">
                </div>

                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('start_date'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['start_date'] ?>" readonly="readonly">
                </div>
                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('end_date'); ?></label>      
                    <input type="text"  class="form-control" value="<?php echo $value['end_date'] ?>" readonly="readonly">
                </div>
                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('negative_marking'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['negative_marking'] ?>" readonly="readonly">
                </div>
            </div>
            <hr>
            <table class="table display">
                <thead>
                    <tr>
                        <th><?php echo get_phrase('subject'); ?></th>
                        <th><?php echo get_phrase('total_question/subject'); ?></th>
                        <th><?php echo get_phrase('total_marks/subject'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subject_details as $value) { ?>
                        <tr>
                            <td><?php echo $value['subject_name'] ?></td>
                            <td><?php echo $value['total_question'] ?></td>
                            <td><?php echo $value['total_marks'] ?></td>    
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </from>
    </div>
<?php } ?>