<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Manage_Profile'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?doctor/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
        </ol>
    </div>
</div>


<div class="col-md-12 white-box">        
    <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li><a href="#section-flip-1" class="sticon fa fa-info"><span><?php echo get_phrase('my_profile');?></span></a></li>
                    <li><a href="#section-flip-2" class="sticon fa fa-edit"><span><?php echo get_phrase('manage_profile');?></span></a></li>
                    <li><a href="#section-flip-3" class="sticon fa fa-key"><span><?php echo get_phrase('change_password');?></span></a></li>
                </ul>
            </nav>
            <div class="content-wrap">
                <section id="section-flip-1">
                    <div class="row">
                    <div class="tab-pane box">
                        <div class="box-content padded">
                        <?php // foreach($edit_data as $row): ?>
                            <div class="panel-body">
                            <div class="col-md-12 no-padding m-b-20">
                                    <div class="col-xs-2 col-md-1 no-padding text-left table-stu-info">                                         
                                        <div class="profile-picture">
                                           
                                        </div>
                                   </div>

                                    <div class="col-xs-10 col-md-11 m-t-10">
                                        <h2 class="stu-name-margin"><?php echo $doctor_profile->name; ?></h2>
                                    </div>
                                </div>
                                <table class="table table-bordered table_row_hover">
                                    <tr>
                                         <th><b><?php echo get_phrase('email_: '); ?></b></th>
                                         <td><?php echo $doctor_profile->email; ?></td>
                                    </tr>
                                    <tr>
                                         <th><b><?php echo get_phrase('logged_in_as_: '); ?></b></th>
                                         <td><?php echo "Doctor"; ?></td>
                                    </tr>
                                    <tr>
                                         <th><b><?php echo get_phrase('address_: '); ?></b></th>
                                         <td><?php echo $doctor_profile->address; ?></td>
                                    </tr>
                                    <tr>
                                         <th><b><?php echo get_phrase('phone_no_: '); ?></b></th>
                                         <td><?php echo $doctor_profile->phone_no; ?></td>
                                    </tr>
                                    <tr>
                                         <th><b><?php echo get_phrase('year_of_exp_: '); ?></b></th>
                                         <td><?php echo $doctor_profile->year_of_exp; ?></td>
                                    </tr>
                                    <tr>
                                         <th><b><?php echo get_phrase('specialization_: '); ?></b></th>
                                         <td><?php echo $doctor_profile->specialization; ?></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        <?php // endforeach; ?>
                        </div>
                    </div> 
                    </div>
                </section>
                <section id="section-flip-2">
                   <?php echo form_open(base_url() . 'index.php?doctor/manage_profile/update_profile_info' , array('class' => 'form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('username');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user-circle-o"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo $doctor_profile->name; ?>" required>                                      
                            </div>
                        </div>
                   
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('email');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input type="email" class="form-control" name="email"  value="<?php echo $doctor_profile->email; ?>">                                                             <input type="hidden" class="form-control" name="email_old"  value="<?php echo $doctor_profile->email; ?>"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('phone_no');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                <input type="text" class="form-control" name="phone_no" value="<?php echo $doctor_profile->phone_no; ?>" required>                                      
                            </div>
                        </div>
                   
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('address');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
                                <input type="text" class="form-control" name="address"  value="<?php echo $doctor_profile->address; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('year_of_exprience');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-flask"></i></div>
                                <input type="text" class="form-control" name="year_of_exp" value="<?php echo $doctor_profile->year_of_exp; ?>" required>                                      
                            </div>
                        </div>
                   
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('specialization');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user-secret"></i></div>
                                <input type="text" class="form-control" name="specialization"  value="<?php echo $doctor_profile->specialization; ?>">                               </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('qualification');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-quote-right"></i></div>
                                <input type="text" class="form-control" name="qualification" value="<?php echo $doctor_profile->qualification; ?>">                                      
                            </div>
                        </div>
                   
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('education_background');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>
                                <input type="text" class="form-control" name="education_background"  value="<?php echo $doctor_profile->education_background; ?>">                                                        
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('before_place_work');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                <input type="text" class="form-control" name="before_place_work"  value="<?php echo $doctor_profile->before_place_work; ?>">                                                        
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('achivement_award');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-trophy"></i></div>
                                <input type="text" class="form-control" name="achivement_award"  value="<?php echo $doctor_profile->achivement_award; ?>">                                                        
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('department');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-info"></i></div>
                                <input type="text" class="form-control" name="department"  value="<?php echo $doctor_profile->department; ?>">                                                        
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('Upload photo');?></label>
                            <div class="col-sm-12 no-padding">

                            <input type="file" id="input-file-now" class="dropify" name="userfile" /> 
                            <input type="hidden" name="image" value="<?php echo $doctor_profile->profile_pic; ?>" /> 
                            
                            </div>
                        </div>                                
                    </div>   

                    <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('update_profile');?></button>
                    </div>

                    <?php echo form_close();?>
                  
                </section>
                <section id="section-flip-3">
                    <?php echo form_open(base_url() . 'index.php?doctor/manage_profile/change_password' , array('class' => 'form-groups-bordered validate','target'=>'_top'));?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('current_password');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" name="password" required>                                       
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('new_password');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-pagelines"></i></div>
                                <input type="text" class="form-control" name="new_password" required>                                       
                            </div>
                        </div>
                    </div>                        
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('confirm_new_password');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-recycle"></i></div>
                                <input type="text" class="form-control" name="confirm_new_password" required>                                       
                            </div>
                        </div>
                    </div>  
                    <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('update_password');?></button>
                    </div>
                    <?php echo form_close();?>
                </section>
            </div>
        </div>
    </section>
</div>
    