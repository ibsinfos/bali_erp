<table id="bgtable" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#rgb(244, 244, 244);color:#fff;">
    <td align="center" valign="top">
        <!-- container 600px -->
        <table border="0" cellpadding="0" cellspacing="0" class="container" width="600px" style="background-color: #eaeaea;color: rgb(9, 57, 103);font-family:-webkit-body;position: relative;
    float: right;
    /* margin-left: 12px; */
    padding-right: 14px;">
            <!-- HEADER -->
            <tr style="background-color:#103960;height:20%;">
                <td><img src="<?php echo $values['logo_path']; ?>" style="max-height:65px; margin-left: 10px;
                         margin-top: 4px;"> </td>
                <td align="left" style="background-color: #103960;
                    height: 33%;
                    color: #fff;
                    text-align: center;
                    padding-bottom: 8px;
                    padding-top: 15px;
                    width: 80%;
                    max-height: 63px;">
                    <h3><?php echo $values['system_name']; ?></h3><br>
                </td>
            </tr>

            <tr>
                <td align="left" style="padding-left:30px;" colspan="2" >
                    <br>
                    Dear Parent ,<br>
                    <br>
                </td>

            </tr>
            <tr>
                <td align="left"  style="padding-left:40px;" colspan="2" >
                    Your child's <?php echo isset($values['exam_name']) ? $values['exam_name'] : ''; ?> exam has been scheduled.
                </td><td></td>
            </tr>
            <tr>
                <td align="left"  style="padding-left:40px;">
                    Date of exam is <?php echo isset($values['exam_date']) ? $values['exam_date'] : ''; ?><br><br><br><br><br><br><br>
                </td>
            </tr>

            <tr>
                <td align="left" colspan="2"  style="padding-left:40px;" >
                    Thanks & Regards,<br>
                    <?php echo $values['system_title']; ?>
                </td><td></td>
            </tr>
            <tr>
                <td align="left" colspan="2"   style="padding-left:40px;">
                    <br><br><br><br>
                </td>
            </tr>
            <tr style="background-color:#103960;height:20%;">
                <td align="left" style="background-color:#103960;height:20%;color:#fff;text-align:center;padding-bottom:8px;padding-top:8px;padding-left: 12px;" >
                    <!--<a href="http://sharadtechnologies.com" style="color:#fff;"> 2016 Sharad School Management System </a>-->   
                    <?php echo $values['address']; ?>
                    <br>
                    <a href="mailto:<?php echo $values['from']; ?>" style="color: white;text-decoration: none;"><?php echo $values['from']; ?></a>


                </td>
                <td style="text-align:right;"> <table width="125px" cellspacing="0" cellpadding="0" border="0" style="float: right;" >
                        <tbody>
                            <tr>
                            <!--<td width="125" valign="middle" align="left">Follow Us</td>-->
                                <td width="31" valign="top" align="left">

                                 <a href="<?php echo $values['facebook_page']; ?>" target="_blank"><img src="<?php echo base_url() ?>/assets/images/icons/facebook.png" alt="Facebook" title="Facebook" width="23" height="23" border="0" style="display:block"></a></td>
                                <td width="31" valign="top" align="left">
                                    <a href="<?php echo $values['twitter_page']; ?>" target="_blank">
                                        <img src="<?php echo base_url() ?>/assets/images/icons/twitter.png" alt="twitter" title="twitter" width="23" height="23" border="0" style="display:block"></a></td>
                                <td width="31" valign="top" align="left">
                                    <a href="<?php echo $values['linkedin']; ?>" target="_blank"><img src="<?php echo base_url() ?>/assets/images/icons/linkedin.png" alt="Twitter" title="Twitter" width="23" height="23" border="0" style="display:block"></a></td>
                                <td width="31" valign="top" align="left">
                                    <a href="<?php echo $values['pininterest']; ?>" target="_blank"><img src="<?php echo base_url() ?>/assets/images/icons/pinterest.png" alt="pinterest" title="pinterest" width="23" height="23" border="0" style="display:block"></a></td>

                            </tr>
                        </tbody>
                    </table></td>
            </tr>
            <tr>
                <td align="left" colspan="2"  style="padding-left:40px;">


                    <!--<div class="footer-social-icons">
                    <ul class="social-icons">
                       <a href="<?php echo $values['facebook_page']; ?>" class="social-icon"> <li><img src="<?php echo base_url() ?>/assets/images/icons/facebook.png" style="max-height:30px;"></a>
                        <li><a href="<?php echo $values['twitter_page']; ?>" class="social-icon"><img src="<?php echo base_url() ?>/assets/images/icons/twitter.png" style="max-height:30px;"></a></li>
                        <li><a href="<?php echo $values['linkedin']; ?>" class="social-icon"><img src="<?php echo base_url() ?>/assets/images/icons/linkedin.png" style="max-height:30px;"></a></li>
                        <li><a href="<?php echo $values['pininterest']; ?>" class="social-icon"><img src="<?php echo base_url() ?>/assets/images/icons/pinterest.png" style="max-height:30px;"></a></li>
                       
                    </ul>
                </div> -->
                </td>
            </tr>
        </table>

        <!-- container 600px -->
    </td>
</tr>
</table>
<!-- background table -->
