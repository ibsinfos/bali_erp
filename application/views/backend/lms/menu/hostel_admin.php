
<ul class="menu">

    <!-- DASHBOARD -->
    <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
            <i class="entypo-gauge"></i>
            <span><?php echo get_phrase('dashboard'); ?></span>
        </a>
    </li>

    <!-- TEACHER -->
    <li class="<?php if ($page_name == 'student_list') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/student_list">
            <i class="entypo-users"></i>
            <span><?php echo get_phrase('student_list'); ?></span>
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



