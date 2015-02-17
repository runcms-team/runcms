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
$modversion['name']        = _MI_NEWS_NAME;
$modversion['version']     = 2.02;
$modversion['description'] = _MI_NEWS_DESC;
$modversion['credits']     = '';
$modversion['license']     = '';
$modversion['official']    = 1;

// Base Info
$modversion['image']       = 'images/news_slogo.png';
$modversion['dirname']     = 'news';

// SQL
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'comments';
$modversion['tables'][1] = 'stories';
$modversion['tables'][2] = 'topics';

// Admin
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Blocks
$modversion['blocks'][1]['file']        = 'news_topics.php';
$modversion['blocks'][1]['name']        = _MI_NEWS_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows news topics';
$modversion['blocks'][1]['show_func']   = 'b_news_topics_show';

$modversion['blocks'][2]['file']        = 'news_bigstory.php';
$modversion['blocks'][2]['name']        = _MI_NEWS_BNAME3;
$modversion['blocks'][2]['description'] = 'Shows most read story of the day';
$modversion['blocks'][2]['show_func']   = 'b_news_bigstory_show';

$modversion['blocks'][3]['file']        = 'news_top.php';
$modversion['blocks'][3]['name']        = _MI_NEWS_BNAME4;
$modversion['blocks'][3]['description'] = 'Shows top read news articles';
$modversion['blocks'][3]['show_func']   = 'b_news_top_show';
$modversion['blocks'][3]['edit_func']   = 'b_news_top_edit';
$modversion['blocks'][3]['options']     = 'counter|0|19|5|0';

$modversion['blocks'][4]['file']        = 'news_top.php';
$modversion['blocks'][4]['name']        = _MI_NEWS_BNAME5;
$modversion['blocks'][4]['description'] = 'Shows recent articles';
$modversion['blocks'][4]['show_func']   = 'b_news_top_show';
$modversion['blocks'][4]['edit_func']   = 'b_news_top_edit';
$modversion['blocks'][4]['options']     = 'published|0|19|5|0';

$modversion['blocks'][5]['file']        = 'news_kort.php';
$modversion['blocks'][5]['name']        = _MI_NEWS_BNAME6;
$modversion['blocks'][5]['description'] = 'vis kort teasser';
$modversion['blocks'][5]['show_func']   = 'b_news_kort_show';
$modversion['blocks'][5]['edit_func']   = 'b_news_kort_edit';
$modversion['blocks'][5]['options']     = 'published|0|99|5|0';

$modversion['blocks'][6]['file']        = 'news_comments.php';
$modversion['blocks'][6]['name']        = _MI_NEWS_BNAME7;
$modversion['blocks'][6]['description'] = 'Shows recent comments';
$modversion['blocks'][6]['show_func']   = 'b_news_comments_show';
$modversion['blocks'][6]['edit_func']   = 'b_news_comments_edit';
$modversion['blocks'][6]['options']     = '0|1|19|5';

$modversion['blocks'][7]['file'] = 'news_lysavis.php';
$modversion['blocks'][7]['name'] = _MI_NEWS_BNAME8;
$modversion['blocks'][7]['description'] = _MI_DESCBLOCK;
$modversion['blocks'][7]['show_func'] = 'b_LysAvis_show';
$modversion['blocks'][7]['edit_func'] = 'b_LysAvis_edit';
$modversion['blocks'][7]['options'] = '15|25|50';




// Menu
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_NEWS_SMNAME1;
$modversion['sub'][1]['url']  = 'submit.php';

$modversion['sub'][2]['name'] = _MI_NEWS_SMNAME2;
$modversion['sub'][2]['url']  = 'archive.php';

$modversion['sub'][3]['name'] = _MI_NEWS_SMNAME3;
$modversion['sub'][3]['url']  = 'topics.php';
// Søg
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'news_search';
// venter
$modversion['hasWaiting']     = 1;
$modversion['waiting']['file'] = 'include/waiting.inc.php';
$modversion['waiting']['func'] = 'news_waiting';
// Comments
$modversion['hasComment']       = 1;
$modversion['comment']['table'] = 'comment';
$modversion['comment']['item']  = 'storyid';

?>
