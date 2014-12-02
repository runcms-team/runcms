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

class RcxPoll extends RcxObject {

  function RcxPoll($id=NULL)
  {
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
    
    if (!empty($id))
    {
      if (is_array($id))
      {
        $this->set($id);
      }
      else
      {
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

$start_time = empty($start_time) ? time() : $start_time;

if ( $end_time <= $start_time ) {
        $this->setErrors(_AM_FUTURETIME);
        return false;
}

if ( empty($poll_id) ) {
        $poll_id = $db->genId($db->prefix("poll_desc")."_poll_id_seq");
        $sql = "
                INSERT INTO ".$db->prefix("poll_desc")." VALUES (
                ".intval($poll_id).",
                '$question',
                '$description',
                ".intval($user_id).",
                ".intval($start_time).",
                ".intval($end_time).",
                0,
                0,
                ".intval($multiple).",
                ".intval($display).",
                ".intval($weight).",
                ".intval($mail_status).")";

        } else {
                $sql ="UPDATE ".$db->prefix("poll_desc")." SET question='$question', description='$description', start_time='$start_time', end_time='$end_time', display='$display', weight='$weight', multiple='$multiple', mail_status='$mail_status' WHERE poll_id=$poll_id";
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
global $db;

$sql   = "SELECT * FROM ".$db->prefix("poll_desc")." WHERE poll_id=".intval($id)."";
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
global $db;

$sql = "DELETE FROM ".$db->prefix("poll_desc")." WHERE poll_id=".$this->getVar("poll_id")."";
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
  global $db;

  $ret = array();
  $where_query = "";

  if (is_array($criteria) && count($criteria) > 0)
  {
    $where_query = " WHERE";
    foreach ($criteria as $c)
    {
      $where_query .= " $c AND";
    }
    $where_query = substr($where_query, 0, -4);
  }

  if (!$asobject)
  {
    $sql = "SELECT poll_id FROM ".$db->prefix("poll_desc")."$where_query ORDER BY $orderby";
    $result = $db->query($sql, intval($limit), intval($start));
//    while ($myrow = $db->fetch_array($result))
    while ($myrow = $db->fetch_assoc($result))
    {
      $ret[] = $myrow['poll_id'];
    }
  }
  else
  {
    $sql = "SELECT * FROM ".$db->prefix("poll_desc")."".$where_query." ORDER BY $orderby";
    $result = $db->query($sql, intval($limit), intval($start));
//    while ($myrow = $db->fetch_array($result))
    while ($myrow = $db->fetch_assoc($result))
    {
      $ret[] = new RcxPoll($myrow);
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
                        $option = new RcxPollOption($vote);
                        if ( $this->getVar("poll_id") == $option->getVar("poll_id") ) {
                                $log = new RcxPollLog();
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
                        $option = new RcxPollOption($option_id);
                        if ( $this->getVar("poll_id") == $option->getVar("poll_id") ) {
                                $log = new RcxPollLog();
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
global $db;

$votes  = RcxPollLog::getTotalVotesByPollId($this->getVar("poll_id"));
$voters = RcxPollLog::getTotalVotersByPollId($this->getVar("poll_id"));

$sql = "UPDATE ".$db->prefix("poll_desc")." SET votes=$votes, voters=$voters WHERE poll_id=".$this->getVar("poll_id")."";
$db->query($sql);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function comment_count($poll_id) {
global $db;

$sql    = "SELECT COUNT(*) FROM ".$db->prefix("pollcomments")." WHERE item_id=".intval($poll_id)."";
$result = $db->query($sql);
list($count) = @$db->fetch_row($result);

return intval($count);
}
}
?>