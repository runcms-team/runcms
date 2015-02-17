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
$modversion['name']        = _MI_FAQ_NAME;
$modversion['version']     = 2;
$modversion['description'] = _MI_FAQ_DESC;
$modversion['credits']     = '';
$modversion['author']      = '';
$modversion['license']     = '';
$modversion['official']    = 1;

// Base Info
$modversion['image']   = 'images/faq_logo.png';
$modversion['dirname'] = 'faq';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'faq_contents';
$modversion['tables'][1] = 'faq_categories';

// Blocks
$modversion['blocks'][1]['file']        = 'faq.php';
$modversion['blocks'][1]['name']        = _MI_FAQ_BNAME;
$modversion['blocks'][1]['description'] = _MI_FAQ_BDESC;
$modversion['blocks'][1]['show_func']   = 'b_faq_show';
$modversion['blocks'][1]['edit_func']   = 'b_faq_edit';
$modversion['blocks'][1]['options']     = '0|19|5';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Main contents
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'faq_search';

?>
