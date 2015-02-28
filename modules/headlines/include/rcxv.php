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
$modversion['name']        = _MI_HEADLINES_NAME;
$modversion['version']     = '2.1.0';
$modversion['description'] = _MI_HEADLINES_DESC;
$modversion['author']      = 'Half-Dead';
$modversion['credits']     = 'E-Xoops.com, SimplePie (http://simplepie.org) ';
$modversion['license']     = 'GNU GPLv2';
$modversion['official']    = 1;
// Base Info
$modversion['image']       = 'images/headlines_slogo.png';
$modversion['dirname']     = 'headlines';
// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'headlines';
// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
// Blocks
$modversion['blocks'][1]['file']        = 'headlines.php';
$modversion['blocks'][1]['name']        = _MI_HEADLINES_BNAME;
$modversion['blocks'][1]['description'] = 'Shows headline news via XML/RSS news feed';
$modversion['blocks'][1]['show_func']   = 'b_headlines_show';
// Menu
$modversion['hasMain'] = 1;
?>