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
$modversion['name']        = _MI_NSECTIONS_NAME;
$modversion['version']     = 2.01;
$modversion['description'] = _MI_NSECTIONS_DESC;
$modversion['credits']     = '';
$modversion['author']      = '';
$modversion['license']     = '';
$modversion['official']    = 1;

// Base Info
$modversion['image']   = 'images/sections_slogo.png';
$modversion['dirname'] = 'sections';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';

// Blocks
$modversion['blocks'][1]['file']        = 'nsection_top.php';
$modversion['blocks'][1]['name']        = _MI_NSECTIONS_BNAME1;
$modversion['blocks'][1]['description'] = _MI_NSECTIONS_POP;
$modversion['blocks'][1]['show_func']   = 'b_nsection_top_show';
$modversion['blocks'][1]['edit_func']   = 'b_nsection_top_edit';
$modversion['blocks'][1]['options']     = 'counter|0|19|5';

$modversion['blocks'][2]['file']        = 'nsection_top.php';
$modversion['blocks'][2]['name']        = _MI_NSECTIONS_BNAME2;
$modversion['blocks'][2]['description'] = _MI_NSECTIONS_REC;
$modversion['blocks'][2]['show_func']   = 'b_nsection_top_show';
$modversion['blocks'][2]['edit_func']   = 'b_nsection_top_edit';
$modversion['blocks'][2]['options']     = 'date|0|19|5';

// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'nsection_search';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'nseccont';
$modversion['tables'][1] = 'nsections';
?>
