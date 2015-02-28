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
$modversion['name']        = _MD_AM_BANS;
$modversion['version']     = '2.0.2';
$modversion['description'] = 'Banners Administration';
$modversion['author']      = 'Francisco Burzi ( http://phpnuke.org/ ), Half-Dead';
$modversion['credits']     = 'The MPN SE Project, E-Xoops.com, runcms.org';
$modversion['license']     = 'GNU GPLv2';
$modversion['official']    = 1;

// Base Info
$modversion['dirname'] = 'banners';
$modversion['image']   = 'images/banners_slogo.png';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'banner_items';
$modversion['tables'][1] = 'banner_clients';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';

// Menu
$modversion['hasMain'] = 1;
?>