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

include_once(RCX_ROOT_PATH."/class/rcxobject.php");

class RcxPollLog extends RcxObject {

        function RcxPollLog($id=NULL) {
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

/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
global $db;

if ( !$this->isCleaned() ) {
        if ( !$this->cleanVars() ) {
                return false;
        }
}

foreach ( $this->cleanVars as $k=>$v ) {
        $$k = $v;
}

$log_id = $db->genId($db->prefix("poll_log")."_log_id_seq");
$sql = "
        INSERT INTO ".$db->prefix("poll_log")." VALUES (
        ".intval($log_id).",
        ".intval($poll_id).",
        ".intval($option_id).",
        '$ip',
        ".intval($user_id).",
        ".time().")";

if ( !$result = $db->query($sql) ) {
        $this->setErrors(_NOTUPDATED);
        return false;
}

return $option_id;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
global $db;

$sql   = "SELECT * FROM ".$db->prefix("poll_log")." WHERE log_id=".$id."";
//$myrow = $db->fetch_array($db->query($sql));
$result= $db->query($sql);
$myrow = $db->fetch_assoc($result);
$this->set($myrow);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db;

$sql = "DELETE FROM ".$db->prefix("poll_log")." WHERE log_id=".$this->getVar("log_id")."";
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
function &getAllByPollId($poll_id, $orderby="time ASC") {
global $db;

  $ret = array();
  $sql = "SELECT * FROM ".$db->prefix("poll_log")." WHERE poll_id=".intval($poll_id)." ORDER BY $orderby";

  $result = $db->query($sql);
//  while ($myrow = $db->fetch_array($result))
  while ($myrow = $db->fetch_assoc($result))
  {
    $ret[] = new RcxPollLog($myrow);
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function hasVoted($poll_id, $ip, $user_id=NULL) {
global $db;

$sql = "SELECT COUNT(*) FROM ".$db->prefix("poll_log")." WHERE poll_id=".intval($poll_id)." AND";
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

/**
* Description
*
* @param type $var description
* @return type description
*/
function deleteByPollId($poll_id) {
global $db;

$sql = "DELETE FROM ".$db->prefix("poll_log")." WHERE poll_id=".intval($poll_id);
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
function deleteByOptionId($option_id) {
global $db;

$sql = "DELETE FROM ".$db->prefix("poll_log")." WHERE option_id=".intval($option_id);
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
function getTotalVotersByPollId($poll_id) {
global $db;

$sql   = "SELECT DISTINCT user_id FROM ".$db->prefix("poll_log")." WHERE poll_id=".intval($poll_id)." AND user_id > 0";
$users = $db->num_rows($db->query($sql));

$sql   = "SELECT DISTINCT ip FROM ".$db->prefix("poll_log")." WHERE poll_id=".intval($poll_id)." AND user_id=0";
$anons = $db->num_rows($db->query($sql));

return $users+$anons;
        }

/**
* Description
*
* @param type $var description
* @return type description
*/
function getTotalVotesByPollId($poll_id) {
global $db;

$sql = "SELECT COUNT(*) FROM ".$db->prefix("poll_log")." WHERE poll_id = ".intval($poll_id);
list($votes) = $db->fetch_row($db->query($sql));

return $votes;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getTotalVotesByOptionId($option_id) {
global $db;

$sql = "SELECT COUNT(*) FROM ".$db->prefix("poll_log")." WHERE option_id = ".intval($option_id);
list($votes) = $db->fetch_row($db->query($sql));

return $votes;
}
}
?>