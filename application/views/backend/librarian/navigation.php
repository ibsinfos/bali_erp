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
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
        

        <!-- General Setting -->
        <li class="<?php if ($page_name == 'general_setting') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/general_setting">
                <i class="entypo-tools"></i>
                <span><?php echo get_phrase('general_setting'); ?></span>
            </a>
        </li>
        <!-- Category -->
        <li class="<?php if ($page_name == 'category') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/category">
                <i class="entypo-menu"></i>
                <span><?php echo get_phrase('category'); ?></span>
            </a>
        </li>
        <!-- Sub Category -->
        <li class="<?php if ($page_name == 'subcategory') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/subcategory">
                <i class="entypo-tag"></i>
                <span><?php echo get_phrase('subcategory'); ?></span>
            </a>
        </li>
        <!-- Books -->
       
        
        <li class="<?php if ($page_name == 'books' ) echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('books'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'books') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/books">
                        <span><i class="entypo-book-open"></i><?php echo get_phrase('add_/_view_books'); ?></span>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="<?php if ($page_name == 'attendance_report') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?librarian/bulk_upload">
                        <span><i class="entypo-upload"></i><?php echo get_phrase('upload_books'); ?></span>
                    </a>
                </li>

            </ul>
        </li>  
        
        
        
        <!-- Books -->
        <li class="<?php if ($page_name == 'issuereturnbooks') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/issuereturnbooks">
                <i class="entypo-bookmarks"></i>
                <span><?php echo get_phrase('issue_/_return_books'); ?></span>
            </a>
        </li>

<!--         ACCOUNT 
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>-->

    </ul>

</div>