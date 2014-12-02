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
$modversion['name']        = _MI_PARTNERS_NAME;
$modversion['version']     = 2.01;
$modversion['description'] = _MI_PARTNERS_DESC;
$modversion['author']      = '';
$modversion['credits']     = '';
$modversion['license']     = '';
$modversion['official']    = 1;

// Base Info
$modversion['image']       = 'images/partners_slogo.png';
$modversion['dirname']     = 'partners';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'partners';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';

// Blocks
$modversion['blocks'][1]['file']        = 'partners.php';
$modversion['blocks'][1]['name']        = _MI_PARTNERS_BNAME;
$modversion['blocks'][1]['description'] = _MI_PARTNERS_DESC;
$modversion['blocks'][1]['show_func']   = 'b_partners_show';
$modversion['blocks'][1]['edit_func']   = 'b_partners_edit';
$modversion['blocks'][1]['options']     = '1|center|19';

// Menu
$modversion['hasMain'] = 1;
?>
