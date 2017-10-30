<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php if ($this->session->flashdata('flash_validation_error')) { ?>        
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_validation_error'); ?>
    </div>
<?php } ?>
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading">Dear Students,
        <div class="pull-right">
            <a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a><a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> 
        </div>
    </div>

    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body"><p>Please feel free in sharing your valuable feedback with us! We feel happy hearing from you.</p></div>
    </div>
</div>

<div class="row" >
    <?php echo form_open(base_url().'index.php?student/faculty_feedback/create/', array('class' =>'form-horizontal','id'=>'faculty_feedback', 'method'=>'POST'));?>
        <div class="col-md-12">
            <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Here you just fill information');?>" data-position='top'>
                <div class ="row m-0">
                    <div class="col-sm-6 form-group">
                        <label for="teacher_id" class="control-label m-b-5"><?php echo get_phrase('select_teacher'); ?>:<span class="mandatory"> *</span></label>

                        <select data-style="form-control" data-live-search="true" class="selectpicker" name="teacher_id" id="teacher">
                            <option value=" "><?php echo get_phrase('select_teacher');?></option><?php foreach($teacher_list as $list):?>
                            <option value = "<?php echo $list['teacher_id'];?>"><?php echo $list['name'];?></option><?php endforeach;?>
                        </select>

                        <label> <?php echo form_error('teacher_id'); ?></label> 
                    </div> 

                    <div class="col-sm-6 form-group">
                        <label class="control-label m-l-20 m-b-3" for="rating"><?php echo get_phrase('Rating');?>:<span class="mandatory"> *</span></label>
                        <br>
                        <fieldset class="rating control-label m-l-15">
                            <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Excellent - 5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Good - 3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Satisfactory - 2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Poor - 1 star"></label>
                        </fieldset>
                    </div>
                </div> 

                <div class="row m-0">
                    <div class="col-sm-12 form-group p-r-0">
                        <label for="feed_back" class="control-label m-b-5"><?php echo get_phrase('enter_your_feed_back'); ?>:<span class="mandatory"> *</span></label>
                        <br/>
                        <div class="input-group col-sm-12">
                            <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                            <textarea type="text"  rows="3" class="form-control" name="feed_back" placeholder="Describe your feedback"></textarea>
                        </div>
                        <label> <?php echo form_error('feed_back'); ?></label>   
                    </div> 
                </div>
                
                <div class="row m-0">
                    <div class="col-xs-12 text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_feedback');?></button>
                    </div>  
                </div>
            </div>
        </div>
    <?php echo form_close();?>
</div>

<style>
    fieldset, label { margin: 0; padding: 0; }
    h1 { font-size: 1.5em; margin: 10px; }


    .rating { 
      border: none;
      float: left;
    }

    .rating > input { display: none; } 
    .rating > label:before { 
      margin: 0 10px;
      font-size: 30px;
      font-family: FontAwesome;
      display: inline-block;
      content: "\f005";
    }

    .rating > .half:before { 
      content: "\f089";
      position: absolute;
    }

    .rating > label { 
      color: #ddd; 
     float: right; 
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating > input:checked ~ label, /* show gold star when clicked */
    .rating:not(:checked) > label:hover, /* hover current star */
    .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

    .rating > input:checked + label:hover, /* hover current star when changing rating */
    .rating > input:checked ~ label:hover,
    .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
    .rating > input:checked ~ label:hover ~ label { color: #FFED85;  }     
</style>
