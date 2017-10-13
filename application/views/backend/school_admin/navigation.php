<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
<?php
?>
<div class="navbar-default sidebar custom-sidebar-width" role="navigation">
    <div class="sidebar-nav"><!--slimscrollsidebar-->
        <div class="sidebar-head custom-sidebar-color">
            <h3 data-step="1" data-intro="<?php echo get_phrase('You will get Navigation from here!');?>" data-position='right'><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span></h3> </div>

            <ul class=" nav p-r-0" id="side-menu">
                <li class="p-0 menu-item-tile">
                    <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard" class="waves-effect active menu-items text-center">
                        <i class="icon-size fa fa-tachometer"></i>
                        <span class="menu-text"><?php echo get_phrase('dashboard'); ?></span>
                    </a>
                </li>

                <?php get_session_links($this->session->userdata('session_link_id'));
                //pre($arrModule);exit;
                /* $arrModule = $arrModule?$arrModule:array();
                foreach($arrModule as $key=>$value)
                {
                    if(count($value) > 1)
                    {
                        $imgArr = array();
                        $keyArr = explode("?", $key);
                        if(strstr($keyArr[1], ","))
                        {
                            $imgArr = explode(",", $keyArr[1]);
                        }?>

                        <li class="p-0 menu-item-tile has-submenu">
                            <a href='#' class='waves-effect active menu-items text-center'>
                                <i class='<?php echo  $imgArr[0]; ?>'></i>
                                <i class='<?php echo  $imgArr[1]; ?>'></i>
                                <span class='menu-text'><?php echo get_phrase($keyArr[0]);?></span>
                            </a>
                        </li>
                        <ul class="nav p-r-0 list-inline">
                        <?php
                        foreach($value as $main_link => $sub_link)
                        {
                            foreach($sub_link as $image => $value){?>
                                <li class="p-0 menu-item-tile">
                                    <a href='<?php echo base_url(); ?>index.php?<?php echo $value;?>' class='waves-effect active menu-items text-center'>
                                        <i class='<?php echo $image;?>'></i>
                                        <span class='menu-text'><?php echo get_phrase($main_link);?></span>
                                    </a>
                                </li>  
                            <?php
                            }
                        }  
                        echo "</ul>";
                    }
                    else
                    {
                        foreach($value as $main_link => $sub_link)
                        {
                            foreach($sub_link as $image => $link){?>
                                <li class="p-0 menu-item-tile <?php if(strtolower($main_link) == 'hrm' || strtolower($main_link) == 'accounting') { echo 'hidden-xs'; } ?>">
                                    <?php if(strtolower($main_link) == 'hrm') { ?>
                                        <a href='<?php echo base_url(); ?><?php echo $link; ?>' class='waves-effect active menu-items text-center'>
                                    <?php } else { ?>
                                        <a href='<?php echo base_url(); ?>index.php?<?php echo $link; ?>' class='waves-effect active menu-items text-center'>
                                    <?php } ?>
                                        <i class='<?php echo $image; ?>'></i>
                                        <span class='menu-text'><?php echo get_phrase($main_link); ?></span>
                                    </a>
                                </li>               
                      <?php }
                        }    
                    }  
                } */
                ?>
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
    } else { 
        $("#page-wrapper").css('opacity', '1'); 
    }
    $('.sidebar').toggleClass('side_menu1');
    $('body').toggleClass('overflow-toggle');
});

$('body').click(function(e){
    // check click was iside navigation or outside
    // if outside navigation then hide navigation
    // else do nothing
    if ($('.sidebar').has(e.target).length === 0 && $('.menu_in_mobile').has(e.target).length === 0) {
        $("#side-menu").hide();
        $('.sidebar').removeClass('side_menu1');
        $("#page-wrapper").css('opacity', '1');
        $('body').removeClass('overflow-toggle');
    }
});
    
$('#side-menu li.has-submenu + ul').css('display', 'none');
$("#side-menu li.has-submenu").on('click', function() {
    $('#side-menu li').removeClass('active');
    $(this).find('+ ul').toggle();
    $(this).parent('ul').toggleClass("sub-active");
    if($(this).parent('ul').hasClass('sub-active')==false){
        prevLi = $(this).parent('ul').prev('li');
        prevLi.addClass('active');
        
        prevLi.data('origIconClass', $("i:nth-child(2)", prevLi).attr('class'));
        $("i:nth-child(2)", prevLi).attr('class', 'icon-size fa fa-reply').css('margin-top', '55px');
        $(".icon-size.fa.fa-reply + .menu-text").hide();
    }
    $(this).addClass('active');
});
    //After clicking on menu if it has submenu then menu tile showing back icon
$('#side-menu li.has-submenu a').click(function() {
    if ($("i:nth-child(2)", this).hasClass('fa-reply')) {
        $(".icon-size.fa.fa-reply + .menu-text").show();
        $("i:nth-child(2)", this).attr('class', $(this).data('origIconClass')).css('margin-top', '35px');
    } else {
        $(this).data('origIconClass', $("i:nth-child(2)", this).attr('class'));
        $("i:nth-child(2)", this).attr('class', 'icon-size fa fa-reply').css('margin-top', '55px');
        $(".icon-size.fa.fa-reply + .menu-text").hide();
    }
});
</script>