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

if (!defined("RCX_RCXGROUP_INCLUDED")) {
  define("RCX_RCXGROUP_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxobject.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxGroup extends RcxObject {

  var $admin_right_modules = array();
  var $read_right_modules  = array();
  var $read_right_blocks   = array();


  function RcxGroup($id = NULL)
  {
    $this->RcxObject();
    $this->initVar("groupid", "int", NULL, false);
    $this->initVar("name", "textbox", NULL, true, 100, false);
    $this->initVar("description", "textarea", NULL, true);
    $this->initVar("type", "other", NULL, false);

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
function load($groupid) {
global $db;

$sql = "SELECT * FROM ".RC_GROUP_TBL." WHERE groupid=".$groupid."";
$result = $db->query($sql);
$arr = $db->fetch_assoc($result);
$this->set($arr);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setAdminRightModules($arr=array()) {
  sort($arr);
  $this->admin_right_modules = $arr;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setReadRightModules($arr=array()) {
  sort($arr);
  $this->read_right_modules = $arr;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setReadRightBlocks($arr=array()) {
  sort($arr);
  $this->read_right_blocks = $arr;
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

  if (empty($type))
  {
    if (is_array($this->admin_right_modules) && count($this->admin_right_modules)>0)
    {
      $type = "Admin";
    }
    else
    {
      $type = "Custom";
    }
  }

  if (empty($groupid))
  {
    $groupid = $db->genId(RC_GROUP_TBL."_groupid_seq");
    $sql     = "INSERT INTO ".RC_GROUP_TBL." SET groupid=$groupid, name='".$name."', description='".$description."', type='".$type."'";
  }
  else
  {
    $sql = "DELETE FROM ".RC_GRP_MOD_LINK_TBL." WHERE groupid=".$groupid."";
    if (!$result = $db->query($sql))
    {
      exit();
    }
    $sql = "DELETE FROM ".RC_GRP_BLOCK_LINK_TBL." WHERE groupid=".$groupid."";
    if (!$result = $db->query($sql))
    {
      exit();
    }
    $sql = "UPDATE ".RC_GROUP_TBL." SET name='".$name."', description='".$description."', type='".$type."' WHERE groupid=".$groupid."";
  }

  if (!$result = $db->query($sql))
  {
    $this->setErrors("Could not store data in database.");
    return false;
  }

  if (empty($groupid))
  {
    $groupid = $db->insert_id();
  }

  foreach($this->admin_right_modules as $admin_right_module)
  {
    $sql = "INSERT INTO ".RC_GRP_MOD_LINK_TBL." SET groupid=$groupid, mid=$admin_right_module, type='A'";
    $result = $db->query($sql);
    $sql = "INSERT INTO ".RC_GRP_MOD_LINK_TBL." SET groupid=$groupid, mid=$admin_right_module, type='R'";
    $result = $db->query($sql);
  }

  foreach($this->read_right_modules as $read_right_module)
  {
    if (!in_array($read_right_module, $this->admin_right_modules))
    {
      $sql = "INSERT INTO ".RC_GRP_MOD_LINK_TBL." SET groupid=$groupid, mid=$read_right_module, type='R'";
      $result = $db->query($sql);
    }
  }

  foreach($this->read_right_blocks as $read_right_block)
  {
    $sql = "INSERT INTO ".RC_GRP_BLOCK_LINK_TBL." SET groupid=$groupid, block_id=$read_right_block, type='R'";
    $result = $db->query($sql);
  }

 // Clear Cache
  $db->clear_cache('blocks_');
  // end Clear Cache
return $groupid;
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
  global $db;

  $gid = $this->getVar("groupid");
  
  if (!$result = $db->query("DELETE FROM ".RC_GROUP_TBL." WHERE groupid=".$gid.""))
  {
    exit();
  }

  $result = $db->query("DELETE FROM ".RC_GRP_USERS_LINK_TBL." WHERE groupid=".$gid."");
  $result = $db->query("DELETE FROM ".RC_GRP_MOD_LINK_TBL." WHERE groupid=".$gid."");
  $result = $db->query("DELETE FROM ".RC_GRP_BLOCK_LINK_TBL." WHERE groupid=".$gid."");

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function checkRight($which, $id, $groupid=0, $type="R") {
  global $db;

  if ($which == "module")
  {
    $table  = "groups_modules_link";
    $column = "mid";
  }
  elseif ($which == "block")
  {
    $table  = "groups_blocks_link";
    $column = "block_id";
  }

  $sql = "SELECT COUNT(*) FROM ".$db->prefix($table)." WHERE  type='".$type."'";

  if (!empty($id))
  {
    $sql .= " AND ".$column."=".$id."";
  }

  if (is_array($groupid))
  {
    $sql .= " AND (groupid=".$groupid[0]."";
    $size = count($groupid);
    if ($size > 1)
    {
      for ($i=1; $i<$size; $i++)
      {
        $sql .= " OR groupid=".$groupid[$i]."";
      }
    }
  
  $sql .= ")";
  }
  elseif ($groupid != 0)
  {
    $sql .= " AND groupid=".$groupid."";
  }
  else
  {
    $grouparray = RcxGroup::getByType("Anonymous");
    $sql .= " AND groupid=".$grouparray[0]."";
  }

  list($count) = $db->fetch_row($db->query($sql));

  if ($count > 0)
  {
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
static function &getByUser(&$user, $asobject=false) {
  global $db;

  $ret = array();

  if (strtolower(get_class($user)) == "rcxuser")
  {
    $sql    = "SELECT g.* FROM ".RC_GROUP_TBL." g LEFT JOIN ".RC_GRP_USERS_LINK_TBL." l ON l.groupid=g.groupid WHERE l.uid=".$user->getVar("uid")."";
    $result = $db->query($sql);
    if (!$db->num_rows($result))
    {
      $group_arr =& RcxGroup::getByType("User", true);
      $group_arr[0]->addMember($user);
      if ($asobject)
      {
        $ret[] = $group_arr[0];
      }
      else
      {
        $ret[] = $group_arr[0]->getVar("groupid");
      }
    }
    else
    {
      while ($myrow = $db->fetch_array($result))
      {
        if ($asobject)
        {
          $ret[] = new RcxGroup($myrow);
        }
        else
        {
          $ret[] = $myrow['groupid'];
        }
      }
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
static function &getByType($type="", $asobject=false, $sort="groupid", $order="ASC") {
  global $db;

  $ret = array();
  $where_query = "";

  if (!empty($type))
  {
    $where_query = " WHERE type='".$type."'";
  }

  if (!$asobject)
  {
    $sql = "SELECT groupid FROM ".RC_GROUP_TBL."".$where_query." ORDER BY $sort $order";
    $result = $db->query($sql);
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = $myrow['groupid'];
    }
  }
  else
  {
    $sql = "SELECT * FROM ".RC_GROUP_TBL."".$where_query." ORDER BY $sort $order";
    $result = $db->query($sql);
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = new RcxGroup($myrow);
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
static function &getAllGroupsList($criteria=array(), $sort="groupid", $order="ASC") {
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

  $sql    = "SELECT groupid, name FROM ".RC_GROUP_TBL."$where_query ORDER BY $sort $order";
  $result = $db->query($sql);

  while ($myrow = $db->fetch_array($result))
  {
    $ret[$myrow['groupid']] = $myrow['name'];
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getMembers($asobject=false) {
  global $db;

  $ret = array();

  if (!$asobject)
  {
    $sql    = "SELECT uid FROM ".RC_GRP_USERS_LINK_TBL." WHERE groupid=".$this->getVar("groupid")." GROUP BY uid";
    $result = $db->query($sql);
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = $myrow['uid'];
    }
  }
  else
  {
    $sql = "
      SELECT u.* FROM
      ".$db->prefix("groups_users_link")." l,
      ".$db->prefix("users")." u
      WHERE
      l.groupid=".$this->getVar("groupid")."
      AND
      u.uid=l.uid";

    $result = $db->query($sql);
    
    while ($myrow = $db->fetch_array($result))
    {
      $obj   = new RcxUser($myrow);
      $ret[] = $obj;
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
function addMember(&$user) {
global $db;

  if (strtolower(get_class($user)) == "rcxuser")
  {
    $db->query("INSERT INTO ".RC_GRP_USERS_LINK_TBL." SET groupid=".$this->getVar("groupid").", uid=".$user->getVar("uid")."");
    return true;
  }

return false;
}

} // END CLASS GROUP

}
?>
