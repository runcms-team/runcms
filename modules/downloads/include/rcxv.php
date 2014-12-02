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
$modversion['name']        = _MI_DOWNLOADS_NAME;
$modversion['version']     = 2.03;
$modversion['description'] = _MI_DOWNLOADS_DESC;
$modversion['credits']     = '';
$modversion['license']     = '';
$modversion['official']    = 1;

// Base Info
$modversion['image']       = 'images/downloads_slogo.png';
$modversion['dirname']     = 'downloads';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'downloads_broken';
$modversion['tables'][1] = 'downloads_cat';
$modversion['tables'][2] = 'downloads_downloads';
$modversion['tables'][3] = 'downloads_mod';
$modversion['tables'][4] = 'downloads_votedata';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';

// Blocks
$modversion['blocks'][1]['file']        = 'downloads_top.php';
$modversion['blocks'][1]['name']        = _MI_DOWNLOADS_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows recently added donwload files';
$modversion['blocks'][1]['show_func']   = 'b_downloads_top_show';
$modversion['blocks'][1]['edit_func']   = 'b_downloads_top_edit';
$modversion['blocks'][1]['options']     = 'date|0|19|5|0';

$modversion['blocks'][2]['file']        = 'downloads_top.php';
$modversion['blocks'][2]['name']        = _MI_DOWNLOADS_BNAME2;
$modversion['blocks'][2]['description'] = 'Shows most downloaded files';
$modversion['blocks'][2]['show_func']   = 'b_downloads_top_show';
$modversion['blocks'][2]['edit_func']   = 'b_downloads_top_edit';
$modversion['blocks'][2]['options']     = 'hits|0|19|5|0';

// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_DOWNLOADS_SMNAME1;
$modversion['sub'][1]['url']  = 'submit.php';

$modversion['sub'][2]['name'] = _MI_DOWNLOADS_SMNAME2;
$modversion['sub'][2]['url']  = 'topten.php?hit=1';

$modversion['sub'][3]['name'] = _MI_DOWNLOADS_SMNAME3;
$modversion['sub'][3]['url']  = 'topten.php?rate=1';

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'downloads_search';

// Waiting
$modversion['hasWaiting']     = 1;
$modversion['waiting']['file'] = 'include/waiting.inc.php';
$modversion['waiting']['func'] = 'downloads_waiting';
?>
