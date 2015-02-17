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
$modversion['name']        = _MI_CONTACT_NAME;
$modversion['description'] = _MI_CONTACT_DESC;
$modversion['license']     = '';
$modversion['author']      = '';
$modversion['official']    = 1;
$modversion['version']     = 2.01;

// Base Info
$modversion['dirname'] = 'contact';
$modversion['image']   = 'images/contact_logo.png';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'contact';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_CONTACT_CONT;
$modversion['sub'][1]['url']  = 'index.php?op=contact';
$modversion['sub'][2]['name'] = _MI_CONTACT_PLC;
$modversion['sub'][2]['url']  = 'index.php?op=policy';
$modversion['sub'][3]['name'] = _MI_CONTACT_LNK;
$modversion['sub'][3]['url']  = 'index.php?op=link';
?>
