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
$modversion['name']        = _MI_POLLS_NAME;
$modversion['version']     = 2.01;
$modversion['description'] = _MI_POLLS_DESC;
$modversion['author']      = '';
$modversion['credits']     = '';
$modversion['license']     = '';
$modversion['official']    = 1;

// Base Info
$modversion['image']       = 'images/poll_slogo.png';
$modversion['dirname']     = 'poll';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'poll_option';
$modversion['tables'][1] = 'poll_desc';
$modversion['tables'][2] = 'pollcomments';
$modversion['tables'][3] = 'poll_log';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';

// Blocks
$modversion['blocks'][1]['file']        = 'poll.php';
$modversion['blocks'][1]['name']        = _MI_POLLS_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows unlimited number of polls/surveys';
$modversion['blocks'][1]['show_func']   = 'b_rcxpoll_show';

// Menu
$modversion['hasMain'] = 1;
?>
