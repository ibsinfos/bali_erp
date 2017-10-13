<?php
    if (!empty($doctor_profile))
    {
    ?>
        <div class="profile-env">          
            <section class="profile-info-tabs">
                <div class="row">
                    <div class="col-md-12">        
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo get_phrase("name"); ?></td>
                                <td><b><?php echo $doctor_profile->name; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("Email_address"); ?></td>
                                <td><b><?php echo $doctor_profile->email; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("phone_number"); ?></td>
                                <td><b><?php echo $doctor_profile->phone_no;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("address"); ?></td>
                                <td><b><?php echo $doctor_profile->address;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("year_of_experience"); ?></td>
                                <td><b><?php echo $doctor_profile->year_of_exp;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("specialization"); ?></td>
                                <td><b><?php echo $doctor_profile->specialization;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("department"); ?></td>
                                <td><b><?php echo $doctor_profile->department;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("education_background"); ?></td>
                                <td><b><?php echo $doctor_profile->education_background;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("before_place_work"); ?></td>
                                <td><b><?php echo $doctor_profile->before_place_work;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("achivement_award"); ?></td>
                                <td><b><?php echo $doctor_profile->achivement_award;?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase("qualification"); ?></td>
                                <td><b><?php echo $doctor_profile->qualification;?></b></td>
                            </tr>
                            </table>
                    </div>
                </div>		
            </section>
        </div>
    <?php } ?>
        