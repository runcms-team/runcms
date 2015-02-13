<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_forum_new_show($options) {
global $db, $myts, $rcxConfig, $rcxUser, $bbPath, $bbTable;

include_once RCX_ROOT_PATH.'/modules/forum/config.php';
include_once RCX_ROOT_PATH.'/modules/forum/functions.php';
include_once RCX_ROOT_PATH.'/modules/forum/class/class.permissions.php';

$uid   = $rcxUser ? $rcxUser->uid() : 0;
$block = array();
$block['title'] = _MB_FORUM_RECENT;

$extra = '';
$from_forum = intval($options[9]);
if (!empty($from_forum)) {
        $extra .= " AND f.forum_id = $from_forum";
}

$from_cat = intval($options[10]);
if (!empty($from_cat)) {
        $extra .= " AND f.cat_id = $from_cat";
}

$sql = "
        SELECT
        p.uid,
        p.topic_id,
        p.forum_id,
        p.post_time,
        p.icon,
        t.topic_title,
        t.topic_views,
        t.topic_replies,
        t.forum_id,
        f.forum_name
        FROM
        ".$bbTable['posts']." p,
        ".$bbTable['forums']." f,
        ".$bbTable['topics']." t  
        WHERE t.topic_last_post_id = p.post_id
        AND f.forum_id = t.forum_id
        $extra
        GROUP BY p.topic_id
        ORDER BY t.topic_time DESC";

if ( empty($options[7]) || !is_numeric($options[7]) ) {
        $options[7] = 5;
}

if ( !$query = $db->query($sql) ) {
        echo "ERROR: $sql<br />".$db->error();
}

if ( $db->num_rows($query) > 0 ) {
        $block['content']  = '<table border="0" cellpadding="0" cellspacing="0"  width="100%" class="bg2"><tr><td><table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="bg3">';

        // Show Posticon?
        if ( $options[8] == 1) {
                $block['content'] .= '<td align="center">&nbsp;</td>';
        }

        // Show Forum?
        if ( $options[4] == 1 ) {
                $block['content'] .= '<td align="center"><b>'._MB_FORUM_FORUM.'</b></td>';
        }

        $block['content'] .= '<td align="center"><b>'._MB_FORUM_TOPIC.'</b></td>';

        // Show Replies?
        if ( $options[2] == 1 ) {
                $block['content'] .= '<td align="center"><b>'._MB_FORUM_RPLS.'</b></td>';
        }

        // Show Views?
        if ( $options[3] == 1 ) {
                $block['content'] .= '<td align="center"><b>'._MB_FORUM_VIEWS.'</b></td>';
        }

        // Show Time || Poster?
        if ( $options[1] == 1 || $options[0] == 1 ) {
                $block['content'] .= '<td align="center"><b>'._MB_FORUM_LPOST.'</b></td>';
        }

        $block['content'] .= '</tr>';

        if ( empty($options[5]) || !is_numeric($options[5]) ) {
                $options[5] = 33;
        }

        if ( empty($options[6]) || !is_numeric($options[6]) ) {
                $options[6] = 19;
        }

        $display_count = 0;
		while ( list($userid, $topicid, $forumid, $time, $icon, $title, $views, $replies, $tforumid, $forumname) = $db->fetch_row($query))
        {
                if($display_count == $options[7])
                        break;

                $permissions = new Permissions($forumid);

                if($permissions->can_view == 0)
                        continue;

                $forumname  = $myts->makeTboxData4Show($forumname);
                $title      = $myts->makeTareaData4Show($title);
                $time       = formatTimestamp($time, "m");
                $full_title = $title;
                if ( strlen($title) > $options[5] ) {
                        $title = substr($title, 0, $options[5])."..";
                }

                $block['content'] .= '<tr class="bg1">';

        // Show Posticon?
        if ( $options[8] == 1 ) {
                if ($icon) {
                        $block['content'] .= '<td><img src="'.RCX_URL.'/images/subject/'.$icon.'" alt="'.$icon.'" /></td>';
                        } else {
                                $block['content'] .= '<td><img src="'.RCX_URL.'/images/subject/icon1.gif" alt="icon" /></td>';
                        }
        }

        // Show Forum?
        if ( $options[4] == 1 ) {
                $block['content'] .= '<td><a href="'.$bbPath['url'].'viewforum.php?forum='.$forumid.'">'.$forumname.'</a></td>';
        }

        $block['content'] .= '<td><a href="'.$bbPath['url'].'viewtopic.php?topic_id='.$topicid.'&amp;forum='.$forumid.'" title="'.htmlentities($full_title, RCX_ENT_FLAGS, RCX_ENT_ENCODING).'">'.$title.'</a></td>';

        // Show Replies?
        if ( $options[2] == 1 ) {
                $block['content'] .= '<td align="center">'.$replies.'</td>';
        }

        // Show Views?
        if ( $options[3] == 1 ) {
                $block['content'] .= '<td align="center">'.$views.'</td>';
                }

        // Show Time || Poster?
        if ( $options[1] == 1 || $options[0] == 1 ) {
                $block['content'] .= '<td align="right">';

                if ( $options[0] == 1 ) {
                        $poster = new RcxUser($userid);
                        !$poster->uname() ? $postername = $rcxConfig['anonymous'] : $postername = $poster->uname();
                        $postername = $myts->makeTboxData4Show($postername);
                        if ( strlen($postername) > $options[6] ) {
                                $postername = substr($postername, 0, $options[6])."..";
                                }
                        $block['content'] .= '<b>'.$postername.'</b><br />';
                        }

                if ( $options[1] == 1 && $options[0] == 1 ) {
                        $block['content'] .= '<i>';
                        }

                if ( $options[1] == 1 ) {
                        $block['content'] .= $time;
                        }
                if ( $options[1] == 1 && $options[0] == 1 ) {
                        $block['content'] .= '</i>';
                        }

                $block['content'] .= '</td>';
                $block['content'] .= '</tr>';
                }
                $display_count++;
        } // END WHILE

        $block['content'] .= '</table></td></tr><tr class="bg4"><td align="right"><span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;<b><a href="'.$bbPath['url'].'">'._MB_FORUM_VSTFRMS.'</a></b></td></tr></table>';
        } else {
                $block = false;
        }

return $block;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function b_forum_new_edit($options) {
global $db, $myts;

include RCX_ROOT_PATH.'/modules/forum/config.php';

$form  = '<table>';

// SHOW POSTER
if ($options[0] == 1) {
        $chk1 = "checked='checked'";
        $chk0 = '';
        } else {
                $chk0 = "checked='checked'";
                $chk1 = '';
        }
$form .= '<tr><td>'._MB_FORUM_SPOSTER.'</td><td>&nbsp;'._NO.'<input type="radio" class="radio" name="options[0]" value="0" '.$chk0.'>'._YES.'<input type="radio" name="options[0]" value="1" '.$chk1.'></td></tr>';

// SHOW TIME
if ($options[1] == 1) {
        $chk1 = "checked='checked'";
        $chk0 = '';
        } else {
                $chk0 = "checked='checked'";
                $chk1 = '';
        }
$form .= '<tr><td>'._MB_FORUM_STIME.'</td><td>&nbsp;'._NO.'<input type="radio" class="radio" name="options[1]" value="0" '.$chk0.'>'._YES.'<input type="radio" name="options[1]" value="1" '.$chk1.'></td></tr>';

// SHOW REPLIES
if ($options[2] == 1) {
        $chk1 = "checked='checked'";
        $chk0 = '';
        } else {
                $chk0 = "checked='checked'";
                $chk1 = '';
        }
$form .= '<tr><td>'._MB_FORUM_SREPLIES.'</td><td>&nbsp;'._NO.'<input type="radio" class="radio" name="options[2]" value="0" '.$chk0.'>'._YES.'<input type="radio" name="options[2]" value="1" '.$chk1.'></td></tr>';

// SHOW VIEWS
if ($options[3] == 1) {
        $chk1 = "checked='checked'";
        $chk0 = '';
        } else {
                $chk0 = "checked='checked'";
                $chk1 = '';
        }
$form .= '<tr><td>'._MB_FORUM_SVIEWS.'</td><td>&nbsp;'._NO.'<input type="radio" class="radio" name="options[3]" value="0" '.$chk0.'>'._YES.'<input type="radio" name="options[3]" value="1" '.$chk1.'></td></tr>';


// SHOW FORUM
if ($options[4] == 1) {
        $chk1 = "checked='checked'";
        $chk0 = '';
        } else {
                $chk0 = "checked='checked'";
                $chk1 = '';
        }
$form .= '<tr><td>'._MB_FORUM_SFORUM.'</td><td>&nbsp;'._NO.'<input type="radio" class="radio" name="options[4]" value="0" '.$chk0.'>'._YES.'<input type="radio" name="options[4]" value="1" '.$chk1.'></td></tr>';

// TRIM TOPIC
$form .= '<tr><td>'._MB_FORUM_TTOPIC.'</td><td><input type="text" class="text" name="options[5]" value="'.$options[5].'" size="3"></td></tr>';

// TRIM POSTER
$form .= '<tr><td>'._MB_FORUM_TPOSTER.'</td><td><input type="text" class="text" name="options[6]" value="'.$options[6].'" size="3"></td></tr>';

// LIMIT TO
$form .= '<tr><td>'._MB_FORUM_LIMIT.'</td><td><input type="text" class="text" name="options[7]" value="'.$options[7].'" size="3"></td></tr>';

// SHOW POSTICON?
if ($options[8] == 1) {
        $chk1 = "checked='checked'";
        $chk0 = '';
        } else {
                $chk0 = "checked='checked'";
                $chk1 = '';
        }
$form .= '<tr><td>'._MB_FORUM_SICON.'</td><td>&nbsp;'._NO.'<input type="radio" class="radio" name="options[8]" value="0" '.$chk0.'>'._YES.'<input type="radio" name="options[8]" value="1" '.$chk1.'></td></tr>';

$result = $db->query("SELECT forum_id, forum_name FROM ".$bbTable['forums']."");
if ($result) {
        $form .= '<tr><td>'._MB_FORUM_FORUM.'</td><td><select class="select" name="options[9]"><option value="0">'._ANY.'</option>';
        while (list($fid, $fname) = $db->fetch_row($result)) {
                $chk = ($options[9] == $fid) ? " selected" : "";
                $form .= '<option value="'.$fid.'"'.$chk.'>'.$myts->makeTboxData4PreviewInForm($fname).'</option>';
        }
        $form .= '</select></td></tr>';
}

$result = $db->query("SELECT cat_id, cat_title FROM ".$bbTable['categories']."");
if ($result) {
        $form .= '<tr><td>'._MB_FORUM_CATEGORY.'</td><td><select class="select" name="options[10]"><option value="0">'._ANY.'</option>';
        while (list($cid, $cname) = $db->fetch_row($result)) {
                $chk = ($options[10] == $cid) ? " selected" : "";
                $form .= '<option value="'.$cid.'"'.$chk.'>'.$myts->makeTboxData4PreviewInForm($cname).'</option>';
        }
        $form .= '</select></td></tr>';
}

$form .= '</table>';

return $form;
}

?>