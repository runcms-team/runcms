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
$modversion['name']        = _MI_MEMBERS_NAME;
$modversion['version']     = '2.0.1';
$modversion['description'] = _MI_MEMBERS_DESC;
$modversion['credits']     = 'The XOOPS Project';
$modversion['author']      = 'Kazumi Ono<br />( http://www.myweb.ne.jp/ )';
$modversion['license']     = 'GNU GPLv2';
$modversion['official']    = 1;

// Base Info
$modversion['image']   = 'images/members_slogo.png';
$modversion['dirname'] = 'members';

// Admin
$modversion['hasAdmin'] = 0;

// Menu
$modversion['hasMain'] = 1;

// Blocks
$modversion['blocks'][1]['file']        = 'members_posters.php';
$modversion['blocks'][1]['name']        = _MI_MEMBERS_BNAME1;
$modversion['blocks'][1]['description'] = 'Top posters';
$modversion['blocks'][1]['show_func']   = 'b_members_posters_show';
$modversion['blocks'][1]['options']     = '10|1';
$modversion['blocks'][1]['edit_func']   = 'b_members_posters_edit';

$modversion['blocks'][2]['file']        = 'members_new.php';
$modversion['blocks'][2]['name']        = _MI_MEMBERS_BNAME2;
$modversion['blocks'][2]['description'] = 'Shows most recent users';
$modversion['blocks'][2]['show_func']   = 'b_members_new_show';
$modversion['blocks'][2]['options']     = '10|1';
$modversion['blocks'][2]['edit_func']   = 'b_members_new_edit';
?>