<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

include_once(RCX_ROOT_PATH."/class/rcxstory.php");
class NewsStory extends RcxStory {
	var $newstopic;   // RcxTopic object
	function NewsStory($storyid = -1) {
	global $db;
	$this->table         = $db->prefix("stories");
// tæller fix 3-1-10 
	$this->commentstable = $db->prefix("comments");
//
	$this->topicstable   = $db->prefix("topics");
	if (is_array($storyid)) {
		$this->makeStory($storyid);
		$this->newstopic = $this->topic();
		} elseif ($storyid != -1) {
			$this->getStory(intval($storyid));
			$this->newstopic = $this->topic();
		}
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function getAllPublished($limit=0, $start=0, $topic=0, $ihome=0, $asobject=true) {
global $db, $myts;

$ret = array();
$sql = "SELECT * FROM ".$db->prefix("stories")." WHERE published > 0 AND published <= ".time()."";

if ( !empty($topic) ) {
	$sql .= " AND topicid=".intval($topic)." AND (ihome=1 OR ihome=0)";
	} else {
		if ( $ihome == 0 ) {
			$sql .= " AND ihome=0";
		}
	}
$sql   .= " ORDER BY published DESC";
$result = $db->query($sql, intval($limit), intval($start));
while ( $myrow = $db->fetch_array($result) ) {
	if ( $asobject ) {
		$ret[] = new NewsStory($myrow);
		} else {
			$ret[$myrow['storyid']] = $myts->makeTboxData4Show($myrow['title']);
		}
}
return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function getAllAutoStory($limit=0, $asobject=true) {
global $db, $myts;

$ret    = array();
$sql    = "SELECT * FROM ".$db->prefix("stories")." WHERE published > ".time()." ORDER BY published ASC";
$result = $db->query($sql, $limit, 0);
while ( $myrow = $db->fetch_array($result) ) {
	if ( $asobject ) {
		$ret[] = new NewsStory($myrow);
		} else {
			$ret[$myrow['storyid']] = $myts->makeTboxData4Show($myrow['title']);
		}
}
return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function getAllSubmitted($limit=0, $asobject=true) {
global $db, $myts;
$ret    = array();
$sql    = "SELECT * FROM ".$db->prefix("stories")." WHERE published=0 ORDER BY created DESC";
$result = $db->query($sql, $limit, 0);
while ( $myrow = $db->fetch_array($result) ) {
	if ( $asobject ) {
		$ret[] = new NewsStory($myrow);
		} else {
			$ret[$myrow['storyid']] = $myts->makeTboxData4Show($myrow['title']);
		}
}
return $ret;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
static function getByTopic($topicid) {
global $db;
$ret    = array();
$result = $db->query("SELECT * FROM ".$db->prefix("stories")." WHERE topicid=".intval($topicid)."");
while ($myrow = $db->fetch_array($result)) {
	$ret[] = new NewsStory($myrow);
}
return $ret;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
static function countByTopic($topicid=0, $published = true) {
global $db;

$sql = "SELECT COUNT(*) FROM ".$db->prefix("stories")."";

$sql_where = array();

if ( $published == true ) {
    $sql_where[] = "published>0";
}

if ( $topicid != 0 ) {
    $sql_where[] = "topicid=".intval($topicid);
}

if (!empty($sql_where)) {
    $sql .= " WHERE ". implode(' AND ', $sql_where);
}

$result = $db->query($sql);
list($count) = $db->fetch_row($result);
return $count;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function topic_title() {
	return $this->newstopic->topic_title();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function adminlink() {
$ret = "&nbsp;[ <a href='".RCX_URL."/modules/news/admin/index.php?op=edit&amp;storyid=".$this->storyid."'>"._EDIT."</a> | <a href='".RCX_URL."/modules/news/admin/index.php?op=delete&amp;storyid=".$this->storyid."'>"._DELETE."</a> ]&nbsp;";
return $ret;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function imglink() {
if ( $this->newstopic->topic_imgurl() ) {
	$ret = "<a href='".RCX_URL."/modules/news/index.php?storytopic=".$this->topicid."'><img src='".formatURL(RCX_URL."/modules/news/cache/topics/", $this->newstopic->topic_imgurl())."' alt='".$this->newstopic->topic_title()."' hspace='10' vspace='10' align='".$this->topicalign()."' /></a>";
}
return $ret;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function textlink() {
$ret = "<a href='".RCX_URL."/modules/news/index.php?storytopic=".$this->topicid()."'>".$this->newstopic->topic_title()."</a>";
return $ret;
}
}
?>
