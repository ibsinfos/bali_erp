{$_sysfrm_menu}<!DOCTYPE html>


<!--
Dynamically Auto Generated Page - Do Not Edit
================================================================
Software Name: iBilling - CRM, Accounting and Invoicing Software
Version: 4.4.0
Author: Sadia Sharmin
Website: http://www.ibilling.io/
Contact: sadiasharmin3139@gmail.com
Purchase: http://codecanyon.net/item/ibilling-accounting-and-billing-software/11021678?ref=SadiaSharmin
License: You must have a valid license purchased only from envato(the above link) in order to legally use this Software.
========================================================================================================================
-->

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$_title}</title>
    <link rel="shortcut icon" href="{$app_url}sysfrm/uploads/icon/title_icon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="57x57" href="{$app_url}sysfrm/uploads/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{$app_url}sysfrm/uploads/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$app_url}sysfrm/uploads/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{$app_url}sysfrm/uploads/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$app_url}sysfrm/uploads/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{$app_url}sysfrm/uploads/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$app_url}sysfrm/uploads/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{$app_url}sysfrm/uploads/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{$app_url}sysfrm/uploads/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{$app_url}sysfrm/uploads/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{$app_url}sysfrm/uploads/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{$app_url}sysfrm/uploads/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{$app_url}sysfrm/uploads/icon/favicon-16x16.png">
    <link rel="manifest" href="{$app_url}sysfrm/uploads/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{$app_url}sysfrm/uploads/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link href="{$_theme}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{$_theme}/lib/fa/css/font-awesome.min.css" rel="stylesheet">
    <link href="{$_theme}/lib/icheck/skins/all.css" rel="stylesheet">
    <link href="{$app_url}ui/lib/css/animate.css" rel="stylesheet">
    <link href="{$app_url}ui/lib/toggle/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{$_theme}/css/style.css?ver=2.0.1" rel="stylesheet">
    <link href="{$_theme}/css/component.css?ver=2.0.1" rel="stylesheet">
    <link href="{$_theme}/css/custom.css" rel="stylesheet">

    <link href="{$app_url}ui/lib/icons/css/ibilling_icons.css" rel="stylesheet">
    <link href="{$_theme}/css/material.css" rel="stylesheet">

    <link href="{$_theme}/css/{$_c['nstyle']}.css" rel="stylesheet">

    {foreach $plugin_ui_header_admin as $plugin_ui_header_add}
        {$plugin_ui_header_add}
    {/foreach}

    {if $_c['rtl'] eq '1'}
        <link href="{$_theme}/css/bootstrap-rtl.min.css" rel="stylesheet">
        <link href="{$_theme}/css/style-rtl.min.css" rel="stylesheet">
    {/if}

    {if isset($xheader)}
        {$xheader}
    {/if}
