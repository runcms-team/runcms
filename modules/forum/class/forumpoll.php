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

class ForumPoll extends RcxObject {

	function ForumPoll($id=NULL) {
		$this->RcxObject();
		$this->initVar("poll_id", "int", NULL, false);
		$this->initVar("question", "textbox", NULL, true, 255, true);
		$this->initVar("description", "textbox", NULL, true, 255, true);
		$this->initVar("user_id", "int", NULL, false);
		$this->initVar("start_time", "int", NULL, false);
		$this->initVar("end_time", "int", NULL, true);
		$this->initVar("votes", "int", 0, false);
		$this->initVar("voters", "int", 0, false);
		$this->initVar("display", "int", 1, false);
		$this->initVar("weight", "int", 0, false);
		$this->initVar("multiple", "int", 0, false);
		$this->initVar("mail_status", "int", 1, false);
		$this->initVar("topic_id", "int", NULL, false);
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->set($id);
				} else {
					$this->load(intval($id));
				}
			}
	}

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

$start_time = empty($start_time) ? time() : $start_time;

if ( $end_time <= $start_time ) {
	$this->setErrors(_AM_FUTURETIME);
	return false;
}

if ( empty($poll_id) ) {
	$poll_id = $db->genId($bbTable['poll_desc']."_poll_id_seq");
	$sql = "
		INSERT INTO ".$bbTable['poll_desc']." SET
		poll_id=$poll_id,
		question='$question',
		description='$description',
		user_id='$user_id',
		start_time=$start_time,
		end_time=$end_time,
		votes=0,
		voters=0,
		display=$display,
		weight=$weight,
		multiple=$multiple,
		mail_status=$mail_status";

	} else {
		$sql ="UPDATE ".$bbTable['poll_desc']." SET question='$question', description='$description', start_time='$start_time', end_time='$end_time', display='$display', weight='$weight', multiple='$multiple', mail_status='$mail_status' WHERE poll_id=$poll_id";
	}

if ( !$result = $db->query($sql) ) {
	$this->setErrors(_NOTUPDATED);
	return false;
}

if ( empty($poll_id) ) {
	return $db->insert_id();
}

return $poll_id;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
global $db, $bbTable;

$sql   = "SELECT * FROM ".$bbTable['poll_desc']." WHERE poll_id=".intval($id)."";
$myrow = $db->fetch_array($db->query($sql));
$this->set($myrow);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function hasExpired() {

if ( $this->getVar("end_time") > time() ) {
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
function delete() {
global $db, $bbTable;

$sql = "DELETE FROM ".$bbTable['poll_desc']." WHERE poll_id=".$this->getVar("poll_id")."";
if ( !$db->query($sql) ) {
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
function &getAll($criteria=array(), $asobject=true, $orderby="end_time DESC", $limit=0, $start=0) {
global $db, $bbTable;

$ret = array();
$where_query = "";

if ( is_array($criteria) && count($criteria) > 0 ) {
	$where_query = " WHERE";
	foreach ( $criteria as $c ) {
		$where_query .= " $c AND";
	}
	$where_query = substr($where_query, 0, -4);
}

if ( !$asobject ) {
	$sql = "SELECT poll_id FROM ".$bbTable['poll_desc']."$where_query ORDER BY $orderby";
	$result = $db->query($sql, intval($limit), intval($start));
	while ( $myrow = $db->fetch_array($result) ) {
		$ret[] = $myrow['poll_id'];
	}
	} else {
		$sql = "SELECT * FROM ".$bbTable['poll_desc']."".$where_query." ORDER BY $orderby";
		$result = $db->query($sql, intval($limit), intval($start));
		while ( $myrow = $db->fetch_array($result) ) {
			$ret[] = new ForumPoll($myrow);
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
function vote($option_id, $ip, $user_id=NULL) {

if (!empty($option_id)) {
	if (is_array($option_id)) {
		foreach ($option_id as $vote) {
			$option = new ForumPollOption($vote);
			if ( $this->getVar("poll_id") == $option->getVar("poll_id") ) {
				$log = new ForumPollLog();
				$log->setVar("poll_id", $this->getVar("poll_id"));
				$log->setVar("option_id", $vote);
				$log->setVar("ip", $ip);
				if ( isset($user_id) ) {
					$log->setVar("user_id", $user_id);
				}
				$log->store();
				$option->updateCount();
			}
		}
		} else {
			$option = new ForumPollOption($option_id);
			if ( $this->getVar("poll_id") == $option->getVar("poll_id") ) {
				$log = new ForumPollLog();
				$log->setVar("poll_id", $this->getVar("poll_id"));
				$log->setVar("option_id", $option_id);
				$log->setVar("ip", $ip);
				if ( isset($user_id) ) {
					$log->setVar("user_id", $user_id);
				}
				$log->store();
				$option->updateCount();
			}
		}

return true;
}

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function updateCount() {
global $db, $bbTable;

$votes  = ForumPollLog::getTotalVotesByPollId($this->getVar("poll_id"));
$voters = ForumPollLog::getTotalVotersByPollId($this->getVar("poll_id"));

$sql = "UPDATE ".$bbTable['poll_desc']." SET votes=$votes, voters=$voters WHERE poll_id=".$this->getVar("poll_id")."";
$db->query($sql);
}

//---------------------------------------------------------------------------------------//
}
?>
