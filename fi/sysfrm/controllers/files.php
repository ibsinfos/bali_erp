<?php
// *************************************************************************
// *                                                                       *
// * iBilling -  Accounting, Billing Software                              *
// * Copyright (c) Sadia Sharmin. All Rights Reserved                      *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: sadiasharmin3139@gmail.com                                                *
// * Website: http://www.sadiasharmin.com                                  *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************
//it will handle all settings
_auth();
$ui->assign('_title', $_L['Settings'].'- '. $config['CompanyName']);
$ui->assign('_pagehead', '<i class="fa fa-cogs lblue"></i> Settings');
$ui->assign('_st', $_L['Settings']);
$ui->assign('_sysfrm_menu', 'settings');

$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);

//use Symfony\Component\Filesystem\Filesystem;
//use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
//
//$fs = new Filesystem();

switch($action){






    case 'create_htaccess':


//        if($fs->exists('.htaccess') == false){
//
//        }

        $htaccess = 'RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?ng=$1 [L,QSA]';

//        if($fs->exists('.htaccess')) {
//
//            ib_die('.htaccess file exist');
//
//        }
//
//        else{
//
//            try {
//                $fs->dumpFile('.htaccess', $htaccess);
//                echo 'ok';
//            } catch (IOExceptionInterface $e) {
//                echo "An error occurred while creating file at ".$e->getPath();
//            }
//        }

        ib_die('An Error Occurred.');



        break;

    case 'remove_htaccess':


        update_option('url_rewrite',0);

//        try {
//            $fs->remove(array('.htaccess'));
//        } catch (IOExceptionInterface $e) {
//            echo "An error occurred while removing the file.";
//        }




        break;

    default:
        echo 'action not defined';


}