</head>
<body class="fixed-nav {if $_c['mininav']}mini-navbar{/if}">
<section>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">

                    {$admin_extra_nav[0]}
                    <li {if $_sysfrm_menu eq 'dashboard'}class="active"{/if}><a href="{$_url}{$_c['redirect_url']}/"><i class="fa fa-th-large"></i> <span class="nav-label">{$_L['Dashboard']}</span></a></li>
                    {$admin_extra_nav[1]}
                    <li class="{if $_sysfrm_menu eq 'employees'}active{/if}">
                        <a href="#"><i class="icon-users"></i> <span class="nav-label">{'Employee List'}</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{$_url}employees/list/">{'Employees'}</a></li>
                            <li><a href="{$_url}employees/payslips/">{'View Payslip'}</a></li>
                            {foreach $sub_menu_admin['crm'] as $sm_crm}
                                {$sm_crm}
                            {/foreach}
                        </ul>
                    </li>
                    {$admin_extra_nav[1]}
                    <li class="{if $_sysfrm_menu eq 'contacts'}active{/if}">
                        <a href="#"><i class="icon-users"></i> <span class="nav-label">{'Student Account'}</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            {*<li><a href="{$_url}contacts/add/">{'Add Account'}</a></li>*}
                            <li><a href="{$_url}contacts/list/">{'Student List'}</a></li>
                            <li><a href="{$_url}contacts/groups/">{'Classes'}</a></li>
                            {foreach $sub_menu_admin['crm'] as $sm_crm}
                                {$sm_crm}
                            {/foreach}
                        </ul>
                    </li>
                    {$admin_extra_nav[2]}
                    <li class="{if $_sysfrm_menu eq 'fee-deductions'}active{/if}">
                        <a href="#"><i class="icon-users"></i> <span class="nav-label">{'Scholarship'}</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{$_url}fee-deductions/view-list/">{'View Scholarships'}</a></li>
                            <li><a href="{$_url}fee-deductions/add-deduction/">{'Add Scholarship Type'}</a></li>
                            <li><a href="{$_url}fee-deductions/ss-students-list/">{'Scholarship Students List'}</a></li>
                        </ul>
                    </li>
                    {$admin_extra_nav[3]}
                    {if $_c['accounting'] eq '1'}
                        <li class="{if $_sysfrm_menu eq 'transactions'}active{/if}">
                            <a href="#"><i class="fa fa-database"></i> <span class="nav-label">{$_L['Transactions']}</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{$_url}vendors/list">{$_L['Vendors']}</a></li>
                                <li><a href="{$_url}transactions/deposit/">{$_L['New Deposit']}</a></li>
                                <li><a href="{$_url}transactions/expense/">{$_L['New Expense']}</a></li>
                                <li><a href="{$_url}transactions/transfer/">{$_L['Transfer']}</a></li>
                                {* <li><a href="{$_url}transactions/list/">{$_L['View Transactions']}</a></li> *}
                                {*<li><a href="{$_url}generate/balance-sheet/">{'Bank Balance'}</a></li>*}
                            </ul>
                        </li>
                    {/if}
                    
                    {$admin_extra_nav[4]}
                    {*<li {if $_sysfrm_menu eq 'tasks'}class="active"{/if}><a href="{$_url}tasks/me"><i class="fa fa-tasks"></i> <span class="nav-label">Tasks</span></a></li>*}

                    {if ($_c['invoicing'] eq '1') OR ($_c['quotes'] eq '1')}
                        <li class="{if $_sysfrm_menu eq 'invoices'}active{/if}">
                            <a href="#"><i class="icon-credit-card-1"></i> <span class="nav-label">{'Manage Invoices'}</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                {if $_c['invoicing'] eq '1'}
                                    <li><a href="{$_url}invoices/list/">{'Invoices List'}{*$_L['Invoices']*}</a></li>
                                    <li><a href="{$_url}invoices/add/">{'Create New Invoice'}{*$_L['New Invoice']*}</a></li>
                                    <li><a href="{$_url}invoices/ls-by-class/">{'Invoices By Class'}{*$_L['Invoices']*}</a></li>
                                    <li><a href="{$_url}invoices/future-list/">{'Future Invoice'}{*$_L['Future Invoice']*}</a></li>
                                    <li><a href="{$_url}invoices/previous-list/">{'Previous Invoice'}{*$_L['Previous Invoice']*}</a></li>
                                    <li><a href="{$_url}invoices/due-list/">{'Invoices Dues'}</a></li>
                                {/if}
                            </ul>
                        </li>
                    {/if}
                    {$admin_extra_nav[5]}
                    {if $_c['accounting'] eq '1'}
                        <li class="{if $_sysfrm_menu eq 'accounts'}active{/if}">
                            <a href="#"><i class="fa fa-building-o"></i> <span class="nav-label">{'School Account'}</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{$_url}accounts/add/">{$_L['New Account']}</a></li>
                                <li><a href="{$_url}accounts/list/">{$_L['List Accounts']}</a></li>
                                <li><a href="{$_url}accounts/balances/">{$_L['Account_Balances']}</a></li>
                            </ul>
                        </li>
                    {/if}
                    {$admin_extra_nav[6]}
                    {if ($_c['invoicing'] eq '1') OR ($_c['quotes'] eq '1')}
                        <li class="{if $_sysfrm_menu eq 'ps'}active{/if}">
                            <a href="#"><i class="fa fa-cube"></i> <span class="nav-label">{'Fee & Charges'}</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{$_url}ps/fee-type/">{'Manage Fee Type'}</a></li>
                                <li><a href="{$_url}ps/p-list/">{'Fee List'}</a></li>
                                {if isset($_c['new_accounting']) && $_c['new_accounting'] eq 1}
                                <li><a href="{$_url}ps/fee-insta-setting/">{'Fee Collections'}</a></li>
                                {/if}
                                <li><a href="{$_url}ps/p-new/">{'Create New Fee'}</a></li>
                                {*<li><a href="{$_url}ps/s-list/">{'Charges List'}</a></li>
                                <li><a href="{$_url}ps/s-new/">{'Create New Charge'}</a></li>*}
                                {*<li><a href="{$_url}ps/one-time-fee-before-admission-list/">{'Manage Enquiry Fees'}</a></li>*}
                                {*<li><a href="{$_url}ps/one-time-fee-before-admission-add/">{'Add Enquiry Fees'}</a></li>*}
                            </ul>
                        </li>
                    {/if}
                    {$admin_extra_nav[7]}
                    {if ($user['user_type']) eq 'Admin'}
                    <li class="{if $_sysfrm_menu eq 'installments'}active{/if}" id="li_settings" >
                        <a href="#"><i class="icon-params"></i> <span class="nav-label">Installments </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{$_url}installments/school_settings/">{'School Fee Settings'}</a></li>
                            <li><a href="{$_url}installments/installment_settings/">{'Installment Settings'}</a></li>
                            <li><a href="{$_url}installments/student_installment/">{'Student Installment'}</a></li>
                        </ul>
                    </li>
                    {/if}
                    {$admin_extra_nav[8]}

                    {if $_c['accounting'] eq '1'}

                        <li class="{if $_sysfrm_menu eq 'reports'}active{/if}">
                            <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">{$_L['Reports']} </span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">

                                <li><a href="{$_url}reports/statement/">{$_L['Account Statement']}</a></li>
                                <li><a href="{$_url}reports/expense/">{'Invoice Report'}</a></li>
                                <li><a href="{$_url}reports/income/">{'Payment Reports'}</a></li>
                                <li><a href="{$_url}reports/income-vs-expense/">{'Invoice vs Payment'}</a></li>

                                <li><a href="{$_url}reports/by-date/">{$_L['Reports by Date']}</a></li>
                                {*<li><a href="{$_url}reports/cats/">{$_L['Reports by Category']}</a></li>*}
                                <li><a href="{$_url}transactions/list-income/">{$_L['All Income']}</a></li>
                                <li><a href="{$_url}transactions/list-expense/">{$_L['All Expense']}</a></li>
                                {* <li><a href="{$_url}transactions/list/">{$_L['All Transactions']}</a></li> *}

                                {foreach $sub_menu_admin['reports'] as $sm_report}
                                    {$sm_report}
                                {/foreach}
                            </ul>
                        </li>

                    {/if}


                    {$admin_extra_nav[9]}
                    {if $_c['accounting'] eq '1'}
                        <li class="{if $_sysfrm_menu eq 'non-enroll-receipt'}active{/if}">
                            <a href="#"><i class="icon-credit-card-1"></i> <span class="nav-label">{'Non Enroll Info'}</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{$_url}non-enroll-receipt/view-list/">{'Non Enroll Information'}</a></li>
                            </ul>
                        </li>
                    {/if}    

