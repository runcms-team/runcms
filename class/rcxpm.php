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

if (!defined("RCX_RCXPM_INCLUDED")) {
  define("RCX_RCXPM_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxobject.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxPM extends RcxObject {

  function RcxPM($id=NULL)
  {
    $this->RcxObject();
    $this->initVar("msg_id", "int", NULL, false);
    $this->initVar("msg_image", "other", "icon1.gif", false, 100, false);
    $this->initVar("subject", "textbox", NULL, true, 255, false);
    $this->initVar("from_userid", "int", NULL, true);
    $this->initVar("to_userid", "int", NULL, true);
    $this->initVar("msg_time", "other", NULL, false);
    $this->initVar("msg_text", "textarea", NULL, true, NULL, false);
    $this->initVar("read_msg", "int", 0, false);
    
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

  if (!$this->isCleaned())
  {
    if (!$this->cleanVars())
    {
      return false;
    }
  }

  foreach ($this->cleanVars as $k=>$v)
  {
    $$k = $v;
  }

  if (empty($msg_id))
  {
    $msg_id = $db->genId($db->prefix("priv_msgs")."_msg_id_seq");
    $sql = "
      INSERT INTO ".$db->prefix("priv_msgs")." SET
      msg_id=".intval($msg_id).",
      msg_image='$msg_image',
      subject='$subject',
      from_userid=".intval($from_userid).",
      to_userid=".intval($to_userid).",
      msg_time=".time().",
      msg_text='$msg_text',
      read_msg=0";
  }

  if (!$result = $db->query($sql))
  {
    $this->errors[] = "Could not store message in the database.";
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
function load($id) {
  global $db;

  $sql   = "SELECT * FROM ".$db->prefix("priv_msgs")." WHERE msg_id=".$id."";
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

  $sql = "DELETE FROM ".$db->prefix("priv_msgs")." WHERE msg_id=".$this->getVar("msg_id")."";

  if (!$db->query($sql))
  {
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
function &getAllPM($criteria=array(), $asobject=false, $sort="msg_time", $order="ASC", $limit=0, $start=0) {
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
    $sql = "SELECT msg_id FROM ".$db->prefix("priv_msgs")."$where_query ORDER BY $sort $order";
    $result = $db->query($sql, $limit, $start);
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = $myrow['msg_id'];
    }
  }
  else
  {
    $sql = "SELECT * FROM ".$db->prefix("priv_msgs")."".$where_query." ORDER BY $sort $order";
    $result = $db->query($sql, $limit, $start);
    
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = new RcxPM($myrow);
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
function setRead() {
  global $db;

  $sql = "UPDATE ".$db->prefix("priv_msgs")." SET read_msg=1 WHERE msg_id=".$this->getVar("msg_id")."";

  if (!$db->query($sql))
  {
    return false;
  }

return true;
}

} // END RCXPM

}
?>
