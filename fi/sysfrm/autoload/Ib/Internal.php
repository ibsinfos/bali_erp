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

Class Ib_Internal{

    public static function get_moment_format($df){

        if($df == 'd/m/Y'){
            return 'DD/MM/YYYY';
        }

        elseif($df == 'd.m.Y'){
            return 'DD.MM.YYYY';
        }

        elseif($df == 'd-m-Y'){
            return 'DD-MM-YYYY';
        }

        elseif($df == 'm/d/Y'){
            return 'MM/DD/YYYY';
        }

        elseif($df == 'Y/m/d'){
            return 'YYYY/MM/DD';
        }

        elseif($df == 'Y-m-d'){
            return 'YYYY-MM-DD';
        }

        elseif($df == 'M d Y'){
            return 'MMM DD YYYY';
        }

        elseif($df == 'd M Y'){
            return 'DD MMM YYYY';
        }

        elseif($df == 'jS M y'){
            return 'Do MMM YY';
        }

        else{

            return 'dddd, MMMM Do YYYY';

        }

    }

}