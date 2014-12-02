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

if ( empty($forum) || !is_numeric($forum) ) {
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
	} elseif ( empty($topic_id) || !is_numeric($topic_id) ) {
		redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORTOPIC);
		exit();
	}

$forum    = intval($forum);
$topic_id = intval($topic_id);

include_once("class/class.permissions.php");

$permissions = new Permissions($forum);
if ($permissions->can_view == 0)
{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}

include_once("./class/class.forumposts.php");

$sql = "
	SELECT
	t.topic_title,
	t.topic_status,
	t.topic_sticky,
	f.forum_name,
	f.allow_html,
	f.allow_sig,
	f.posts_per_page,
	f.hot_threshold,
	f.topics_per_page
	FROM
	".$bbTable['topics']." t
	LEFT JOIN ".$bbTable['forums']." f ON f.forum_id = t.forum_id
	WHERE
	t.topic_id = $topic_id
	AND
	t.forum_id = $forum";

if ( !$result = $db->query($sql) ) {
	$error = "<h4>"._MD_ERROROCCURED."</h4><hr />"._MD_COULDNOTQUERY;
	redirect_header("index.php", 2, $error);
	exit();
}

if ( !$forumdata = $db->fetch_array($result) ) {
	redirect_header("index.php", 2, _MD_FORUMNOEXIST);
	exit();
}

$can_post = 0;
$forumdata['topic_title'] = $myts->makeTboxData4Show($forumdata['topic_title']);

if ( !headers_sent() ) {
	if ( !empty($meta['p3p']) ) {
		header("P3P: CP='".$meta['p3p']."'");
	}
	if ( $rcxUser || ($meta['pragma'] == 1) ) {
		header("Expires: Sat, 18 Aug 2002 05:30:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0");
	}
}

// We only generate keywords if in debug mode, or if it's really a search engine.
if ($meta['extractor']) {
	if (!$meta['cloaking']) {
		include_once(RCX_ROOT_PATH . "/modules/system/admin/meta-generator/include/functions.php");
		} elseif ( $meta['cloaking'] && !preg_match("/(".$meta['user_agents'].")/i", _HTTP_USER_AGENT) ) {
			include_once(RCX_ROOT_PATH . "/modules/system/admin/meta-generator/include/functions.php");
		}
}


?>
<html>
<head>
<title><?php echo $meta['title'];?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo _CHARSET;?>">
<meta http-equiv="content-language" content="<?php echo _LANGCODE;?>">
<meta name="rating" content="<?php echo $meta['rating'];?>">
<meta name="robots" content="<?php echo $meta['index'];?>, <?php echo $meta['follow'];?>">
<meta name="generator" content="<?php echo RCX_VERSION;?>">
<meta name="keywords" content="<?php echo $meta['keywords'];?>">
<meta name="description" content="<?php echo $meta['description'];?>">
<meta name="author" content="<?php echo $meta['author'];?>">
<meta name="copyright" content="<?php echo $meta['copyright'];?>">
<?php readfile(RCX_ROOT_PATH . "/modules/system/cache/header.php");?>
<link rel="shortcut icon" href="<?php echo $meta['icon'];?>">
<?php include_once(RCX_ROOT_PATH ."/include/rcxjs.php");?>
<link href="<?php echo RCX_URL;?>/include/style.css" rel="stylesheet" type="text/css" />
<?php

$themecss = getcss(getTheme());
if ($themecss) {
	echo "
	<style type='text/css' media='all'>
	<!-- @import url($themecss); -->
	</style>";
}

echo "</head><body >";

echo"<table border='0' width='640' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF'><tr><td>";
echo "<h3>"._MD_FORUM." : ".$forumdata['forum_name']."</h3>";
echo "<h3>"._MD_SUBJECT." : ".$forumdata['topic_title']."</h3>";
echo"
<i><b>".$meta['copyright']."<br /><a href=".RCX_URL.">".RCX_URL."</a>
<br /><br />"._MD_PRINT_TOPIC_LINK."<br />
<a href='".RCX_URL."/modules/".$rcxModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>".RCX_URL."/modules/".$rcxModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum</a>
</b></i><br /><br />";

$forumpost = new ForumPosts();
$qorder = "post_time ASC";
$forumpost->setOrder($qorder);

if ( !isset($post_id) || $post_id == "" ) {
	$pid=0;
	$forumpost->setTopicId($topic_id);
	$forumpost->setParent($pid);
}

$postsArray = $forumpost->getAllPosts();

	$count = 0;
	foreach ($postsArray as $obj) {
		if ( !($count % 2) ) {
			$row_color = 1;
			} else {
				$row_color = 2;
			}
echo"<tr><td>";
		$forumpost->setType($obj->type);
		$obj->showPostForPrint($viewmode, $order, $can_post, $forumdata['topic_status'], $forumdata['allow_sig'], 0, $row_color);
		$count++;
echo"</td></tr>";
	}

echo"<tr><td><br />
<i><b>".$meta['copyright']."<br /><a href=".RCX_URL.">".RCX_URL."</a>
<br /><br />"._MD_PRINT_TOPIC_LINK."<br />
<a href='".RCX_URL."/modules/".$rcxModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>".RCX_URL."/modules/".$rcxModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum</a>
</b></i></td></tr>";
	
echo "</table></body></html>";

?>
