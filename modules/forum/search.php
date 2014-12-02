<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/


include_once("./header.php");
include_once(RCX_ROOT_PATH."/header.php");
include_once("class/class.permissions.php");

OpenTable();

if ($_POST['submit']) {

	echo "
	<table border='0' width='$bbWidth' cellpadding='5' align='center'><tr>
	<td colspan='2' align='left'>
	<img src='".$bbImage['f_open']."' alt='/' />&nbsp;<a href='".$bbPath['url']."index.php'>";
	echo _MD_FORUMINDEX;
	echo "
	</a>
	<br />&nbsp;&nbsp;&nbsp;<img src='".$bbImage['f_open']."' alt='/' />&nbsp;<a href='search.php'>". _MD_SEARCH ."</a>
	<br /><img src='".$bbImage['f_content']."' alt='#' />&nbsp;"._MD_SEARCHRESULTS."</td>
	</tr></table>";

$term            = $_POST['term'];
$addterms        = $_POST['addterms'];
$forum           = $_POST['forum'];
$search_username = $_POST['search_username'];
$sortby          = $_POST['sortby'];
$searchboth      = $_POST['searchboth'];

$query = "
	SELECT
	u.uid,
	f.forum_id,
	p.topic_id,
	u.uname,
	p.post_time,
	t.topic_title,
	f.forum_name
	FROM
	".$bbTable['posts']." p,
	".$db->prefix("users")." u,
	".$bbTable['forums']." f,
	".$bbTable['topics']." t";

if ( isset($term) && $term != "" ) {

	$terms = split(" ", addslashes($term));
	$addquery .= "(p.post_text LIKE '%$terms[0]%'";
	$subquery .= "(t.topic_title LIKE '%$terms[0]%'";
	if ( $addterms == "any" ) {
		$andor = "OR";
		} else {
			$andor = "AND";
		}
	$size = count($terms);
	for ($i=1; $i<$size; $i++) {
		$addquery.=" $andor p.post_text LIKE '%$terms[$i]%'";
		$subquery.=" $andor t.topic_title LIKE '%$terms[$i]%'";
	}
	$addquery.=")";
	$subquery.=")";
}

if ( isset($forum) && $forum!="all" )
{
	if ( isset($addquery) ) {
		$addquery .= " AND ";
		$subquery .= " AND ";
	}
	$addquery .=" p.forum_id=$forum";
	$subquery .=" p.forum_id=$forum";
}

if ( isset($forum) && $forum=="all" )
{
	$fquery = "SELECT * FROM ".$bbTable['forums'];
	if ($result = $db->query($fquery) )
	{
		while ( $row = $db->fetch_object($result) )
		{
			$permissions = new Permissions($row->forum_id);
			if($permissions->can_view == 0)
			{
				if ( isset($addquery) ) {
					$addquery .= " AND ";
					$subquery .= " AND ";
				}
				$addquery .=" p.forum_id!=".$row->forum_id;
				$subquery .=" p.forum_id!=".$row->forum_id;
			}
		}
	}

}

if ( isset($search_username) && $search_username != "" ) {
	$search_username = addslashes($search_username);
	if ( !$result = $db->query("SELECT uid FROM ".$db->prefix("users")." WHERE uname='$search_username'") ) {
		error_die("<big>"._MD_ERROROCCURED."</big><hr />"._MD_COULDNOTQUERY."");
	}
	$row = $db->fetch_array($result);
	if ( !$row ) {
		error_die(_MD_USERNOEXIST);
	}
	$userid = $row['uid'];
	if ( isset($addquery) ) {
		$addquery.=" AND p.uid=$userid AND u.uname='$search_username'";
		$subquery.=" AND p.uid=$userid AND u.uname='$search_username'";
		} else {
			$addquery.=" p.uid=$userid AND u.uname='$search_username'";
			$subquery.=" p.uid=$userid AND u.uname='$search_username'";
		}
}

if ( isset($addquery) )
{
	switch ( $searchboth )
	{
		case "both" :
			$query .= " WHERE p.is_approved=1 AND ( $subquery OR $addquery ) AND ";
			break;

		case "title" :
			$query .= " WHERE p.is_approved=1 AND ( $subquery ) AND ";
			break;

		case "text" :
			$query .= " WHERE p.is_approved=1 AND ( $addquery ) AND ";
			break;
	}
}
else
{
		$query .= " WHERE p.is_approved=1 AND";
}

$query .= "
	p.topic_id = t.topic_id
	AND p.forum_id = f.forum_id
	AND p.uid = u.uid";

//$query .= " GROUP BY t.topic_id";
$query .= " ORDER BY $sortby";

if ( !$result = $db->query($query, 200, 0) ) {
	die("<big>"._MD_ERROROCCURED."</big><hr />"._MD_COULDNOTQUERY);
}

if ( $db->num_rows($result) == 0 ) {
	echo "<h4>"._MD_NOMATCH."</h4>";
	} else {
		echo "
		<table border='0' cellpadding='0' cellspacing='0' align='center' valign='top' width='95%'><tr>
		<td class='bg2'>
		<table border='0' cellpadding='4' cellspacing='1' width='100%'><tr class='bg3' align='center'>
		<td><b>"._MD_FORUM."</b></td>
		<td><b>"._MD_TOPIC."</b></td>
		<td><b>"._MD_AUTHOR."</b></td>
		<td><b>"._MD_POSTTIME."</b></td>
		</tr>";
		while ($row = $db->fetch_array($result))
		{
			echo "
			<tr class='bg1' align='center'>
			<td nowrap><a href='viewforum.php?forum=".$row['forum_id']."'>". $myts->makeTboxData4Show($row['forum_name']) . "</a></td>
			<td align='left'><a href='viewtopic.php?topic_id=".$row['topic_id']."&amp;forum=".$row['forum_id']."'>". $myts->makeTboxData4Show($row['topic_title']) . "</a></td>
			<td nowrap><a href='".RCX_URL."/userinfo.php?uid=".$row['uid']."'>".$myts->makeTboxData4Show($row['uname'])."</a></td>
			<td nowrap>".formatTimestamp($row['post_time'], "s")."</td>
			</tr>";
		}
		echo "</table></td></tr></table>";
	}

	} else {
		echo "
		<table border='0' width='$bbWidth' cellpadding='5' align='center'><tr>
		<td colspan='2' align='left'>&nbsp;&nbsp;
		<img src='".$bbImage['f_open']."' alt='/' />
		<a href='".$bbPath['url']."index.php'>"._MD_FORUMINDEX."</a>
		<br /><img src='".$bbImage['f_content']."' alt='/' /> "._MD_SEARCH."</td>
		</tr></table>";
	}

