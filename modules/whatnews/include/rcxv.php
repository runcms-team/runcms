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
$modversion['version'] = '2.0.1';
$modversion['description'] = _WHATISNEW_DESC;
$modversion['author'] = 'Modifying: Michael XIII Neradkov<br>cassiuss <br>http://runcms.pocket4um.com<br>based on module by inconnueteam <br>http://www.inconnueteam.net';
$modversion['credits'] = 'Graphics - Pnooka';
$modversion['license'] = 'GNU GPLv2';
$modversion['official'] = 1;
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