<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
//main
$modversion['name'] = _WHATISNEW_NAME;
$modversion['version'] = 2;
$modversion['description'] = _WHATISNEW_DESC;
$modversion['author'] = '';
$modversion['credits'] = '';
$modversion['license'] = '';
$modversion['official'] = 0;
$modversion['image'] = 'images/whatisnew_slogo.png';
$modversion['dirname'] = 'whatnews';

// Admin things
$modversion['hasAdmin'] = 0;
$modversion['adminmenu'] = "";

// Blocks
$modversion['blocks'][1]['file'] = 'whatsnew.php';
$modversion['blocks'][1]['name'] = _WHATISNEW_NAME;
$modversion['blocks'][1]['description'] = '';
$modversion['blocks'][1]['show_func'] = 'b_whatsnew_show';

// Menu
$modversion['hasMain'] = 0;
?>