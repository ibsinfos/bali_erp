<div class="sidebar-menu">
    <header class="logo-env" >
        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="uploads/logo.png"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style="border-top:1px solid rgba(69, 74, 84, 0.7);"></div>	
    <ul id="main-menu" class="">
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'bus_driver') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/bus_drivers">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('drivers'); ?></span>
            </a>
        </li>
        
        <li class="<?php if ($page_name == 'driver_attendence') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/driver_attendence">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('driver attendence'); ?></span>
            </a>
        </li>
        
    </ul>

</div>
