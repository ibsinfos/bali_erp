
<ul class="menu">

    <!-- DASHBOARD -->
    <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
            <i class="entypo-gauge"></i>
            <span><?php echo get_phrase('dashboard'); ?></span>
        </a>
    </li>

    <!-- STUDENT -->
        <li class="<?php if ($page_name == 'student_add' || $page_name == 'student_information' || $page_name == 'student_marksheet') echo 'opened active has-sub'; ?> ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span><?php echo get_phrase('student'); ?></span>
            </a>
            <ul class="sub-menu-list">
                <!-- STUDENT ADMISSION -->
                <!--li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/student_add">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li-->

                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_marksheet') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/student_information/">
                        <span><i class="entypo-info-circled"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'set_ptm') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/set_ptm_time/">
                        <span><i class="entypo-install"></i> <?php echo get_phrase('set_parent_meeting'); ?></span>
                    </a>
                </li>

            </ul>
        </li>

    
    <!-- TEACHER -->
    <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/teacher_list">
            <i class="entypo-users"></i>
            <span><?php echo get_phrase('teacher'); ?></span>
        </a>
    </li>



    <!-- SUBJECT -->
    <li class="<?php if ($page_name == 'subject') echo ' active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/subject">
            <i class="entypo-docs"></i>
            <span><?php echo get_phrase('subject'); ?></span>
        </a>
    </li>
    <!-- REPORTS -->
        <li class="<?php if ($page_name == 'progress_report') echo 'opened active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?teacher/progress_report/">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('progress_report'); ?></span>
            </a>
        </li>
    <!-- CLASS ROUTINE -->
    
        <li class="<?php if ($page_name == 'class_routine' || $page_name == 'class_routine_print_view') echo 'opened active'; ?> ">
            <!--<a href="<?php echo base_url(); ?>index.php?teacher/class_routine/<?php echo $this->session->userdata('teacher_id');?>">-->
            <a href="<?php echo base_url(); ?>index.php?teacher/class_routine_view/">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('class_routine'); ?></span>
            </a>
        </li>

    <!-- STUDY MATERIAL -->
    <li class="<?php if ($page_name == 'study_material') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/study_material">
            <i class="entypo-book-open"></i>
            <span><?php echo get_phrase('study_material'); ?></span>
        </a>
    </li>

    <!-- ACADEMIC SYLLABUS -->
    <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?teacher/academic_syllabus/<?php echo $this->session->userdata('login_user_id'); ?>">
            <i class="entypo-doc"></i>
            <span><?php echo get_phrase('academic_syllabus'); ?></span>
        </a>
    </li>
    
    <!-- DAILY ATTENDANCE -->
        <li class="<?php if ($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view') echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('daily_attendance'); ?></span>
            </a>
            <ul class="sub-menu-list">
                <li class="<?php if ($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?teacher/manage_attendance/">
                        <span><i class="entypo-doc-text"></i> <?php echo get_phrase('manage_attendance'); ?></span>
                    </a>
                </li>
                <li class="<?php if (( $page_name == 'attendance_report' || $page_name == 'attendance_report_view')) echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/attendance_report">
                        <span><i class="entypo-chart-area"></i><?php echo get_phrase('attendance_report'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
    
<!--     Exam marks 
    <li class="<?php if ($page_name == 'student_marksheet') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/student_marksheet/<?php echo $this->session->userdata('login_user_id'); ?>">
            <i class="entypo-graduation-cap"></i>
            <span><?php echo get_phrase('exam_marks'); ?></span>
        </a>
    </li>

     PAYMENT 
    <li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/invoice">
            <i class="entypo-credit-card"></i>
            <span><?php echo get_phrase('payment'); ?></span>
        </a>
    </li>


     Library 
    <li class="<?php if ($page_name == 'books_detail' || $page_name == 'issued_books') echo 'opened active'; ?> ">
        <a href="#">
            <span><i class="entypo-dot"></i> <?php echo get_phrase('library'); ?></span>
        </a>
        <ul class="sub-menu-list">
            <li class="<?php if ($page_name == 'books_detail') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/books_detail">
                    <span><?php echo get_phrase('books'); ?></span>
                </a>
            </li>
            <li class="<?php if ($page_name == 'issued_books') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/issued_books">
                    <span><?php echo get_phrase('issue_books'); ?></span>
                </a>
            </li>
        </ul>
    </li>-->

    <!-- TRANSPORT -->
    <li class="<?php if ($page_name == 'transport') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/transport">
            <i class="entypo-location"></i>
            <span><?php echo get_phrase('transport'); ?></span>
        </a>
    </li>

    <!-- NOTICEBOARD -->
    <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/noticeboard">
            <i class="entypo-doc-text-inv"></i>
            <span><?php echo get_phrase('noticeboard'); ?></span>
        </a>
    </li>
    
        <!------Forums---->   
        <li class="<?php if ($page_name == 'discusssion_forum') echo 'active'; ?> ">
            <a href="#">
                <i class="entypo-network"></i> 
                <span><?php echo get_phrase('forums_&_blogs'); ?></span>
            </a>
            <ul class="sub-menu-list">   
            <li class="<?php if ($page_name == 'discusssion_forum') echo 'active'; ?> ">
                <a href="#">
                    <span><i class="entypo-comment"></i> <?php echo get_phrase('discusssion_forum'); ?></span>
                </a>

                 <ul class="sub-menu-list">
                    <li class="<?php if ($page_name == 'view_all_threads') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?discussion_forum/view_all_threads">
                        <span><i class="entypo-eye"></i> <?php echo get_phrase('view_threads'); ?></span>
                    </a>
                    </li>
                
                    <li class="<?php if ($page_name == 'add_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?discussion_forum/create_category">
                        <span><i class="entypo-suitcase"></i> <?php echo get_phrase('view_category'); ?></span>
                    </a>
                    </li>
                </ul>
            </li>
            
            <li class="<?php if ($page_name == 'create_blog' )echo 'active'; ?> ">
                <a href="#">
                    <span><i class="entypo-archive"></i> <?php echo get_phrase('blogs'); ?></span>
                </a>
                <ul class="sub-menu-list">                    
                    <li class="<?php if ($page_name == 'view_blogs' )echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?blogs/create_blog/">
                            <span><i class="entypo-archive"></i> <?php echo get_phrase('new_blog'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'view_blogs' )echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?blogs/view_blogs/">
                            <span><i class="entypo-archive"></i> <?php echo get_phrase('view_blogs'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'view_all_blogs' )echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?blogs/view_all_blogs/">
                            <span><i class="entypo-archive"></i> <?php echo get_phrase('view_all_blogs'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            </ul>
        </li>
        
    <!-- MESSAGE -->
    <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/message">
            <i class="entypo-mail"></i>
            <span><?php echo get_phrase('message'); ?></span>
        </a>
    </li>

    <!-- ACCOUNT -->
    <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
            <i class="entypo-lock"></i>
            <span><?php echo get_phrase('account'); ?></span>
        </a>
    </li>
    
    <li>
        <a href="<?php echo base_url(); ?>index.php?login/logout">
            <i class="entypo-gauge"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
<script>
   $(document).ready(function () {
    $('.sub-menu-list').hide();
 
    $('ul.menu > li a').click(function (e) {
        e.stopPropagation();
        var $parentli = $(this).closest('li');
        $parentli.siblings('li').find('ul:visible').hide();
        $parentli.find('> ul').stop().toggle();
    });

});
</script>