echo "
<form name='Search' action='./search.php' method='post'>
<table width='$bbWidth' border='0' cellpadding='1' cellspacing='0' align='center' valign='top'><tr>

<td class='bg2'>
<table border='0' cellpadding='1' cellspacing='1' width='100%' class='bg3'><tr>

<td class='bg3' align='right'><b>"._MD_KEYWORDS."</b></td>
<td class='bg1'><input type='text' class='text' name='term' value='".$myts->makeTareaData4Show($term)."' /></td>

</tr><tr>

<td class='bg3'>&nbsp;</td>
<td class='bg1'><input type='radio' class='radio' name='addterms' value='any' checked='checked' />"._MD_SEARCHANY."</td>

</tr><tr>

<td class='bg3'>&nbsp;</td>
<td class='bg1'><input type='radio' class='radio' name='addterms' value='all' />"._MD_SEARCHALL."</td>

</tr><tr>

<td class='bg3' align='right'><b>". _MD_FORUMC ."</b></td>
<td class='bg1'>
<select class='select' name='forum'><option value='all'>". _MD_SEARCHALLFORUMS ."</option>";

$query = "SELECT forum_name, forum_id FROM ".$bbTable['forums'];

if ( !$result = $db->query($query) ) {
	die("<big>"._MD_ERROROCCURED."</big><hr />"._MD_COULDNOTQUERY."");
}

while ( $row = $db->fetch_object($result) )
{
	$permissions = new Permissions($row->forum_id);
	if($permissions->can_view == 1)
		echo "<option value='".$row->forum_id."'>".$row->forum_name."</option>";
}

echo "
</select></td>

</tr><tr width='100%'>

<td class='bg3' align='right'><b>"._MD_AUTHORC."</b></td>
<td class='bg1'><input type='text' class='text' name='search_username' value='".$myts->makeTareaData4Show($search_username)."' /></td>

</tr><tr>

<td class='bg3' align='right'><b>"._MD_SORTBY."</b></td>
<td class='bg1'>
<input type='radio' class='radio' name='sortby' value='p.post_time desc' checked='checked' />"._MD_DATE."
<input type='radio' class='radio' name='sortby' value='t.topic_title' />"._MD_TOPIC."
<input type='radio' class='radio' name='sortby' value='f.forum_name' />"._MD_FORUM."
<input type='radio' class='radio' name='sortby' value='u.uname' />"._MD_USERNAME."
</td>

</tr><tr>

<td class='bg3' align='right'><b>"._MD_SEARCHIN."</b></td>
<td class='bg1'>
<input type='radio' class='radio' name='searchboth' value='both' checked='checked' />"._MD_SUBJECT." & "._MD_BODY."
<input type='radio' class='radio' name='searchboth' value='title' />"._MD_SUBJECT."
<input type='radio' class='radio' name='searchboth' value='text' />"._MD_BODY."
</td>

</tr><tr>

<td colspan='2' align='center'>
<input type='submit' class='button' name='submit' value='"._MD_SEARCH."' /></td>

</tr></table>
</td>

</tr></table>
</form>";

CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
