<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>

<div class="navbar-default sidebar custom-sidebar-width" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head custom-sidebar-color">
            <h3 data-step="1" data-intro="<?php echo get_phrase('You will get Navigation from here!');?>" data-position='right'><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu"></span></h3> </div>

        <ul class=" nav p-r-0" id="side-menu">
            <!--Dashboard-->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-tachometer"></i>
                    <span class="menu-text"><?php echo get_phrase('dashboard'); ?></span>
                </a>
            </li>

            <!-- TEACHER -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/teacher_list" class="waves-effect active menu-items text-center">
                  <i class="icon-size fa fa-users"></i>
                    <span class="menu-text"><?php echo get_phrase('teacher'); ?></span>
                </a>
            </li>

            <!--EVENT CALENDER -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/event_calender" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-calendar"></i>
                    <span class="menu-text"><?php echo get_phrase('event_calender'); ?></span>
                </a>
            </li>

            <!-- SUBJECT -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/subject" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-book"></i>
                    <span class="menu-text"><?php echo get_phrase('subject'); ?></span>
                </a>
            </li>

            <!-- CLASS ROUTINE -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/class_routine" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-pencil-square"></i>
                    <span class="menu-text"><?php echo get_phrase('class_timetable'); ?></span>
                </a>
            </li>

            <!-- STUDY MATERIAL -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/study_material" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-book"></i>
                    <span class="menu-text"><?php echo get_phrase('study_material'); ?></span>
                </a>
            </li>

      <!-- Manage Assignments -->
            <li class="p-0 menu-item-tile">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/view_assignments" class="waves-effect active menu-items text-center">
                <i class="icon-size fa fa-tachometer"></i>
                <span class="menu-text"><?php echo get_phrase('view_assignments'); ?></span>
            </a>
        </li>
        
            <!-- ACADEMIC SYLLABUS -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?student/academic_syllabus/<?php echo $this->session->userdata('login_user_id');?>" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text-o"></i>
                    <span class="menu-text"><?php echo get_phrase('academic_syllabus'); ?></span>
                </a>
            </li>

            <!-- Exam marks -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/student_marksheet/<?php echo $this->session->userdata('login_user_id');?>" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-line-chart"></i>
                    <span class="menu-text"><?php echo get_phrase('exam_marks'); ?></span>
                </a>
            </li>

            <!-- TRANSPORT -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/transport" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa fa-bus"></i>
                    <span class="menu-text"><?php echo get_phrase('transport'); ?></span>
                </a>
            </li>

            <!-- NOTICEBOARD -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/noticeboard" class="waves-effect active menu-items text-center">
                       <i class="icon-size fa fa-newspaper-o"></i>
                    <span class="menu-text"><?php echo get_phrase('noticeboard'); ?></span>
                </a>
            </li>

            <!-- Manage topics -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/view_topics" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-book"></i>
                    <span class="menu-text"><?php echo get_phrase('subject_updates'); ?></span>
                </a>
            </li>
            
             <!-- Documents -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/documents/<?php echo $this->session->userdata('login_user_id');?>" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('documents'); ?></span>
                </a>
            </li>

            <!-- FEEDBACK -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/faculty_feedback" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-star-half-empty"></i>
                    <span class="menu-text"><?php echo get_phrase('faculty_feedback'); ?></span>
                </a>
            </li>

            <!-- MESSAGE -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/message" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-mobile"></i>
                    <span class="menu-text"><?php echo get_phrase('message'); ?></span>
                </a>
            </li>

            <!-- ACCOUNT -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-calculator"></i>
                    <span class="menu-text"><?php echo get_phrase('account'); ?></span>
                </a>
            </li>
            
            <!--Discussion Forum-->
            
            <li class=" p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?discussion_forum/view_all_threads" class="waves-effect active menu-items text-center"> 
                    <i class="icon-size fa fa-comments-o"></i>
                    <span class="menu-text"><?php echo get_phrase('discusssion_forum'); ?></span>
                </a>
            </li>
           
          
           <!--blogs-->

            <li class=" p-0 menu-item-tile has-submenu">
                <a href="#" class="waves-effect active menu-items text-center">
                    <i class="fa fa-bars more"></i>
                    <i class="icon-size fa fa-newspaper-o"></i>
                    <span class="menu-text"><?php echo get_phrase('blogs'); ?></span>
                </a>
            </li>
            <ul class="nav p-r-0 list-inline">
                <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?blogs/view_all_blogs" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-user"></i>
                    <span class="menu-text"><?php echo get_phrase('view_published_blogs'); ?></span>
                </a>                
            </li>
            <li class=" p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?blogs/view_my_blogs" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-user"></i>
                    <span class="menu-text"><?php echo get_phrase('view_my_blogs'); ?></span>
                </a>
            </li>
            </ul>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/online_polls" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-bar-chart"></i>
                    <span class="menu-text"><?php echo get_phrase('online_polls'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/online_polls_result" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-bar-chart"></i>
                    <span class="menu-text"><?php echo get_phrase('online_polls_results'); ?></span>
                </a>
            </li>

            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/my_exam" class="waves-effect active menu-items text-center">
                  <i class="icon-size fa fa-puzzle-piece"></i>
                    <span class="menu-text"><?php echo get_phrase('my_exam'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/my_online_result" class="waves-effect active menu-items text-center">
                  <i class="icon-size fa fa-table"></i>
                    <span class="menu-text"><?php echo get_phrase('my_online_result'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/incident" class="waves-effect active menu-items text-center">
                  <i class="icon-size fa fa-exclamation-triangle"></i>
                    <span class="menu-text"><?php echo get_phrase('incident'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/homework" class="waves-effect active menu-items text-center">
                  <i class="icon-size fa fa-home"></i>
                    <span class="menu-text"><?php echo get_phrase('homework'); ?></span>
                </a>
            </li>
               <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/certificates" class="waves-effect active menu-items text-center">
                  <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('certificate'); ?></span>
                </a>
            </li>

            <!--Help-->
                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?student/help" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-question"></i>
                        <span class="menu-text"><?php echo get_phrase('HELP'); ?></span>
                    </a>
                </li>
        </ul>
    </div>
</div>

<!--This one is used for a navigation for all logins-->
<script>
  $("#side-menu").hide();
    $(".custom-sidebar-width").addClass('custom-side-class');
    $(".sidebar-head").on('click', function() {
        $("#side-menu").toggle();
        if ($("#side-menu").is(":visible") == true) { 
            $("#page-wrapper").css('opacity', '0.6');
        }
        else { 
            $("#page-wrapper").css('opacity', '1'); 
        }
        $('.sidebar').toggleClass('side_menu1');
        $('body').toggleClass('overflow-toggle');
    });
    $('body').click(function(e){
        // check click was iside navigation or outside
        // if outside navigation then hide navigation
        // else do nothing
        if ($('.sidebar').has(e.target).length === 0 && $('.menu_in_mobile').has(e.target).length === 0) {
            $("#side-menu").hide();
            $('.sidebar').removeClass('side_menu1');
            $("#page-wrapper").css('opacity', '1');
        }
    });
    
    $('#side-menu li.has-submenu + ul').css('display', 'none');
    $("#side-menu li.has-submenu").on('click', function() {
        $(this).find('+ ul').toggle();
        $("#side-menu").toggleClass("sub-active");
        $("#side-menu li").removeClass('active');
        $(this).addClass('active');
    });
    //After clicking on menu if it has submenu then menu tile showing back icon
    $('#side-menu li.has-submenu a').click(function() {
        if ($("i:nth-child(2)", this).hasClass('fa-reply')) {
            $(".icon-size.fa.fa-reply + .menu-text").show();
            $("i:nth-child(2)", this).attr('class', $(this).data('origIconClass')).css('margin-top', '35px');
            
        } else {
            $(this).data('origIconClass', $("i:nth-child(2)", this).attr('class'));
            $("i:nth-child(2)", this).attr('class', 'icon-size fa fa-reply').css('margin-top', '55px');
            $(".icon-size.fa.fa-reply + .menu-text").hide();
        }
  });
</script>
