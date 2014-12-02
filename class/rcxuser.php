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

if (!defined("RCX_USER_INCLUDED")) {
  define("RCX_USER_INCLUDED", 1);

include_once(RCX_ROOT_PATH."/class/rcxobject.php");
include_once(RCX_ROOT_PATH."/class/rcxgroup.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
Class RcxUser extends RcxObject {

  var $inactive     = false;
  var $groups       = array();
  var $admin_groups = array();

  function RcxUser($id=NULL) {
  global $rcxConfig;

  $this->RcxObject();
  $this->initVar("uid", "int", NULL, false);
  $this->initVar("name", "textbox", NULL, false, 60, false);
  $this->initVar("uname", "textbox", NULL, true, 25, false);
	// new
	$this->initVar("birthday", "textbox", NULL, false, 4, false);
	$this->initVar("birthyear", "textbox", NULL, false, 4, false);
	$this->initVar("address", "textbox", NULL, false, 150, false);
	$this->initVar("town", "textbox", NULL, false, 60, false);
	$this->initVar("zip_code", "textbox", NULL, false, 7, false);
	$this->initVar("phone", "textbox", NULL, false, 15, false);
	// new

  $this->initVar("email", "textbox", NULL, true, 60, false);
  $this->initVar("url", "textbox", NULL, false, 100, false);
  $this->initVar("user_avatar", "textbox", NULL, false, 30);
  $this->initVar("user_regdate", "int", NULL, false);
  $this->initVar("user_icq", "textbox", NULL, false, 15, false);
  $this->initVar("user_from", "textbox", NULL, false, 100, true);
  $this->initVar("user_sig", "textarea", NULL, false, NULL, true);
  $this->initVar("user_viewemail", "int", 0, false);
  $this->initVar("actkey", "other", NULL, false);
  $this->initVar("user_aim", "textbox", NULL, false, 18, true);
  $this->initVar("user_yim", "textbox", NULL, false, 25, true);
  $this->initVar("user_msnm", "textbox", NULL, false, 25, true);
  $this->initVar("pass", "textbox", NULL, false, 40, false);
  $this->initVar("posts", "int", NULL, false);
  $this->initVar("attachsig", "int", 0, false);
  $this->initVar("rank", "int", NULL, false);
  $this->initVar("level", "int", 0, false);
  $this->initVar("theme", "other", NULL, false);
  $this->initVar("timezone_offset", "other", NULL, false);
  $this->initVar("last_login", "int", 0, false);
  $this->initVar("umode", "other", NULL, false);
  $this->initVar("uorder", "int", 1, false);
  $this->initVar("user_occ", "textbox", NULL, false, 100, true);
  $this->initVar("bio", "textarea", NULL, false, NULL, true);
  $this->initVar("user_intrest", "textbox", NULL, false, 150, true);
  $this->initVar("user_mailok", "int", 1, false);
  $this->initVar("language", "textbox", NULL, false, 32, false);
  $this->initVar("regip", "textbox", NULL, false, 15, false);
  $this->initVar("pwdsalt", "textbox", NULL, false, 4, false);

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
function login($uname, $pass) {
global $myts, $db;

$uname  = $myts->makeTboxData4Save($uname);
$result = $db->query("SELECT * FROM ".RC_USERS_TBL." WHERE uname='".$uname."'");
$rcuser = $db->num_rows($result);

  if (!$rcuser || count($rcuser) != 1)
  {
    return false;
  }
  else
  {
    $myrow = $db->fetch_array($result);
    if (empty($myrow['uid']))
    {
      return false;
    }
    else
    {
      $dbupass = $myrow['pass'];
      $uname = strtolower($uname);
      $shapwd = rc_shatool($uname.$pass);
      $convert = false;
      $passed  = false;
      if ($myrow['pass'] == $shapwd)
      {
        $passed = true;                // for some site who used md5 twice. If you know other means add too
      }
      elseif ((md5($pass) == $dbupass) || (md5(md5($pass)) == $dbupass))
      {
        $convert = true;
      }
      elseif (function_exists('crypt')) // backward compatibility only
      {
        if (crypt($pass, substr($dbupass, 0, 2)) == $dbupass)
        {
          $convert = true;
        }
      }
      if ($convert)
      {
        $myrow['pwdsalt'] = substr(md5(rand()), 0, 4);
        $myrow['pass'] = $shapwd;
        $db->query("UPDATE ".RC_USERS_TBL." SET pass='".$shapwd."', pwdsalt='".$myrow['pwdsalt']."' WHERE uname='".$uname."'");
        $passed  = true;
      }
      if ($passed)
      {
        return new RcxUser($myrow);
      }
    }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function updateLastLogin() {
global $db;

$db->query('UPDATE '.RC_USERS_TBL.' SET last_login='.time().' WHERE uid='.$this->getVar('uid'));
}

/**
* Logs out user
* removes user session from session table
*
* @param type $var description
* @return type description
*/
function logout() {
  global $db, $rcxConfig;

  $db->query("DELETE FROM ".RC_SESS_TBL." WHERE uid=".$this->getVar("uid")."");
  if ($rcxConfig['use_sessions'] == 1)
  {
    session_unset();
    session_destroy();
  }
  else
  {
    setcookie($rcxConfig['session_name'], '', false, '/', false, 0);
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
global $db, $objCache;

  if (!empty($objCache->RcxUser['load'][$id]))
  {
    $this->set($objCache->RcxUser['load'][$id]);
    if ($this->getVar("level") == 0)
    {
      $this->inactive = true;
    }
    
    return;
  }

  $sql = "SELECT * FROM ".RC_USERS_TBL." WHERE uid=".$id."";
  if (!$result = $db->query($sql))
  {
    die("ERROR when load user!");
  }

  $numrows = $db->num_rows($result);
  if ($numrows == 1)
  {
//    $myrow = $db->fetch_array($result);
    $myrow = $db->fetch_assoc($result);
    $this->set($myrow);
    $objCache->RcxUser['load'][$id] = $myrow;
    if ($this->getVar("level") == 0)
    {
      $this->inactive = true;
    }
  }
  elseif ($numrows == 0)
  {
    $this->inactive = true;
  }
  else
  {
    die("Duplicate User Entries!");
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

  if (empty($uid))
  {
    $uid = $db->genId(RC_USERS_TBL."_uid_seq");
    $sql = "
    INSERT INTO ".RC_USERS_TBL."
    SET uid=$uid
    , uname='$uname'
    , name='$name'
    , email='$email'
    , url='$url'
    , user_avatar='$user_avatar'
    , user_regdate=".time()."
    , user_icq='$user_icq'
    , user_from='$user_from'
    , user_sig='$user_sig'
    , user_viewemail='$user_viewemail'
    , actkey='$actkey'
    , user_aim='$user_aim'
    , user_yim='$user_yim'
    , user_msnm='$user_msnm'
    , pass='$pass'
    , posts='$posts'
    , attachsig='$attachsig'
    , rank='$rank'
    , level='$level'
    , theme='$theme'
    , timezone_offset='$timezone_offset'
    , last_login=0
    , umode='$umode'
    , uorder='$uorder'
    , user_occ='$user_occ'
    , bio='$bio'
    , user_intrest='$user_intrest'
    , user_mailok=$user_mailok
     , birthday='$birthday'
	 , birthyear='$birthyear'
     , address='$address'
	 , town='$town'
     , zip_code='$zip_code'
     , phone='$phone'
    , language='$language'
    , regip='$regip'
    , pwdsalt='$pwdsalt'";
  }
  else
  {
    $sql ="UPDATE ".RC_USERS_TBL." 
    SET uname='$uname'
    , name='$name'
    , email='$email'
    , url='$url'
    , user_avatar='$user_avatar'
    , user_icq='$user_icq'
    , user_from='$user_from'
    , user_sig='$user_sig'
    , user_viewemail='$user_viewemail'
   , user_aim='$user_aim'
    , user_yim='$user_yim'
    , user_msnm='$user_msnm'
    , pass='$pass'
    , attachsig='$attachsig'
    , rank='$rank'
    , theme='$theme'
    , timezone_offset='$timezone_offset'
    , umode='$umode'
    , uorder='$uorder'
    , user_occ='$user_occ'
    , bio='$bio'
    , user_intrest='$user_intrest'
    , user_mailok=$user_mailok
    , birthday='$birthday'
	, birthyear='$birthyear'
    , address='$address'
	, town='$town'
    , zip_code='$zip_code'
    , phone='$phone'
    , language='$language'
	, regip='$regip'
    , pwdsalt='$pwdsalt'
    WHERE uid=$uid";
  }

  if (!$result = $db->query($sql))
  {
    $this->setErrors("Could not store data in database.");
    return false;
  }

  if (empty($uid))
  {
    $uid = $db->insert_id();
  }

  return $uid;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
  global $db;

  if ($this->getVar("uid") > 0)
  {
    $sql = "DELETE FROM ".RC_USERS_TBL." WHERE uid=".$this->getVar("uid")."";
    if (!$result = $db->query($sql))
    {
      return false;
    }
    $db->query("DELETE FROM ".RC_GRP_USERS_LINK_TBL." WHERE uid=".$this->getVar("uid")."");
//  $db->query("DELETE FROM ".$db->prefix("groups_users_link")." WHERE uid=".$this->getVar("uid")."");
//  $db->query("DELETE FROM ".$db->prefix("bb_forum_mods")." WHERE user_id=".$this->getVar("uid")."");
//  $db->query("DELETE FROM ".$db->prefix("priv_msgs")." WHERE to_userid=".$this->getVar("uid")."");
    $avatar = avatarExists($this->getVar("uid"));
    if ($avatar)
    {
      @unlink(RCX_ROOT_PATH. '/images/avatar/'.$avatar);
    }
// skulle stoppe du bliver smidt af ved sletning    
//    $this->logout();
  }

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function activate() {
  global $db;

  $sql = "UPDATE ".RC_USERS_TBL." SET level=1 WHERE uid=".$this->getVar("uid")." AND actkey='".$this->getVar("actkey")."'";

  if (!$result = $db->query($sql))
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
function isActive() {

  if ($this->inactive == true)
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
function isAdmin($moduleid=0) {

  if ($this->admin_groups[$moduleid] == TRUE)
  {
    return true;
  }
  else
  {
    $this->admin_groups[$moduleid] = RcxGroup::checkRight("module", $moduleid, $this->groups(), "A");
    if ($this->admin_groups[$moduleid] == TRUE)
    {
      return true;
    }
  }

return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &rank($astitle=true) {
  global $objCache;

  $uid = $this->getVar('uid');
  
  if ($astitle)
  {
    if ($objCache->RcxUser['rank']['title'][$uid])
    {
      return $objCache->RcxUser['rank']['title'][$uid];
    }

    $objCache->RcxUser['rank']['title'][$uid] = $this->getRank();
    return $objCache->RcxUser['rank']['title'][$uid];
  }
  else
  {
    if ($objCache->RcxUser['rank']['normal'][$uid])
    {
      return $objCache->RcxUser['rank']['normal'][$uid];
    }
    
    $objCache->RcxUser['rank']['normal'][$uid] = $this->getVar("rank");
    return $objCache->RcxUser['rank']['normal'][$uid];
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getRank() {
  global $db, $myts, $objCache;

  if ($this->getVar("rank") != 0)
  {
    $sql = "SELECT rank_title AS title, rank_image AS image FROM ".RC_RANKS_TBL." WHERE rank_id = ".$this->getVar("rank")."";
  }
  else
  {
    $sql = "SELECT rank_title AS title, rank_image AS image FROM ".RC_RANKS_TBL." WHERE rank_min <= " . $this->getVar("posts") . " AND rank_max >= " . $this->getVar("posts") . " AND rank_special = 0";
  }

  $result = $db->query($sql);
  $myrow  = $db->fetch_array($result);
  $myrow['title'] = $myts->makeTboxData4Show($myrow['title']);
  $myrow['id']    = $this->getVar("rank");

return $myrow;
}

/**
* returns an array of group ids this user belongs
*
* @param type $var description
* @return type description
*/
function &groups() {

  if (empty($this->groups))
  {
    $this->groups = RcxGroup::getByUser($this);
  }

return $this->groups;
}

/**
* Function to get user name from a certain user id
*
* @param type $var description
* @return type description
*/
function getUnameFromId($userid) {
  global $rcxConfig, $myts, $db, $objCache;

  if ($objCache->RcxUser['uname'][$userid])
  {
    return $objCache->RcxUser['uname'][$userid];
  }

  $sql = "SELECT uname FROM ".RC_USERS_TBL." WHERE uid = $userid";

  if (!$result = $db->query($sql))
  {
    return false;
  }

  if (!$arr = $db->fetch_array($result))
  {
    return false;
  }

  $uname = $myts->makeTboxData4Show($arr['uname']);
  $objCache->RcxUser['uname'][$userid] = $uname;

return $uname;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function incrementPost($uid) {
  global $db;

  $sql    = "UPDATE ".RC_USERS_TBL." SET posts=posts+1 WHERE uid=".$uid."";
  $result = $db->query($sql);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function isOnline() {
  global $db, $objCache;

  if (isset($objCache->RcxUser['isonline'][$this->getVar('uid')]))
  {
    return $objCache->RcxUser['isonline'][$this->getVar('uid')];
  }

  $time = (time() - 300);
  $sql  = 'SELECT COUNT(*) FROM '.RC_SESS_TBL.' WHERE uid='.$this->getVar('uid').' AND time > '.$time;

  if (!$result = $db->query($sql))
  {
    $objCache->RcxUser['isonline'][$this->getVar('uid')] = false;
    return false;
  }

  list($count) = $db->fetch_row($result);
  if ($count > 0)
  {
    $objCache->RcxUser['isonline'][$this->getVar('uid')] = true;
    return true;
  }

  $objCache->RcxUser['isonline'][$this->getVar('uid')] = false;
return false;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function &getAllUsers($criteria=array(), $asobject=false, $orderby="uid ASC", $limit=0, $start=0){
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
    $sql = "SELECT uid FROM ".RC_USERS_TBL."$where_query ORDER BY $orderby";
    $result = $db->query($sql,$limit,$start);
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = $myrow['uid'];
    }
  }
  else
  {
    $sql = "SELECT * FROM ".RC_USERS_TBL."".$where_query." ORDER BY $orderby";
    $result = $db->query($sql,$limit,$start);
    while ($myrow = $db->fetch_array($result))
    {
      $ret[] = new RcxUser($myrow);
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
function &getAllUsersList($criteria=array(), $orderby="uid ASC", $limit=0, $start=0) {
  global $myts, $db;

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

  $sql = "SELECT uid, uname FROM ".RC_USERS_TBL."".$where_query." ORDER BY $orderby";
  $result = $db->query($sql,$limit,$start);

  while ($myrow = $db->fetch_array($result))
  {
    $ret[$myrow['uid']] = $myts->makeTboxData4Show($myrow['uname']);
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function countAllUsers($criteria=array()) {
  global $db;

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

  $sql       = "SELECT COUNT(*) FROM ".RC_USERS_TBL."".$where_query."";
  $result    = $db->query($sql);
  list($ret) = @$db->fetch_row($result);

return $ret;
}


//### Methods from here will be deprecated. Use getVar() instead! ###

function uid() {
  return $this->getVar("uid");
}

function name($format="S") {
  return $this->getVar("name", $format);
}

function uname($format="S") {
  return $this->getVar("uname", $format);
}

function email($format="S") {
  return $this->getVar("email", $format);
}

function url($format="S") {
  return $this->getVar("url", $format);
}

function user_avatar($format="S") {
  return $this->getVar("user_avatar");
}

function user_regdate() {
  return $this->getVar("user_regdate");
}

function user_icq($format="S") {
  return $this->getVar("user_icq", $format);
}

function user_from($format="S") {
  return $this->getVar("user_from", $format);
}

function user_sig($format="S") {
    return $this->getVar("user_sig", $format);
}

function user_viewemail() {
  return $this->getVar("user_viewemail");
}

function actkey() {
  return $this->getVar("actkey");
}
function user_aim($format="S") {
  return $this->getVar("user_aim", $format);
}

function user_yim($format="S") {
  return $this->getVar("user_yim", $format);
}
function user_msnm($format="S") {
  return $this->getVar("user_msnm", $format);
}

function pass() {
  return $this->getVar("pass");
}

function posts() {
  return $this->getVar("posts");
}

function attachsig() {
  return $this->getVar("attachsig");
}

function level() {
  return $this->getVar("level");
}

function theme() {
  return $this->getVar("theme");
}

function timezone() {
  return $this->getVar("timezone_offset");
}

function umode() {
  return $this->getVar("umode");
}

function uorder() {
  return $this->getVar("uorder");
}

function user_occ($format="S") {
  return $this->getVar("user_occ", $format);
}

function bio($format="S") {
  return $this->getVar("bio", $format);
}

function user_intrest($format="S") {
  return $this->getVar("user_intrest", $format);
}

function last_login() {
  return $this->getVar("last_login");
}

function language($format="S") {
  return $this->getVar("language", $format);
}

function regip($format="S") {
  return $this->getVar("regip", $format);
}

function pwdsalt() {
  return $this->getVar("pwdsalt");
}
} // END RCXUSER

}
?>
