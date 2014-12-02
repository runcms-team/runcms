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

if (!defined("RCX_RCXTOPIC_INCLUDED")) {
	define("RCX_RCXTOPIC_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxtree.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxTopic {

	var $table;
	var $topic_id;
	var $topic_pid;
	var $topic_title;
	var $topic_imgurl;
	var $prefix; // only used in topic tree
	var $mid; // module id used for setting permission

	function RcxTopic($table, $topicid=0) {

	$this->table = $table;
	if ( is_array($topicid) ) {
		$this->makeTopic($topicid);
		} elseif ( $topicid != 0 ) {
			$this->getTopic(intval($topicid));
			} else {
				$this->topic_id = $topicid;
			}
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicTitle($value) {
	$this->topic_title = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicImgurl($value) {
	$this->topic_imgurl = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicPid($value) {
	$this->topic_pid = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getTopic($topic_id) {
global $db, $objCache;

if ($objCache->RcxTopic[$topic_id]) {
	$this->makeTopic($objCache->RcxTopic[$topic_id]);
	return;
}

$sql   = "SELECT * FROM ".$this->table." WHERE topic_id=".$topic_id."";
$array = $db->fetch_array($db->query($sql));
$this->makeTopic($array);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function makeTopic($array) {
global $objCache;

foreach($array as $key=>$value) {
	$this->$key = $value;
	$objCache->RcxTopic[$array['topic_id']][$key] = $value;
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
global $myts, $db;

$title  = "";
$imgurl = "";

if ( isset($this->topic_title) && $this->topic_title != "" ) {
	$title = $myts->makeTboxData4Save($this->topic_title);
}

if ( isset($this->topic_imgurl) && $this->topic_imgurl != "" ) {
	$imgurl = $myts->makeTboxData4Save($this->topic_imgurl);
}

if ( !isset($this->topic_pid) || !is_numeric($this->topic_pid) ) {
	$this->topic_pid = 0;
}

if ( empty($this->topic_id) ) {
	$this->topic_id = $db->genId($this->table."_topic_id_seq");
	$sql = "INSERT INTO ".$this->table." SET topic_id=".$this->topic_id.", topic_pid=".$this->topic_pid.", topic_imgurl='".$imgurl."', topic_title='".$title."'";
	} else {
		$sql = "UPDATE ".$this->table." SET topic_pid=".$this->topic_pid.", topic_imgurl='".$imgurl."', topic_title='".$title."' WHERE topic_id=".$this->topic_id."";
	}

if ( !$result = $db->query($sql) ) {
	ErrorHandler::show('0022');
}

if ( empty($this->topic_id) ) {
	$this->topic_id = $db->insert_id();
}

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db;

$sql = "DELETE FROM ".$this->table." WHERE topic_id=".$this->topic_id."";
$db->query($sql);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function topic_id() {
	return $this->topic_id;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function topic_pid() {
	return $this->topic_pid;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function topic_title($format="S") {
global $myts;

switch($format) {
	case "S":
		$title = $myts->makeTboxData4Show($this->topic_title);
		break;

	case "E":
		$title = $myts->makeTboxData4Edit($this->topic_title);
		break;

	case "P":
		$title = $myts->makeTboxData4Preview($this->topic_title);
		break;

	case "F":
		$title = $myts->makeTboxData4PreviewInForm($this->topic_title);
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
function topic_imgurl($format="S") {
global $myts;

switch($format) {
	case "S":
		$imgurl= $myts->makeTboxData4Show($this->topic_imgurl);
		break;

	case "E":
		$imgurl = $myts->makeTboxData4Edit($this->topic_imgurl);
		break;

	case "P":
		$imgurl = $myts->makeTboxData4Preview($this->topic_imgurl);
		break;

	case "F":
		$imgurl = $myts->makeTboxData4PreviewInForm($this->topic_imgurl);
		break;
}

return $imgurl;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function prefix() {

if ( isset($this->prefix) ) {
	return $this->prefix;
}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getFirstChildTopics() {

$ret       = array();
$xt        = new RcxTree($this->table, "topic_id", "topic_pid");
$topic_arr = $xt->getFirstChild($this->topic_id, "topic_title");

if ( is_array($topic_arr) && count($topic_arr) ) {
	foreach($topic_arr as $topic){
		$ret[] = new RcxTopic($this->table, $topic);
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
function getAllChildTopics() {

$ret       = array();
$xt        = new RcxTree($this->table, "topic_id", "topic_pid");
$topic_arr = $xt->getAllChild($this->topic_id, "topic_title");

if ( is_array($topic_arr) && count($topic_arr) ) {
	foreach($topic_arr as $topic) {
		$ret[] = new RcxTopic($this->table, $topic);
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
function getChildTopicsTreeArray() {

$ret       = array();
$xt        = new RcxTree($this->table, "topic_id", "topic_pid");
$topic_arr = $xt->getChildTreeArray($this->topic_id, "topic_title");

if ( is_array($topic_arr) && count($topic_arr) ) {
	foreach($topic_arr as $topic) {
		$ret[] = new RcxTopic($this->table, $topic);
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
function makeTopicSelBox($none=0, $seltopic=-1, $selname="", $onchange="") {

$xt = new RcxTree($this->table, "topic_id", "topic_pid");

if ( $seltopic != -1 ) {
	$xt->makeMySelBox("topic_title", "topic_title", $seltopic, $none, $selname, $onchange);
	} elseif ( !empty($this->topic_id) ) {
		$xt->makeMySelBox("topic_title", "topic_title", $this->topic_id, $none, $selname, $onchange);
		} else {
			$xt->makeMySelBox("topic_title", "topic_title", 0, $none, $selname, $onchange);
		}
}

/**
* generates nicely formatted linked path from the root id to a given id
*
* @param type $var description
* @return type description
*/
function getNiceTopicPathFromId($funcURL) {

$xt  = new RcxTree($this->table, "topic_id", "topic_pid");
$ret = $xt->getNicePathFromId($this->topic_id, "topic_title", $funcURL);

return $ret;
}

/**
* Description deprecated
*
* @param type $var description
* @return type description
*/
function getAllChildTopicsId() {

$xt  = new RcxTree($this->table, "topic_id", "topic_pid");
$ret = $xt->getAllChildId($this->topic_id, "topic_title");

return $ret;
}

} // END RCXTOPIC
}
?>
