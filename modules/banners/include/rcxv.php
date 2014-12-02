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
$modversion['version']     = 2.01;
$modversion['description'] = 'Banners Administration';
$modversion['author']      = '';
$modversion['credits']     = '';
$modversion['license']     = '';
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
