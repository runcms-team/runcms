<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Info
$modversion['name']        = _MI_SYSTEM_NAME;
$modversion['version']     = 2.01;
$modversion['description'] = _MI_SYSTEM_DESC;
$modversion['credits']     = '';
$modversion['license']     = '';
$modversion['official']    = 1;
// Base Info
$modversion['image']       = 'images/system_slogo.png';
$modversion['dirname']     = 'system';
// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin.php';
// Blocks
$modversion['blocks'][1]['file']        = 'system_user.php';
$modversion['blocks'][1]['name']        = _MI_SYSTEM_BNAME2;
$modversion['blocks'][1]['description'] = 'viser bruger block';
$modversion['blocks'][1]['show_func']   = 'b_system_user_show';
//
$modversion['blocks'][2]['file']        = 'system_login.php';
$modversion['blocks'][2]['name']        = _MI_SYSTEM_BNAME3;
$modversion['blocks'][2]['description'] = 'viser login form';
$modversion['blocks'][2]['show_func']   = 'b_system_login_show';
//
$modversion['blocks'][3]['file']        = 'system_search.php';
$modversion['blocks'][3]['name']        = _MI_SYSTEM_BNAME4;
$modversion['blocks'][3]['description'] = 'viser søgeform block';
$modversion['blocks'][3]['show_func']   = 'b_system_search_show';
//
$modversion['blocks'][4]['file']        = 'system_waiting.php';
$modversion['blocks'][4]['name']        = _MI_SYSTEM_BNAME5;
$modversion['blocks'][4]['description'] = 'viser objektet ventende på godkendelse';
$modversion['blocks'][4]['show_func']   = 'b_system_waiting_show';
//
$modversion['blocks'][5]['file']        = 'system_menu.php';
$modversion['blocks'][5]['name']        = _MI_SYSTEM_BNAME6;
$modversion['blocks'][5]['description'] = 'Viser hoved menu.';
$modversion['blocks'][5]['show_func']   = 'b_system_main_dynshow';
$modversion['blocks'][5]['edit_func']   = 'b_system_main_edit';
$modversion['blocks'][5]['options']     = '1';
//
$modversion['blocks'][6]['file']        = 'system_info.php';
$modversion['blocks'][6]['name']        = _MI_SYSTEM_BNAME7;
$modversion['blocks'][6]['description'] = 'viser basis info om site samt et anbefal os link.';
$modversion['blocks'][6]['show_func']   = 'b_system_info_show';
$modversion['blocks'][6]['edit_func']   = 'b_system_info_edit';
$modversion['blocks'][6]['options']     = '320|250|button.gif|1';
// birthday
$modversion['blocks'][7]['file']        = 'bnewscal.php';
$modversion['blocks'][7]['name']        = _MB_BDAY;
$modversion['blocks'][7]['description'] = 'Viser dagens fødselarer.';
$modversion['blocks'][7]['show_func']   = 'birthday_show';
$modversion['blocks'][7]['options'] = "1|1";
// birthday
// Menu
$modversion['hasMain'] = 0;
?>