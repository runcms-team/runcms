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
$modversion['name']        = _MI_WHOSONLINE_NAME;
$modversion['version']     = '2.0.2';
$modversion['description'] = _MI_WHOSONLINE_DESC;
$modversion['credits']     = 'The XOOPS Project';
$modversion['license']     = 'GNU GPLv2';
$modversion['official']    = 1;

// Base Info
$modversion['image']   = 'images/whosonline_slogo.png';
$modversion['dirname'] = 'whosonline';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'lastseen';

// Admin
$modversion['hasAdmin'] = 0;

// Blocks
$modversion['blocks'][1]['file']        = 'whosonline.php';
$modversion['blocks'][1]['name']        = _MI_WHOSONLINE_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows users that are currently online';
$modversion['blocks'][1]['show_func']   = 'b_whosonline_show';
$modversion['blocks'][1]['edit_func']   = 'b_whosonline_edit';
$modversion['blocks'][1]['options']     = '1|10|20';

// Menu
$modversion['hasMain'] = 0;
?>