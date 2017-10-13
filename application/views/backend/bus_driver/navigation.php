<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>

<div class="navbar-default sidebar custom-sidebar-width" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head custom-sidebar-color">
            <h3 data-step="1" data-intro="You will get Navigation from here!" data-position='right'><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu"></span></h3> </div>

        <ul class=" nav p-r-0" id="side-menu">
             <!-- DASHBOARD -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-tachometer"></i>
                    <span class="menu-text"><?php echo get_phrase('dashboard'); ?></span>
                </a>
            </li>
            
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_students" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-user"></i>
                    <span class="menu-text"><?php echo get_phrase('manage_student'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/bus_details" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-bus"></i>
                    <span class="menu-text"><?php echo get_phrase('bus_details'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/bus_admin" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-server"></i>
                    <span class="menu-text"><?php echo get_phrase('Admin_details'); ?></span>
                </a>
            </li>
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_attendance" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-chevron-circle-right"></i>
                    <span class="menu-text"><?php echo get_phrase('manage_attendance'); ?></span>
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
            $("i:nth-child(2)", this).attr('class', $(this).data('origIconClass'));
        } else {
            $(this).data('origIconClass', $("i:nth-child(2)", this).attr('class'));
            $("i:nth-child(2)", this).attr('class', 'icon-size fa fa-reply');
        }
  });
</script>

