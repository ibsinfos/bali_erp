
<ul class="menu">
     <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>



        <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/teacher_list">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
        </li>
         <!-- ADMISSION -->
        <li class="<?php if ($page_name == 'admission_form') echo 'active'; ?> ">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('admission_form'); ?></span>
            </a>
            <ul class="sub-menu-list">
            <?php 
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'admission_form') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/admission_form/<?php echo $row['student_id'];?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>
        <!-- ACADEMIC SYLLABUS -->
        <li class="<?php if ($page_name == 'academic_syllabus') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('academic_syllabus'); ?></span>
            </a>
            <ul class="sub-menu-list">
            <?php 
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/academic_syllabus/<?php echo $row['student_id'];?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>
         <!-- subject -->
        <li class="<?php if ($page_name == 'subject') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('subject'); ?></span>
            </a>
            <ul>
            <?php 
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'subject') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/subject/<?php echo $row['student_id'];?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>

        <!-- CLASS ROUTINE -->
        <li class="<?php if ($page_name == 'class_routine') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('class_routine'); ?></span>
            </a>
            <ul class="sub-menu-list">
            <?php 
                $children_of_parent = $this->db->get_where('student' , array(
                    'parent_id' => $this->session->userdata('parent_id')
                ))->result_array();
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'class_routine') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/class_routine/<?php echo $row['student_id']?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>

        <!-- EXAMS -->
        <li class="<?php
        if ($page_name == 'marks') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam_marks'); ?></span>
            </a>
            <ul class="sub-menu-list">
            <?php 
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'marks') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/marks/<?php echo $row['student_id'];?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>
        
         <!-- Attendance -->
        <li class="<?php
        if ($page_name == 'attendance_report' || $page_name == 'attendance_report_view') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('attendance_report'); ?></span>
            </a>
            <ul class="sub-menu-list">
            <?php 
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'marks') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/attendance_report/<?php echo $row['student_id'];?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>
        
          <!-- PROGRESS REPORT -->
  	<li class="<?php
    	if ($page_name == 'progress_report') echo 'opened active';?> ">
        	<a href="#">
            	<i class="entypo-book"></i>
            	<span><?php echo get_phrase('progress_report'); ?></span>
        	</a>
        	<ul class="sub-menu-list">
        	<?php
            	foreach ($children_of_parent as $row):
        	?>
            	<li class="<?php if ($page_name == 'marks') echo 'active'; ?> ">
                	<a href="<?php echo base_url(); ?>index.php?parents/progress_report/<?php echo $row['student_id'];?>">
                    	<span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                	</a>
            	</li>
        	<?php endforeach;?>
        	</ul>
    	</li>
        <!-- PAYMENT -->
        <li class="<?php if ($page_name == 'invoice') echo 'opened active';?> ">
            <a href="#">
                <i class="entypo-credit-card"></i>
                <span><?php echo get_phrase('Fees'); ?></span>
            </a>
            <ul class="sub-menu-list">
            <?php 
                foreach ($children_of_parent as $row):
            ?>
                <li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?parents/student_accounting/<?php echo $row['student_id'];?>">
                        <span><i class="entypo-user"></i> <?php echo $row['name'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </li>



        <!-- LIBRARY -->
        <li class="<?php if ($page_name == 'book') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/book">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('library'); ?></span>
            </a>
        </li>

        <!-- TRANSPORT -->
        <li class="<?php if ($page_name == 'transport') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/transport">
                <i class="entypo-location"></i>
                <span><?php echo get_phrase('transport'); ?></span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/noticeboard">
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
        <li class="<?php if ($page_name == 'faculty_feedback') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/faculty_feedback">
                <i class="entypo-star"></i>
                <span><?php echo get_phrase('feedback'); ?></span>
            </a>
        </li>
        
        <!-- FEEDBACK -->
        <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?parents/message">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
        </li>
        
       
        <!--logout-->
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
