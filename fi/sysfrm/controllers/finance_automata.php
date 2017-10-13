<?php
@ini_set('memory_limit', '512M');
@ini_set('max_execution_time', 0);
@set_time_limit(0);
        $msg = '';
        $email = $_POST['toemail'];
        $cc = $_POST['ccemail'];
        $bcc = $_POST['bccemail'];
        $subject = $_POST['subject'];
        $toname = $_POST['toname'];
        $cid = $_POST['i_cid'];
        $iid = $_POST['i_iid'];

        $d = ORM::for_table('sys_invoices')->find_one($iid);

        if($d['cn'] != ''){
            $dispid = $d['cn'];
        }
        else{
            $dispid = $d['id'];
        }

        $in = $d['invoicenum'].$dispid;

        $message = $_POST['message'];

        $attach_pdf = 'Yes';

        $attachment_path = '';
        $attachment_file = '';

        if($attach_pdf == 'Yes'){

            Invoice::pdf($iid,'store',array('CompanyName'=>'Sharad Techs','pdf_font' => 'default') );

            $attachment_path = 'sysfrm/uploads/_sysfrm_tmp_/Invoice_'.$in.'.pdf';
            $attachment_file = 'Invoice_'.$in.'.pdf';




        }

        if (!Validator::Email($email)) {
            $msg .= 'Invalid Email <br>';
        }

        if (!Validator::Email($cc)) {
            $cc = '';
        }

        if (!Validator::Email($bcc)) {
            $bcc = '';
        }


        if ($subject == '') {
            $msg .= 'Subject is Required <br>';
        }

        if ($message == '') {
            $msg .= 'Message is Required <br>';
        }

        if ($msg == '') {

            //now send email

            Notify_Email::_send($toname, $email, $subject, $message, $cid, $iid, $cc, $bcc, $attachment_path, $attachment_file);

            // Now check for

            echo '<div class="alert alert-success fade in">Mail Sent!</div>';
        } else {
            echo '<div class="alert alert-danger fade in">' . $msg . '</div>';
        }


?>