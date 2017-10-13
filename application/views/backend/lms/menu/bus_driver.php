<ul class="menu">

    <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
            <i class="entypo-gauge"></i>
            <span><?php echo get_phrase('dashboard'); ?></span>
        </a>
    </li>

    <li class="<?php if ($page_name == 'students') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/students">
            <i class="entypo-user"></i>
            <span><?php echo get_phrase('students'); ?></span>
        </a>
    </li>

    <li class="<?php if ($page_name == 'trip') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/trip">
            <i class="entypo-globe"></i>
            <span><?php echo get_phrase('trip'); ?></span>
        </a>
    </li>

</ul>
