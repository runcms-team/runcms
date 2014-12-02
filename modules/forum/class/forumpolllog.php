<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH')) {
	exit();
}
include_once(RCX_ROOT_PATH."/class/rcxobject.php");

class ForumPollLog extends RcxObject {

	function ForumPollLog($id=NULL) {
	$this->RcxObject();
	$this->initVar("log_id", "int", 0);
	$this->initVar("poll_id", "int", NULL, true);
	$this->initVar("option_id", "int", NULL, true);
	$this->initVar("ip", "other", NULL);
	$this->initVar("user_id", "int", 0);
	$this->initVar("time", "int", NULL);
	if ( !empty($id) ) {
		if ( is_array($id) ) {
			$this->set($id);
			} else {
				$this->load(intval($id));
			}
		}
	}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
global $db, $bbTable;

if ( !$this->isCleaned() ) {
	if ( !$this->cleanVars() ) {
		return false;
	}
}

foreach ( $this->cleanVars as $k=>$v ) {
	$$k = $v;
}

$log_id = $db->genId($bbTable['poll_log']."_log_id_seq");
$sql = "
	INSERT INTO ".$bbTable['poll_log']." SET
	log_id=$log_id,
	poll_id=$poll_id,
	option_id='$option_id',
	ip='$ip',
	user_id='$user_id',
	time=".time()."";

if ( !$result = $db->query($sql) ) {
	$this->setErrors(_NOTUPDATED);
	return false;
}

return $option_id;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
global $db, $bbTable;

$sql   = "SELECT * FROM ".$bbTable['poll_log']." WHERE log_id=".$id."";
$myrow = $db->fetch_array($db->query($sql));
$this->set($myrow);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db, $bbTable;

$sql = "DELETE FROM ".$bbTable['poll_log']." WHERE log_id=".$this->getVar("log_id")."";
if ( !$db->query($sql) ) {
	return false;
}

return true;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function &getAllByPollId($poll_id, $orderby="time ASC") {
global $db, $bbTable;

$ret = array();
$sql = "SELECT * FROM ".$bbTable['poll_log']." WHERE poll_id=".intval($poll_id)." ORDER BY $orderby";

$result = $db->query($sql);
while ( $myrow = $db->fetch_array($result) ) {
	$ret[] = new ForumPollLog($myrow);
}

return $ret;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function hasVoted($poll_id, $ip, $user_id=NULL) {
global $db, $bbTable;

$sql = "SELECT COUNT(*) FROM ".$bbTable['poll_log']." WHERE poll_id=".intval($poll_id)." AND";
if ( !empty($user_id) ) {
	$sql .= " user_id=".intval($user_id);
	} else {
		$sql .= " ip='".$ip."'";
	}

list($count) = $db->fetch_row($db->query($sql));
if ( $count > 0 ) {
	return true;
}

return false;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function deleteByPollId($poll_id) {
global $db, $bbTable;

$sql = "DELETE FROM ".$bbTable['poll_log']." WHERE poll_id=".intval($poll_id);
if ( !$db->query($sql) ) {
	return false;
}

return true;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function deleteByOptionId($option_id) {
global $db, $bbTable;

$sql = "DELETE FROM ".$bbTable['poll_log']." WHERE option_id=".intval($option_id);
if ( !$db->query($sql) ) {
	return false;
}

return true;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getTotalVotersByPollId($poll_id) {
global $db, $bbTable;

$sql   = "SELECT DISTINCT user_id FROM ".$bbTable['poll_log']." WHERE poll_id=".intval($poll_id)." AND user_id > 0";
$users = $db->num_rows($db->query($sql));

$sql   = "SELECT DISTINCT ip FROM ".$bbTable['poll_log']." WHERE poll_id=".intval($poll_id)." AND user_id=0";
$anons = $db->num_rows($db->query($sql));

return $users+$anons;
	}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getTotalVotesByPollId($poll_id) {
global $db, $bbTable;

$sql = "SELECT COUNT(*) FROM ".$bbTable['poll_log']." WHERE poll_id = ".intval($poll_id);
list($votes) = $db->fetch_row($db->query($sql));

return $votes;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getTotalVotesByOptionId($option_id) {
global $db, $bbTable;

$sql = "SELECT COUNT(*) FROM ".$bbTable['poll_log']." WHERE option_id = ".intval($option_id);
list($votes) = $db->fetch_row($db->query($sql));

return $votes;
}

//---------------------------------------------------------------------------------------//
}
?>