{*                    {if ($user['user_type']) eq 'Admin'}*}
{*
                        <li class="{if $_sysfrm_menu eq 'util'}active{/if}">
                            <a href="#"><i class="icon-article"></i> <span class="nav-label">{$_L['Utilities']} </span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{$_url}util/activity/">{$_L['Activity Log']}</a></li>
                                <li><a href="{$_url}util/sent-emails/">{$_L['Email Message Log']}</a></li>
                                <li><a href="{$_url}util/dbstatus/">{$_L['Database Status']}</a></li>
                                <li><a href="{$_url}util/cronlogs/">{$_L['CRON Log']}</a></li>
                                {*<li><a href="{$_url}util/integrationcode/">{$_L['Integration Code']}</a></li>*}
                            {*</ul>
                        </li>*}

{*                    {/if}*}


                    {*<li class="{if $_sysfrm_menu eq 'my_account'}active{/if}">
                        <a href="#"><i class="icon-user-1"></i> <span class="nav-label">{$_L['My Account']} </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">

                            <li><a href="{$_url}settings/users-edit/{$user['id']}/">{$_L['Edit Profile']}</a></li>
                            <li><a href="{$_url}settings/change-password/">{$_L['Change Password']}</a></li>
                            <li><a href="{$_url}logout/">{$_L['Logout']}</a></li>



                        </ul>
                    </li>*}
                    {if ($user['user_type']) eq 'Admin'}
                        <li class="{if $_sysfrm_menu eq 'settings'}active{/if}" id="li_settings">
                            <a href="#"><i class="icon-params"></i> <span class="nav-label">{$_L['Settings']} </span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{$_url}settings/app/">{$_L['General Settings']}</a></li>
{*                                <li><a href="{$_url}settings/school_perfomance/">{'School Perfomance'}</a></li>*}
                               
                                <li><a href="{$_url}settings/fee_penalty">{'Fee Penalty'}</a></li>
{*                                <li><a href="{$_url}settings/plugins/">{$_L['Plugins']}</a></li>*}
                                <li><a href="{$_url}settings/localisation/">{$_L['Localisation']}</a></li>
                                <li><a href="{$_url}settings/users/">{$_L['Manage Users']}</a></li>
                                <li><a href="{$_url}settings/pg/">{$_L['Payment Gateways']}</a></li>

                                {if $_c['accounting'] eq '1'}
                                    <!--<li><a href="{$_url}settings/expense-categories/">{*$_L['Expense Categories']}</a></li>
                                    <li><a href="{$_url}settings/income-categories/">{$_L['Income Categories']}</a></li>
                                    <li><a href="{$_url}settings/tags/">{$_L['Manage Tags']*}</a></li>-->
                                    <li><a href="{$_url}settings/pmethods/">{$_L['Payment Methods']}</a></li>
                                    <!--<li><a href="{$_url}tax/list/">{*$_L['Sales Taxes']*}</a></li>-->
                                {/if}


                                <li><a href="{$_url}settings/emls/">{$_L['Email Settings']}</a></li>
                                <li><a href="{$_url}settings/email-templates/">{$_L['Email Templates']}</a></li>
                                <li><a href="{$_url}settings/customfields/">{$_L['Custom Contact Fields']}</a></li>
                                {*<li><a href="{$_url}settings/automation/">{$_L['Automation Settings']}</a></li>*}
                                <!--<li><a href="{*$_url}settings/api/">{$_L['API Access']}</a></li>
                                {foreach $sub_menu_admin['settings'] as $sm_settings}

                                    {$sm_settings}


                                {/foreach}
                                <li><a href="{$_url}settings/features/">{$_L['Choose Features']}</a></li>
                                <li><a href="{$_url}settings/about/">{$_L['About']*}</a></li>-->
                            </ul>
                        </li>
                    {/if}
                </ul>

            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-fixed-top white-bg" role="navigation" style="margin-bottom: 0; background: #333333;">
                    <a href="{$_url}logout/">
                        <span><img class="logo" src="{$app_url}sysfrm/uploads/system/logo.png" width="40" height="40"  alt="Logo"></span>
                    </a>
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary btn-flat" href="#"><i class="fa fa-dedent"></i> </a>

                    </div>
                    <ul class="nav navbar-top-links navbar-right hidden-xs">



                        <li>
                            <!--<form class="navbar-form full-width" method="post" action="{*$_url}contacts/list/">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="{'Search Students'*}...">
                                    <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                                </div>
                            </form>-->
                        </li>

                        {*<li>*}
                        {*<a class="toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top" data-original-title="Fullscreen">*}
                        {*<i class="fa fa-arrows-alt"></i></a>*}

                        {*</li>*}

                        {*<li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" id="get_activity" href="#" aria-expanded="true">
                                <i class="fa fa-bell"></i>
                            </a><div class="dropdown-backdrop"></div>
                            <ul class="dropdown-menu dropdown-alerts" id="activity_loaded">



                                <li id="activity_wait">
                                    <div class="text-center link-block">
                                        <a href="javascript:void(0)">
                                            <strong>{$_L['Please Wait']}...</strong> <br> <br>
                                            <img class="text-center" src="{$app_url}sysfrm/uploads/system/download.gif" alt="Loading....">

                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>*}

                        <li class="dropdown navbar-user">

                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

                                {*{if $user['img'] eq 'gravatar'}
                                    <img src="http://www.gravatar.com/avatar/{($user['username'])|md5}?s=200" class="img-circle" alt="{$user['fullname']}">
                                {elseif $user['img'] eq ''}
                                    <img src="{$app_url}ui/lib/imgs/default-user-avatar.png" alt="">
                                {else}
                                    <img src="{$user['img']}" class="img-circle" alt="{$user['fullname']}">
                                {/if}*}

                                <span class="hidden-xs">{$_L['Welcome']} {$user['fullname']}</span> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu animated fadeIn">
                                <li class="arrow"></li>
{*                                <li><a href="{$_url}settings/users-edit/{$user['id']}/">{$_L['Edit Profile']}</a></li>*}
{*                                <li><a href="{$_url}settings/change-password/">{$_L['Change Password']}</a></li>*}
{*                                <li class="divider"></li>*}
                                <li><a href="{$_url}logout/">{$_L['Logout']}</a></li>

                            </ul>
                        </li>

                    </ul>

                </nav>
            </div>

            <div class="row wrapper white-bg page-heading">
                <div class="col-lg-12">
                    <h2 style="color: #2F4050; font-size: 16px; font-weight: 400; margin-top: 18px">{$_st} </h2>

                </div>

            </div>

            <div class="wrapper wrapper-content animated fadeIn">
                
                {if isset($notify)}
                {$notify}
                {/if}
