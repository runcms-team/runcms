<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Module Info
$modversion['name']        = _MI_PMS_NAME;
$modversion['description'] = _MI_PMS_DESC;
$modversion['author']      = 'Half-Dead';
$modversion['credits']     = 'E-Xoops.com';
$modversion['license']     = 'GNU GPLv2';
$modversion['version']     = '2.0.3';
$modversion['official']    = 1;

// Base Info
$modversion['dirname'] = 'pm';
$modversion['image']   = 'images/pm_logo.png';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'pm_msgs';
$modversion['tables'][1] = 'pm_msgs_config';


// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

// Blocks
$modversion['blocks'][1]['name']        = _MI_PMBLOCK_NAME;
$modversion['blocks'][1]['description'] = _MI_PMBLOCK_DESC;
$modversion['blocks'][1]['file']        = 'pmblock.php';
$modversion['blocks'][1]['show_func']   = 'b_ppm_show';
?>