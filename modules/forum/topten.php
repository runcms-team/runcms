<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/


/*include_once("../../mainfile.php");
include_once("./config.php");
include_once("functions.php");
include_once("class/class.permissions.php");*/
include_once('header.php');

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_discussions($order, $title) {
global $db, $myts, $rcxConfig, $rcxUser, $bbTable;

$uid   = $rcxUser ? $rcxUser->uid() : 0;

include_once('../../header.php');
OpenTable();
echo "<div align='left'><h4>10 ".sprintf(_MD_FORUM_TOP, $title)."</h4></div>";

$fsql = "SELECT * FROM ".$bbTable['forums']." ORDER BY forum_name DESC";
$fquery = $db->query($fsql);
if(!$fquery) die($db->error());
if($db->num_rows($fquery) == 0) die("No Rows");

while ($row = $db->fetch_object($fquery) )
{
	$permissions = new Permissions($row->forum_id);
	if($permissions->can_view == 1)
	{
		$fname = $myts->makeTboxData4Show($row->forum_name);

		$sql = "
			SELECT
			t.topic_poster AS userid,
			t.topic_id AS topicid,
			t.topic_title AS title,
			t.topic_time AS time,
			t.topic_views AS views,
			t.topic_replies AS replies
			FROM ".$bbTable['topics']." t
			WHERE t.forum_id = ".$row->forum_id."
			ORDER BY t.$order DESC";

	$content  .= '
		<table border="0" cellpadding="0" cellspacing="0" valign="top" width="100%" class="bg2"><tr>
		<td>
		<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr>
		<td colspan="4" align="left" class="bg1"><b>'.$row->forum_name.'</b></td>
		</tr><tr>
		<td align="left"><b>'._MD_TOPIC.'</b></td>
		<td align="center"><b>'._MD_REPLIES.'</b></td>
		<td align="center"><b>'._MD_VIEWS.'</b></td>
		<td align="right"><b>'._MD_POSTER.'</b></td></tr>';

	$query = $db->query($sql, 10, 0);
	while ( list($userid, $topicid, $title, $time, $views, $replies) = $db->fetch_row($query) ) {
		$title = $myts->makeTboxData4Show($title);
		$time  = formatTimestamp($time, "m");
		if ( strlen($title) > 100 ) {
			$title = substr($title, 0, 100)."..";
		}

		$content .= '
			<tr class="bg1">
			<td align="left"><a href="'.$bbPath['url'].'viewtopic.php?topic_id='.$topicid.'&amp;forum='.$row->forum_id.'">'.$title.'</a></td>
			<td align="center" width="1%" nowrap>'.$replies.'</td>
			<td align="center" width="1%" nowrap>'.$views.'</td>
			<td align="right" width="1%" nowrap>';

		$poster = new RcxUser($userid);
		!$poster->uname() ? $postername = $rcxConfig['anonymous'] : $postername = $poster->uname();
		$postername = $myts->makeTboxData4Show($postername);
		if ( strlen($postername) > 30 ) {
		$postername = substr($postername, 0, 30)."..";
		}

		$content .= '<b>'.$postername.'</b><br />'.$time.'</td>';
	} // END WHILE

	$content .= '
		</tr></table></td>
		</tr><tr class="bg4">
		<td align="right">
		<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;<b>
		<a href="'.$bbPath['url'].'viewforum.php?forum='.$row->forum_id.'">'._MD_FORUM_VSTFRM.'</a></b>
		</td></tr>
		</table>';

	$content .= '<br /><br />';
	}
} // END LIST FORUMS

echo $content;
CloseTable();
include_once('../../footer.php');
}

/**
* Description
*
* @param type $var description
* @return type description
*/
switch($_GET['op']) {

case "1":
	show_discussions("topic_views", _MD_FORUM_MVIEWED);
	break;

case "2":
	show_discussions("topic_replies", _MD_FORUM_MACTIVE);
	break;

default:
	show_discussions("topic_time", _MD_FORUM_MRECENT);
	break;
}
?>
