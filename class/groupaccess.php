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

if (!defined("ERCX_GROUPACCESS_INCLUDED")) {
  define("ERCX_GROUPACCESS_INCLUDED", 1);

include_once(RCX_ROOT_PATH . '/class/rcxgroup.php');
// include_once(RCX_ROOT_PATH."/class/groupaccess.inc.php");

class groupAccess {

  var $table;
  var $field;
  var $item;

  var $groupname;

  var $groups      = array();
  var $user_groups = array();

  function groupAccess($groupname='groupid') {
  global $rcxUser;

  $this->groupname = $groupname;

  $this->user_groups = RcxGroup::getByType("Anonymous");
  if ($rcxUser) {
    $this->user_groups = array_merge($this->user_groups, $rcxUser->groups());
  }
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadGroups($id, $item, $table, $field='groupid') {
global $db;

$this->table = $db->prefix($table);
$this->field = $field;
$this->item  = $item;

if ($result = $db->query("SELECT ".$this->field." FROM ".$this->table." WHERE ".$this->item."='$id'")) {
  list($groups) = $db->fetch_row($result);
  unset($this->groups[$this->groupname]);
  $this->addGroups($groups, 1);
  return(TRUE);
}

return(FALSE);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function loadGroupsOptions($groupid) {

  if ($groupid)
  {
    $this->addGroups($groupid, 1);
    return(TRUE);
  }

return(FALSE);
}
/**
* Makes sure $groupid is a space delimited string and not an array, before saving to database.

* @return string A space delimited string of group ID's
*/
function saveGroups($id) {
global $db;

  $groups = array();

  foreach ($this->groups[$this->groupname] as $key => $value)
  {
    if ($value == 1)
      $groups[$key] = $key;
  }

  $groups = implode(" ", $groups);

  if ($result = $db->query("UPDATE ".$this->table." SET ".$this->field."='$groups' WHERE ".$this->item."='$id'"))
    return(TRUE);


return(FALSE);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function addGroups($groups, $allow=1) {

  if (!is_array($groups))
    $groups = explode(" ", $groups);

  ($allow == 1) ? $allow = 1 : $allow = 0;

  foreach ($groups as $key)
  {
    $this->groups[$this->groupname][$key] = $allow;
  }

}

/**
* Description
*
* @param type $var description
* @return type description
*/
function removeGroups($groups, $allow=1) {

  if (!is_array($groups))
    $groups = explode(" ", $groups);

  ($allow == 1) ? $allow = 0 : $allow = 1;

  foreach ($groups as $key)
  {
    $this->groups[$this->groupname][$key] = $allow;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function checkGroups($allow=1) {

  ($allow == 1) ? $allow = 1 : $allow = 0;
  $group_size = count($this->groups);
  $user_size  = count($this->user_groups);
  $size = ($group_size > $user_size) ? $group_size : $user_size;

  foreach ($this->groups[$this->groupname] as $key => $value)
  {
    if ($value == $allow)
    {
      if (@in_array($key, $this->user_groups))
        return(TRUE);
    }
  }

return(FALSE);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function listGroups() {
global $db, $myts, $_POST;

  if (!empty($_POST[$this->groupname]))
  {
    unset($this->groups[$this->groupname]);
    $this->addGroups($_POST[$this->groupname], 1);
  }

  if ($result = $db->query("SELECT groupid, name FROM ".RC_GROUP_TBL." ORDER BY name ASC"))
  {
    $i=0;
    $grouplist='';
    while (list($gid, $name) = $db->fetch_row($result))
    {
      if ($i == "4")
      {
        $grouplist .= "<br />";
        $i=0;
      }
      $grouplist .= "<input type='checkbox' class='checkbox' name='".$this->groupname."[$gid]' value='$gid'";
      if (empty($this->groups[$this->groupname]) || $this->groups[$this->groupname][$gid] == 1)
        $grouplist .= " checked";
      
      $grouplist .= " />".$myts->makeTboxData4Show($name);
      $i++;
    }
  }
return $grouplist;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function groups($style=1, $type=1) {

  ($type == 1) ? $type = 1 : $type = 0;

  if ($style == 1)
    return array_keys($this->groups[$this->groupname], $type);
  else
    return implode(" ", array_keys($this->groups[$this->groupname], $type));
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function userGroups($style=1) {

  if ($style == 1)
    return $this->user_groups;
  else
    return implode(" ", $this->user_groups);
}
} // END CLASS
class RcxDownload {
  function isAccessible($lid)
  {
    global $db,$rcxUser;
    
    if ($rcxUser)
      $groups = $rcxUser->groups();
    else
      $groups = RcxGroup::getByType("Anonymous");

    $query = "select count(*) from ".$db->prefix("downloads_downloads")." where lid = $lid and (";

    $first = true;
    foreach ($groups as $group)
    {
      if (!$first)
        $query.= " or ";

      if ($first == true) 
        $first = false;
      $query.= "groups like '%$group%'";
    }
    $query.= ")";

    $result = $db->query($query);
    list($ret) = $db->fetch_row($result);
    if ($ret > 0)
      return true;
    else
      return false;
  }

  function countDownloadsByCategory($cid)
  {
    global $db,$rcxUser;
    if ($rcxUser)
      $groups = $rcxUser->groups();
    else
      $groups = RcxGroup::getByType("Anonymous");

    $query = "select count(*) from ".$db->prefix("downloads_downloads")." where cid = $cid and (";

    $first = true;
    foreach ($groups as $group)
    {
      if (!$first)
        $query.= " or ";

      if ($first == true)
        $first = false;
      
      $query.= "groups like '%$group%'";
    }
    $query.= ")";

    $result = $db->query($query);
    list($ret) = $db->fetch_row($result);

    return $ret;
  }


  function countDownloads()
  {
    global $db,$rcxUser;
    if ($rcxUser)
      $groups = $rcxUser->groups();
    else
      $groups = RcxGroup::getByType("Anonymous");

    $query = "select count(*) from ".$db->prefix("downloads_downloads")." where ";

    $first = true;
    foreach ( $groups as $group )
    {
      if (!$first)
        $query.= " or ";

      if ($first == true)
        $first = false;

      $query.= "groups like '%$group%'";
    }

    $result = $db->query($query);
    list($ret) = $db->fetch_row($result);

    return $ret;
  }

  function printGroups($selected="")
  {
    global $db;

    $groups = $db->query("select groupid,name from ".RC_GROUP_TBL." order by name asc");
    while ($group = $db->fetch_array($groups))
    {
      echo '<input name="group_ids[]" type="checkbox" value="'.$group["groupid"].'"';
      if (!empty($selected) && @is_array($selected))
      {
        foreach ($selected as $sel)
        {
          if ($sel == $group['groupid'])
          {
            echo ' checked';
            break;
          }
        }
      }else
      {
        echo ' checked';
      }
      echo ' /> '.$group["name"].'<br />';
    }
  }


  function makeTboxData4SaveGroups($groups)
  {
    if (!empty($groups) && @is_array($groups))
      return implode(",",$groups);
    else
      return 0;
  }


} // END CLASS
}


