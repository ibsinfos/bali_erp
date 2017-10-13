<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
<?php
?>
<div class="navbar-default sidebar custom-sidebar-width" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head custom-sidebar-color">
            <h3 data-step="1" data-intro="<?php echo get_phrase('You will get Navigation from here!.');?>" data-position='right'><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3> </div>

        <ul class=" nav p-r-0" id="side-menu">
             <!-- DASHBOARD -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-tachometer"></i>
                    <span class="menu-text"><?php echo get_phrase('dashboard'); ?></span>
                </a>
            </li>
<?php
$this->session->userdata('arrModule');
foreach($arrModule as $key=>$value)
{
    if(count($value) > 1)
    {
        ?>
                      <li class="p-0 menu-item-tile has-submenu">
                        <a href='#' class='waves-effect active menu-items text-center'>
                            <i class='fa fa-bars more'></i>
                            <i class='icon-size fa fa-graduation-cap'></i>
                            <span class='menu-text'><?php echo get_phrase($key);?></span>
                        </a>
                    </li>
                    <ul class="nav p-r-0 list-inline">
    <?php
        foreach($value as $main_link => $sub_link)
        {
            ?>
                        <li class="p-0 menu-item-tile">
                                <a href='<?php echo base_url(); ?>index.php?<?php echo $sub_link; ?>' class='waves-effect active menu-items text-center'>
                                    <i class='icon-size fa fa-book'></i>
                                    <span class='menu-text'><?php echo get_phrase($main_link); ?></span>
                                  </a>
                            </li>  
         <?php
        }    
        echo "</ul>";
    }
    else
    {
        foreach($value as $main_link => $sub_link)
        {
            ?>
              <li class="p-0 menu-item-tile">
                                <a href='<?php echo base_url(); ?>index.php?<?php echo $sub_link; ?>' class='waves-effect active menu-items text-center'>
                                    <i class='icon-size fa fa-book'></i>
                                    <span class='menu-text'><?php echo get_phrase($main_link); ?></span>
                                  </a>
               </li>               
        <?php    
        }    
    }    
}    

?>
 
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
  
//        $("#side-menu").focus();
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
