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

if (!defined("RCX_RCXSTORY_INCLUDED")) {
	define("RCX_RCXSTORY_INCLUDED", 1);
include_once(RCX_ROOT_PATH."/class/rcxcomments.php");
include_once(RCX_ROOT_PATH."/class/rcxtopic.php");
/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxStory {
	var $table;
	var $storyid;
	var $topicid;
	var $uid;
	var $title;
	var $hometext;
	var $bodytext = "";
	var $counter;
	var $created;
	var $published;
	var $hostname;
	var $allow_html    = 0;
	var $allow_smileys = 1;
	var $allow_bbcode  = 1;
	var $ihome         = 0;
	var $notifypub     = 0;
	var $type          = "user";
	var $approved;
	var $topicdisplay;
	var $topicalign;
	var $db;
	var $commentstable;
	var $topicstable;
	function Story($storyid=-1) {
	$this->table = "";
	$this->commentstable = "";
	$this->topicstable = "";
	if (is_array($storyid)) {
		$this->makeStory($storyid);
		} elseif ($storyid != -1) {
			$this->getStory(intval($storyid));
		}
	}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setStoryId($value) {
	$this->storyid = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicId($value) {
	$this->topicid = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setUid($value) {
	$this->uid = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setTitle($value) {
	$this->title = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setHometext($value) {
	$this->hometext = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setBodytext($value) {
	$this->bodytext = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setPublished($value) {
	$this->published = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setHostname($value) {
	$this->hostname = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setHtml($value=0) {
	$this->allow_html = intval($value);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setSmileys($value=0) {
	$this->allow_smileys = intval($value);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setBBcode($value=0) {
	$this->allow_bbcode = intval($value);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setIhome($value) {
	$this->ihome = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setNotifyPub($value) {
	$this->notifypub = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setType($value) {
global $myts;
	$this->type = $value;
	$myts->setType($value);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setApproved($value) {
	$this->approved = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicdisplay($value) {
	$this->topicdisplay = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicalign($value) {
	$this->topicalign = $value;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function store($approved=false) {
global $myts, $db;
$title    = $myts->makeTboxData4Save($this->title);
$hometext = $myts->makeTboxData4Save($this->hometext);
$bodytext = $myts->makeTboxData4Save($this->bodytext);
if (!isset($this->notifypub) || $this->notifypub != 1) {
	$this->notifypub = 0;
}
if ( !isset($this->topicdisplay) || $this->topicdisplay != 0 ) {
	$this->topicdisplay = 1;
}
if (!isset($this->storyid)) {
	$newstoryid = $db->genId($this->table."_storyid_seq");
	$created = time();
	if ($this->approved) {
		$sql = "
			INSERT INTO ".$this->table." SET
			storyid=$newstoryid,
			uid=".$this->uid.",
			title='".$title."',
			created=".$created.",
			published=".$this->published.",
			hostname='".$this->hostname."',
			allow_html=".intval($this->allow_html).",
			allow_smileys=".intval($this->allow_smileys).",
			allow_bbcode=".intval($this->allow_bbcode).",
			hometext='".$hometext."',
			bodytext='".$bodytext."',
			counter=0,
			topicid=".intval($this->topicid).",
			ihome=".intval($this->ihome).",
			notifypub=".intval($this->notifypub).",
			type='".$this->type."',
			topicdisplay=$this->topicdisplay,
			topicalign='".$this->topicalign."'";
		} else {
			$sql = "
				INSERT INTO ".$this->table." SET
				storyid=$newstoryid,
				uid=".$this->uid.",
				title='".$title."',
				created=".$created.",
				published=0,
				hostname='".$this->hostname."',
				allow_html=".intval($this->allow_html).",
				allow_smileys=".intval($this->allow_smileys).",
				allow_bbcode=".intval($this->allow_bbcode).",
				hometext='".$hometext."',
				bodytext='".$bodytext."',
				counter=0,
				topicid=".intval($this->topicid).",
				ihome=".intval($this->ihome).",
				notifypub=".intval($this->notifypub).",
				type='".$this->type."',
				topicdisplay=$this->topicdisplay,
				topicalign='".$this->topicalign."'";
		}
	} else {
		if ($this->approved) {
			$sql = "
				UPDATE ".$this->table." SET
				title='".$title."',
				published=".$this->published.",
				allow_html=".intval($this->allow_html).",
				allow_smileys=".intval($this->allow_smileys).",
				allow_bbcode=".intval($this->allow_bbcode).",
				hometext='".$hometext."',
				bodytext='".$bodytext."',
				topicid=".intval($this->topicid).",
				ihome=".intval($this->ihome).",
				topicdisplay=".$this->topicdisplay.",
				topicalign='".$this->topicalign."'
				WHERE storyid=".$this->storyid."";
			} else {
				$sql = "
					UPDATE ".$this->table." SET
					title='".$title."',
					allow_html=".intval($this->allow_html).",
					allow_smileys=".intval($this->allow_smileys).",
					allow_bbcode=".intval($this->allow_bbcode).",
					hometext='".$hometext."',
					bodytext='".$bodytext."',
					topicid=".intval($this->topicid).",
					ihome=".intval($this->ihome).",
					topicdisplay=".$this->topicdisplay.",
					topicalign='".$this->topicalign."'
					WHERE storyid=".$this->storyid."";
			}
	}
if (!$result = $db->query($sql)) {
	return false;
}
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function getStory($storyid) {
global $db;
$sql   = "SELECT * FROM ".$this->table." WHERE storyid=".$storyid."";
$array = $db->fetch_array($db->query($sql));
$this->makeStory($array);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function makeStory($array) {
if ( is_array($array) ) {
	foreach($array as $key=>$value) {
		$this->$key = $value;
	}
}
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db;
$sql = "DELETE FROM ".$this->table." WHERE storyid=".$this->storyid."";
if (!$result = $db->query($sql)) {
	return false;
}
if ( isset($this->commentstable) && $this->commentstable != "" ) {
	$commentsarray = array();
	$com           = new RcxComments($this->commentstable, "storyid");
	$criteria      = array("item_id=".$this->storyid."", "pid=0");
	$commentsarray = $com->getAllComments($criteria);
	foreach($commentsarray as $comment) {
		$comment->delete();
	}
}
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function updateCounter() {
global $db;
$sql = "UPDATE ".$this->table." SET counter=counter+1 WHERE storyid=".$this->storyid."";
if (!$result = $db->query($sql)) {
	return false;
}
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function topicid() {
	return $this->topicid;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function topic() {
	return new RcxTopic($this->topicstable, $this->topicid);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function uid() {
	return $this->uid;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function uname() {
	return RcxUser::getUnameFromId($this->uid);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function title($format="Show") {
global $myts;
$allow_smileys = intval($this->allow_smileys());
switch($format) {
	case "Show":
		$title = $myts->makeTboxData4Show($this->title, $allow_smileys);
		break;
	case "Edit":
		$title = $myts->makeTboxData4Edit($this->title);
		break;
	case "Preview":
		$title = $myts->makeTboxData4Preview($this->title, $allow_smileys);
		break;
	case "InForm":
		$title = $myts->makeTboxData4PreviewInForm($this->title);
		break;
}
return $title;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function hometext($format="Show") {
global $myts;
$allow_html    = intval($this->allow_html());
$allow_smileys = intval($this->allow_smileys());
$allow_bbcode  = intval($this->allow_bbcode());
$myts->setType($this->type);
switch($format) {
	case "Show":
		$hometext = $myts->makeTareaData4Show($this->hometext, $allow_html, $allow_smileys, $allow_bbcode);
		break;
	case "Edit":
		$hometext = $myts->makeTboxData4Edit($this->hometext);
		break;
	case "Preview":
		$hometext = $myts->makeTareaData4Preview($this->hometext, $allow_html, $allow_smileys, $allow_bbcode);
		break;
	case "InForm":
		$hometext = $myts->makeTboxData4PreviewInForm($this->hometext);
		break;
}
return $hometext;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function bodytext($format="Show") {
global $myts;
$allow_html    = intval($this->allow_html());
$allow_smileys = intval($this->allow_smileys());
$allow_bbcode  = intval($this->allow_bbcode());
$myts->setType($this->type);
switch($format) {
	case "Show":
		$bodytext = $myts->makeTareaData4Show($this->bodytext, $allow_html, $allow_smileys, $allow_bbcode);
		break;
	case "Edit":
		$bodytext = $myts->makeTboxData4Edit($this->bodytext);
		break;
	case "Preview":
		$bodytext = $myts->makeTareaData4Preview($this->bodytext, $allow_html, $allow_smileys, $allow_bbcode);
		break;
	case "InForm":
		$bodytext = $myts->makeTboxData4PreviewInForm($this->bodytext);
		break;
}
return $bodytext;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function counter() {
	return $this->counter;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function created() {
	return $this->created;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function published() {
	return $this->published;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function hostname() {
	return $this->hostname;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function storyid() {
	return intval($this->storyid);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function allow_html() {
	return intval($this->allow_html);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function allow_smileys() {
	return intval($this->allow_smileys);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function allow_bbcode() {
	return intval($this->allow_bbcode);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function notifypub() {
	return intval($this->notifypub);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function type() {
	return $this->type;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function ihome() {
	return intval($this->ihome);
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function topicdisplay() {
	return $this->topicdisplay;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function topicalign($astext=true) {
if ( $astext ) {
	if ( $this->topicalign == "R" ) {
		$ret = "right";
		} else {
			$ret = "left";
		}
	return $ret;
	}
return $this->topicalign;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function getCommentsCount() {
global $db;
$result = $db->query("SELECT COUNT(*) FROM ".$this->commentstable." WHERE item_id=".$this->storyid."");
list($count) = $db->fetch_row($result);
return $count;
}
} // END RCXSTORY
}
?>
