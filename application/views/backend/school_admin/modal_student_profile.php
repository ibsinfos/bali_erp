<?php
//    $current_year = $this->Setting_model->get_setting_record(array('type' => 'running_year'), 'description');
//    $row = $this->Student_model->get_enroll_record(array('student_id' => $param2, 'year' => $current_year));
//    $row = (array) $row;
//    $info = $this->Student_model->get_student_record(array('student_id' => $param2));
//    $class_name = $this->Class_model->get_class_record(array("class_id" => $row['class_id']), "name");
//    $section_name = $this->Class_model->get_section_record(array("section_id" => $row['section_id']), "name");
//    $parent_info = $this->Parent_model->get_parent_record(array("parent_id" => $info->parent_id));
 
//pre($student_personal_info);	

	if (!empty($student_personal_info))
    {
        ?>

		
        <div class="profile-env">

            <header class="row">

                <div class="col-sm-3">
                    <?php
                        $image_url          =   ($student_personal_info->stud_image !=''?base_url().'uploads/student_image/'.$student_personal_info->stud_image:base_url() . 'uploads/user.jpg');
                    ?>
                    <a href="#" class="profile-picture">                        
                        <img src="<?php echo $image_url;?>"
                             class="img-responsive img-circle" />
                    </a>

                </div>

                <div class="col-sm-9">

                    <ul class="profile-info-sections">
                        <li style="padding:0px; margin:0px;">
                            <div class="profile-name">
                                <h3>
                                    <?php echo $student_personal_info->name ." ". ($student_personal_info->mname!=''?$student_personal_info->mname:'') ." ". $student_personal_info->lname; ?>                     
                                </h3>
                            </div>
                        </li>
                    </ul>

                </div>


            </header>

            <section class="profile-info-tabs">

                <div class="row">

                    <div class="">
                        <br>
                        <table class="table table-bordered">

                            <?php if ($student_personal_info->class_name != ''): ?>
                                <tr>
                                    <td><?php echo get_phrase('class'); ?></td>
                                    <td><b><?php echo $student_personal_info->class_name; ?></b></td>
                                </tr>
                            <?php endif; ?>

                            <?php if (!empty($student_personal_info->section_name)): ?>
                                <tr>
                                    <td><?php echo get_phrase('section'); ?></td>
                                    <td><b><?php echo $student_personal_info->section_name ?></b></td>
                                </tr>
                            <?php endif; ?>

                            <?php if ($student_personal_info->enroll_code != ''): ?>
                                <tr>
                                    <td><?php echo get_phrase('roll'); ?></td>
                                    <td><b><?php echo $student_personal_info->enroll_code; ?></b></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td><?php echo get_phrase('birthday'); ?></td>
                                <td><b><?php echo $student_personal_info->birthday; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('gender'); ?></td>
                                <td><b><?php echo $student_personal_info->sex; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('phone'); ?></td>
                                <td><b><?php echo $student_personal_info->phone; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('email'); ?></td>
                                <td><b><?php echo $student_personal_info->email; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('address'); ?></td>
                                <td><b><?php echo $student_personal_info->address; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('country'); ?></td>
                                <td><b><?php echo $student_personal_info->country; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('nationality'); ?></td>
                                <td><b><?php echo $student_personal_info->nationality; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('place_of_birth'); ?></td>
                                <td><b><?php echo $student_personal_info->place_of_birth; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('previous_school'); ?></td>
                                <td><b><?php echo $student_personal_info->previous_school; ?></b>
                                </td>
                            </tr>
                             <tr>
                                <td><?php echo get_phrase('course'); ?></td>
                                <td><b><?php echo $student_personal_info->course; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('parent'); ?></td>
                                <td>
                                    <b>
                                        <?php
                                        echo $student_personal_info->father_name;
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('parent_phone'); ?></td>
                                <td><b><?php echo $student_personal_info->cell_phone; ?></b></td>
                            </tr>

                        </table>
                    </div>
                </div>		
            </section>
        </div>


    <?php } ?>