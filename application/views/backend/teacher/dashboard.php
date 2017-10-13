<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><?php echo get_phrase('Dashboard'); ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box col-lg-3 col-sm-6 row-in-br height_box">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-danger"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $count->cnt;?></h3>
                </li>
                <li class="col-middle">
                    <h4><?php echo get_phrase('Total_student'); ?></h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="white-box col-lg-3 col-sm-6 row-in-br height_box">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-info"><i class="fa fa-users"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $teacher_count; ?></h3>
                </li>
                <li class="col-middle">
                    <h4><?php echo get_phrase('Total_teacher'); ?></h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="white-box col-lg-3 col-sm-6 row-in-br height_box">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-success"><i class="fa fa-user-circle"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><?php echo $parent_count; ?></h3>
                </li>
                <li class="col-middle">
                    <h4><?php echo get_phrase('Total_parent'); ?></h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="white-box col-lg-3 col-sm-6 row-in-br height_box">
            <ul class="col-in">
                <li>
                    <span class="circle circle-md bg-warning"><i class="fa fa-bar-chart"></i></span>
                </li>
                <li class="col-last" style="padding:0;">
                    <h3 class="counter text-right m-t-15"><div class="num" data-start="0" data-end="" data-postfix="" data-duration="500" data-delay="0">
                        <?php echo $present_today ?>
                    </div></h3>
                </li>
                <li class="col-middle">
                    <h4><?php echo get_phrase('total_attendance'); ?></h4>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-12">
                <div class="white-box">
                    <div id="eventcalendar" data-step="6" data-intro="<?php echo get_phrase('View the Calendar');?>" data-position='top'></div>
                </div>
            </div>
        </div>
        <!-- BEGIN MODAL -->
        <div class="modal fade none-border" id="my-event">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong>Add Event</strong></h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                        <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add Category -->
        <div class="modal fade none-border" id="add-type">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong>Add</strong> event type</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Event Name</label>
                                    <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Choose Event Color</label>
                                    <select class="selectpicker form-white" data-style="form-control" data-live-search="true" data-placeholder="Choose a color..." name="category-color">
                                        <option value="success">Success</option>
                                        <option value="danger">Danger</option>
                                        <option value="info">Info</option>
                                        <option value="primary">Primary</option>
                                        <option value="warning">Warning</option>
                                        <option value="inverse">Inverse</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php listEvents()?>