<ul class="menu">

    <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
            <i class="entypo-gauge"></i>
            <span><?php echo get_phrase('dashboard'); ?></span>
        </a>
    </li>
    
    <li class="<?php if ($page_name == 'bus_driver') echo 'active'; ?> ">
        <a href="<?php echo base_url(); ?>index.php?bus_admin/bus_drivers">
            <i class="entypo-gauge"></i>
            <span><?php echo get_phrase('drivers'); ?></span>
        </a>
    </li>

</ul>

