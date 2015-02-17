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
$modversion['name']        = _MI_FORUM_NAME;
$modversion['version']     = 2.02;
$modversion['description'] = _MI_FORUM_DESC;
$modversion['credits']     = '';
$modversion['author']      = '';
$modversion['license']     = '';
$modversion['official']    = 0;

// Base Info
$modversion['image']       = 'images/forum_slogo.png';
$modversion['dirname']     = 'forum';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

$modversion['tables'][0]  = 'forum_categories';
$modversion['tables'][1]  = 'forum_forum_access';
$modversion['tables'][2]  = 'forum_forum_mods';
$modversion['tables'][3]  = 'forum_forums';
$modversion['tables'][4]  = 'forum_posts';
$modversion['tables'][5]  = 'forum_topics';
$modversion['tables'][6]  = 'forum_forum_group_access';
$modversion['tables'][7]  = 'forum_whosonline';
$modversion['tables'][8]  = 'forum_poll_desc';
$modversion['tables'][9]  = 'forum_poll_log';
$modversion['tables'][10] = 'forum_poll_option';
$modversion['tables'][11] = 'forum_topics_mail';
$modversion['tables'][12] = 'forum_attachments';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_FORUM_RECENT;
$modversion['sub'][1]['url']  = 'topten.php';

$modversion['sub'][2]['name'] = _MI_FORUM_VIEWED;
$modversion['sub'][2]['url']  = 'topten.php?op=1';

$modversion['sub'][3]['name'] = _MI_FORUM_ACTIVE;
$modversion['sub'][3]['url']  = 'topten.php?op=2';

$modversion['sub'][4]['name'] = _MI_FORUM_ARCHIVE;
$modversion['sub'][4]['url']  = 'archive.php';
/// to 2m3
$modversion['sub'][5]['name'] = _MI_FORUM_VIEWSINCE;
$modversion['sub'][5]['url']  = 'lastforum.php';

// Blocks
$modversion['blocks'][1]['file']        = 'forum_new.php';
$modversion['blocks'][1]['name']        = _MI_FORUM_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows recent topics in the forums';
$modversion['blocks'][1]['show_func']   = 'b_forum_new_show';
$modversion['blocks'][1]['options']     = '0|1|1|1|1|33|19|5|1|0';
$modversion['blocks'][1]['edit_func']   = 'b_forum_new_edit';

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'forum_search';

?>