<!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link href="http://localhost/beta_newtheme/assets/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://localhost/beta_newtheme/assets/bower_components/multiselect/js/jquery.multi-select.js"></script>-->

<select name="student_id[]" data-style="form-control" data-live-search="true" class="selectpicker" multiple data-actions-box="true" style="width:100%;" id = "student_holder">
    <?php foreach($students as $stud){ ?>
    <option value="<?php echo $stud['student_id']; ?>"><?php echo $stud['name']; ?></option>
    <?php } ?>
</select>

