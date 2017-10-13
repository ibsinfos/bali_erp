<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<div class="navbar-default sidebar custom-sidebar-width" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head custom-sidebar-color">
            <h3 data-step="1" data-intro="You will get Navigation from here!" data-position='right'><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3> </div>

        <ul class=" nav p-r-0" id="side-menu">
              <!--Dashboard-->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?admin/dashboard" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-tachometer"></i>
                    <span class="menu-text"><?php echo get_phrase('Dashboard'); ?></span>
                </a>
            </li>
            <!---School & School Admin Management-->
            
            <li class="p-0 menu-item-tile has-submenu">
                <a href="#" class="waves-effect active menu-items text-center">
                    <i class="fa fa-bars more"></i>
                    <i class="icon-size fa fa-globe"></i>
                    <span class="menu-text"><?php echo get_phrase('Manage Schools'); ?></span>
                </a>
            </li>
            
            <ul class="nav p-r-0 list-inline">
                <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?admin/add_school" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-tachometer"></i>
                    <span class="menu-text"><?php echo get_phrase('Add School'); ?></span>
                </a>
                </li>
                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?admin/schools" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-file-text"></i>
                        <span class="menu-text"><?php echo get_phrase('Manage_school'); ?></span>
                    </a>
                </li>
                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?admin/add_school_admin" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-file-text"></i>
                        <span class="menu-text"><?php echo get_phrase('Add School Admin'); ?></span>
                    </a>
                </li>

                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?admin/school_admin" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-eye"></i>
                        <span class="menu-text"><?php echo get_phrase('Manage School Admin'); ?></span>
                    </a>
                </li>
                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?admin/assign_admin_to_school" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-address-book-o"></i>
                        <span class="menu-text"><?php echo get_phrase('Assign Admin to School'); ?></span>
                    </a>
                </li>
                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?admin/message" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-mobile"></i>
                        <span class="menu-text"><?php echo get_phrase('message'); ?></span>
                    </a>
                </li>
            </ul>
            
            <!--Discussion Forum-->
            
            <li class=" p-0 menu-item-tile has-submenu">
                <a href="#" class="waves-effect active menu-items text-center">
                    <i class="fa fa-bars more"></i>
                    <i class="icon-size fa fa-comments-o"></i>
                    <span class="menu-text"><?php echo get_phrase('discusssion_forum'); ?></span>
                </a>
            </li>
            <ul class="nav p-r-0 list-inline">

                <li class=" p-0 menu-item-tile <?php if ($page_name == 'add_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?discussion_forum/create_category" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-pie-chart"></i>
                        <span class="menu-text"><?php echo get_phrase('view_category'); ?></span>
                    </a>
                </li>
                <li class=" p-0 menu-item-tile<?php if ($page_name == 'view_all_threads') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?discussion_forum/view_all_threads" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-user"></i>
                        <span class="menu-text"><?php echo get_phrase('view_threads'); ?></span>
                    </a>
                </li>
            </ul>
            
            <!---ADMISSION ENQUIRY-->
            <li class="p-0 menu-item-tile has-submenu">
                <a href="#" class="waves-effect active menu-items text-center">
                    <i class="fa fa-bars more"></i>
                    <i class="icon-size fa fa-globe"></i>
                    <span class="menu-text"><?php echo get_phrase('Reports'); ?></span>
                </a>
            </li>
            <ul class="nav p-r-0 list-inline">
                 <li class="p-0 menu-item-tile <?php if ($page_name == 'student_attendance_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_attendance_report" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student Attendance'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_scholarship_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_scholarship_report" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student Scholarship'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_gender_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_gender_report" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student Gender Repot'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_leave_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_leave_report" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student Leave Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/emirati" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Emirati Students Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_category_report/" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student Category Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/muslim" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Muslim Students Report'); ?></span>
                </a>
            </li> 
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/RTE" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student RTE Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'teacher_leave_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/teacher_leave_report/" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Teacher Leave Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_fee_due_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_fee_due_report/" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Student Fee Due Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'class_topper_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/class_topper_report/" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Class Topper Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'best_ranking_student_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/best_ranking_student_report/" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Best Ranking student'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/school_report/" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('School Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/class" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Class Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/section" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Section Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/expense" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Expense Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/revenue" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Revenue Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/bus" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Bus Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/teacher" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Teacher Report'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'student_common_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/computer" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Computer Report'); ?></span>
                </a>
            </li>
            </ul>
            <li class="p-0 menu-item-tile has-submenu">
                <a href="#" class="waves-effect active menu-items text-center">
                    <i class="fa fa-bars more"></i>
                    <i class="icon-size fa fa-globe"></i>
                    <span class="menu-text"><?php echo get_phrase('Payroll Reports'); ?></span>
                </a>
            </li>
            <ul class="nav p-r-0 list-inline">
                 <li class="p-0 menu-item-tile <?php if ($page_name == 'expenses_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/expenses" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Expenses Reports'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'gross_income_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/revenues" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Gross Income'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile <?php if ($page_name == 'net_income_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?admin/student_common_report/net" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-file-text"></i>
                    <span class="menu-text"><?php echo get_phrase('Net Income'); ?></span>
                </a>
            </li>
        </ul> 
    </div>
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
    });
    $('body').click(function(e){
        // check click was iside navigation or outside
        // if outside navigation then hide navigation
        // else do nothing
        
        if ($('.sidebar').has(e.target).length === 0) {
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


    $('#side-menu li.has-submenu a').on('click', function() {
        var getClassName = $("i:nth-child(2)", this).attr('class');
        //alert(getClassName);
    });
</script>