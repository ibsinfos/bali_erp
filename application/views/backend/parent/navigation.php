<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>

<div class="navbar-default sidebar custom-sidebar-width" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head custom-sidebar-color">
            <h3 data-step="1" data-intro="<?php echo get_phrase('You will get Navigation from here!');?>" data-position='right'><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu"></span></h3> </div>

        <ul class=" nav p-r-0" id="side-menu">
            
            
            <!-- DASHBOARD -->
            <li class="p-0 menu-item-tile">
                <a href="<?php echo base_url(); ?>index.php?parents/dashboard" class="waves-effect active menu-items text-center">
                    <i class="icon-size fa fa-tachometer"></i>
                    <span class="menu-text"><?php echo get_phrase('dashboard'); ?></span>
                </a>
            </li>
            
            <!-- TEACHER -->
<?php
            
$arrModule = $this->session->userdata('arrAllLinks');
$i = 0;
foreach($arrModule as $key=>$value)
{
    if(strtolower($key) == "transport")
    {
        $arrTransport = $value;
	
    }    
    if(count($value) > 0)
    {
       // pre($arrTransport);
	?>
                      
    <?php
       
        foreach($value as $main_link => $sub_link)
        {
                 
                      foreach($sub_link as $image => $link)  
                      {      
                       
                          switch(strtolower($key))
                          {
                              case 'fees_structure' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?><?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break;  
                          case 'help' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break; 
 			case 'noticeboard' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break;
                      case 'event_calender' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break;
			case 'blogs' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break;
			case 'discussion_forum' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break; 	
                       case 'my_blogs' : 
                              ?>
                              <li class="p-0 menu-item-tile">
                                    <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>" class='waves-effect active menu-items text-center'>
                                        <i class="<?php echo $image; ?>"></i>
                                        <span class='menu-text'><?php echo get_phrase($key);?></span>
                                      </a>
                                </li>
                          <?php
                          break;  
                          
                          case 'transport': 
				if($i == 0)
				{
				?>
                            <li class="p-0 menu-item-tile has-submenu">
                                <a href='#' class='waves-effect active menu-items text-center'>
                                    <i class='fa fa-bars more'></i>
                                    <i class='<?php echo $image; ?>'></i>
                                    <span class='menu-text'><?php echo get_phrase($key);?></span>
                                </a>
                            </li>
                        
                            <ul class="nav p-r-0 list-inline">
                               <?php 
                                foreach($arrTransport as $transport_key => $transport_value )
                                {
                                    foreach($transport_value as $inner_image => $inner_link)
                                    {
                                        ?>    
                                <li class="p-0 menu-item-tile">
                                        <a href="<?php echo base_url(); ?>index.php?<?php echo $inner_link; ?>" class='waves-effect active menu-items text-center'>
                                            <i class="<?php echo $inner_image; ?>"></i>
                                            <span class='menu-text'><?php echo get_phrase($transport_key); ?></span>
                                          </a>
                                </li>
                                <?php
                                    } 
                                }
                              ?>  
                            </ul>    
                          <?php
				}
				$i = 1;	
                          break;    
                          default :
                          ?>
                          <li class="p-0 menu-item-tile has-submenu">
                            <a href='#' class='waves-effect active menu-items text-center'>
                                <i class='fa fa-bars more'></i>
                                <i class='<?php echo $image; ?>'></i>
                                <span class='menu-text'><?php echo get_phrase($key);?></span>
                            </a>
                        </li>
                    <ul class="nav p-r-0 list-inline">  
                        <?php
                          $children_of_parent = get_data_generic_fun('student','*',array(
                                         'parent_id' => $this->session->userdata('parent_id')),'result_arr');
                        foreach ($children_of_parent as $row):?>
                          <li class="p-0 menu-item-tile">
                                <a href="<?php echo base_url(); ?>index.php?<?php echo $link; ?>/<?php echo $row['student_id'];?>" class='waves-effect active menu-items text-center'>
                                    <i class="icon-size fa fa-user"></i>
                                    <span class='menu-text'><?php echo $row['name']; ?></span>
                                  </a>
                        </li> 
                       <?php 
                       
                       endforeach; 
                       echo "</ul>"; 
                       break;
                       } 
                      }     
                        
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
        $(this).find('+ ul').toggle();
        $("#side-menu").toggleClass("sub-active");
        $("#side-menu li").removeClass('active');
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
























