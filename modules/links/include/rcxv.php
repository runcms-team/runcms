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
$modversion['name']        = _MI_LINKS_NAME;
$modversion['version']     = '2.0.2';
$modversion['description'] = _MI_LINKS_DESC;
$modversion['credits']     = 'Kazumi Ono<br />( http://www.mywebaddons.com/ )<br />The XOOPS Project';
$modversion['license']     = 'GNU GPLv2';
$modversion['official']    = 1;


// Base Info
$modversion['image']       = 'images/links_slogo.png';
$modversion['dirname']     = 'links';


// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

$modversion['tables'][0] = 'links_broken';
$modversion['tables'][1] = 'links_cat';
$modversion['tables'][2] = 'links_links';
$modversion['tables'][3] = 'links_mod';
$modversion['tables'][4] = 'links_votedata';


// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';


// Blocks
$modversion['blocks'][1]['file']        = 'links_top.php';
$modversion['blocks'][1]['name']        = _MI_LINKS_BNAME1;
$modvertion['blocks'][1]['description'] = 'Shows recently added web links';
$modversion['blocks'][1]['show_func']   = 'b_links_top_show';
$modversion['blocks'][1]['edit_func']   = 'b_links_top_edit';
$modversion['blocks'][1]['options']     = 'date|0|19|5|0';

$modversion['blocks'][2]['file']        = 'links_top.php';
$modversion['blocks'][2]['name']        = _MI_LINKS_BNAME2;
$modvertion['blocks'][2]['description'] = 'Shows most visited web links';
$modversion['blocks'][2]['show_func']   = 'b_links_top_show';
$modversion['blocks'][2]['edit_func']   = 'b_links_top_edit';
$modversion['blocks'][2]['options']     = 'hits|0|19|5|0';


// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_LINKS_SMNAME1;
$modversion['sub'][1]['url']  = 'submit.php';

$modversion['sub'][2]['name'] = _MI_LINKS_SMNAME2;
$modversion['sub'][2]['url']  = 'topten.php?hit=1';

$modversion['sub'][3]['name'] = _MI_LINKS_SMNAME3;
$modversion['sub'][3]['url']  = 'topten.php?rate=1';


// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'links_search';


// Waiting
$modversion['hasWaiting']     = 1;
$modversion['waiting']['file'] = 'include/waiting.inc.php';
$modversion['waiting']['func'] = 'links_waiting';
?>