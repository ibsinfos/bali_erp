<?php
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
$text_align = $this->db->get_where('settings', array('type' => 'text_align'))->row()->description;
$account_type = $this->session->userdata('login_type');
$skin_colour = $this->db->get_where('settings', array('type' => 'skin_colour'))->row()->description;
$active_sms_service = $this->db->get_where('settings', array('type' => 'active_sms_service'))->row()->description;
$running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

?>
<!DOCTYPE html>
<html lang="en" dir="<?php if (isset($text_align) && $text_align == 'right-to-left') echo 'rtl'; ?>">
    <head>
        <title><?php echo $page_title; ?> | <?php echo $system_title; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Ekattor School Manager Pro - Creativeitem" />
        <meta name="author" content="Creativeitem" />

        <?php include 'includes_top.php'; ?>

    </head>
    <body class="fix-sidebar">
        
        <div id="wrapper">
            <?php include 'header.php'; ?>
            
            <?php  if(in_array($account_type, array('cashier', 'accountant'))){
                    $this->load->view('backend/school_admin/fees/'.$account_type.'/navigation');
                    }else if($account_type!=''){
                        include $account_type . '/navigation.php';
                    }
            ?>
            <?php //include $account_type . '/nav_fi.php'; ?>
 
            <div id="page-wrapper" style="min-height: 245px;">
                <div class="container-fluid">
                    <?php if(isset($design_certificate)){
                            $this->load->view('backend/certificate/'.$page_name);
                        } else if(in_array($account_type, array('cashier', 'accountant')) || (@$error_type=='db_error')){
                            $this->load->view('backend/school_admin/'.$page_name);
                        }else if($account_type!=''){
                            //include $account_type . '/' . $page_name . '.php';
                            $this->load->view('backend/'.$account_type.'/'.$page_name);
                        } else {
                            $this->load->view('backend/'.$page_name);
                        }
                    ?>
                </div> 
            </div>
            <?php include 'footer.php'; ?>
            
            <!-- start right sidebar -->
            <!-- ============================================================== -->
            <div class="right-sidebar">
                <div class="slimscrollright">
                    <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                    <div class="r-panel-body">
                        <ul id="themecolors" class="m-t-20">
                            <li><b>With Light sidebar</b></li>
                            <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                            <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                            <li><a href="javascript:void(0)" data-theme="gray" class="yellow-theme">3</a></li>
                            <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                            <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                            <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                            <li class="full-width"><b>With Dark sidebar</b></li>
                            <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                            <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                            <li><a href="javascript:void(0)" data-theme="gray-dark" class="yellow-dark-theme">9</a></li>
                            <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme working">10</a></li>
                            <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                            <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme">12</a></li>
                        </ul>
                
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end right sidebar -->
        </div>
        <?php include 'modal.php'; ?>
        
        <?php include 'includes_bottom.php'; ?>
       
        <!--for laoder-->
        <div class="spinner"></div>
    </body>
</html>