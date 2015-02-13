<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("ERCX_SESSION_CLASS_INCLUDED")) {
  define("ERCX_SESSION_CLASS_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxUserSession {

  var $db;
  var $uid;
  var $uname;
  var $hash;
  var $pass;
  var $salt;
  var $cookie;
  var $expiretime;
  var $sessionID;
  var $use_unique_hash = false;


  function RcxUserSession($sessionID='', $use_unique_hash = false) {
    global $rcxConfig;

    $this->cookie     = $rcxConfig['session_name'];
    $this->expiretime = (int)$rcxConfig['session_expire'];

    if (!empty($sessionID)) {
      $this->sessionID = $sessionID;
    }
    
    $this->useUniqueHash($use_unique_hash);
  }
  
  /**
   * Enter description here...
   *
   * @return unknown
   */
  function getHash() {
      
      global $rcxConfig;
      
      $hash_str = $this->pass . $this->salt . rc_shatool($rcxConfig['dbhost'] . $rcxConfig['dbuname'] . $rcxConfig['dbpass'] . $rcxConfig['dbname']);
      
      if ($this->use_unique_hash == true) {
      	$hash_str .=  _HTTP_USER_AGENT . _REMOTE_ADDR;
      }
      
      return rc_shatool($hash_str);
  }
  
  /**
   * Enter description here...
   *
   * @param unknown_type $use_unique_hash
   */
  function useUniqueHash($unique_hash = true)
  {
  	$this->use_unique_hash = $unique_hash;
  }

/**
* creates new session for user
* and sets a cookie containing the session id
*
* @param type $var description
* @return type description
*/
function store() {
global $db, $rcxModule, $rcxConfig;

$mid_sql = '';
if ($rcxModule)
   $mid_sql = " mid=$rcxModule->mid,";

$db->query("DELETE FROM ".RC_SESS_TBL." WHERE uid=".$this->uid);

$this->hash = $this->getHash();

  if ($db->query("INSERT INTO ".RC_SESS_TBL." SET uid=".$this->uid.", uname='".$this->uname."', time=".time().", ip='"._REMOTE_ADDR."',".$mid_sql." hash='".$this->hash."'"))
  {
    $this->setCook();
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
function setUid($value) {
  $this->uid = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setUname($value) {
  $this->uname = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setPass($value) {
  $this->pass = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setSalt($value) {
  $this->salt = $value;
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
function isValid() {
global $db;

  $this->sessionID = stripslashes($this->sessionID);
  // Fix a security hole in PHP 4.3.9 and below...
  if (preg_match('~^a:[34]:\{i:0;(i:\d{1,6}|s:[1-8]:"\d{1,8}");i:1;s:(0|40):"([a-fA-F0-9]{40})?";i:2;[id]:\d{1,14};(i:3;i:\d;)?\}$~', $this->sessionID) == 1)
  {
    list ($uid, $uhash, $stime) = @unserialize($this->sessionID);
    $uid = !empty($uid) && strlen($uhash) == 40 ? (int) $uid : 0;
  }
  else
    return false;

$mintime = (time()-$this->expiretime);
$db->query("DELETE FROM ".RC_SESS_TBL." WHERE time<$mintime");

$sql = "SELECT u.uid, u.uname, u.pass, u.pwdsalt, s.hash FROM ".RC_USERS_TBL." u
        LEFT JOIN ".RC_SESS_TBL." s ON u.uid=s.uid 
        WHERE s.uid=".$uid." AND s.hash='".$uhash."'";
if (!$result = $db->query($sql))
  return false;

list($userid, $uname, $pass, $salt, $hash) = $db->fetch_row($result);

if ($uid == $userid) {
  $this->uid   = $userid;
  $this->uname = $uname;
  $this->pass  = $pass;
  $this->salt  = $salt;
  $this->hash  = $hash;
  return true;
}

return false;
}

/**
* updates the session table
*
* @param type $var description
* @return type description
*/
function update() {
global $db, $rcxConfig, $rcxModule;
  
  $mid_sql = '';
  if ($rcxModule)
    $mid_sql = ", mid=$rcxModule->mid";

  if ($db->query("UPDATE ".RC_SESS_TBL." SET time=".time()."$mid_sql WHERE uid=".$this->uid))
  {
    $this->setCook();
    return true;
  }
return false;
}

/**
* updates the set cookie
*
* @param type $var description
* @return type description
*/
function setCook() {
global $rcxConfig;

  $hash = $this->getHash();
  $data = serialize(array($this->uid, $hash, time()+$this->expiretime));
  
  if ($rcxConfig['use_sessions']==1)
  {
    $_SESSION[$rcxConfig['session_name']] = $data;
  }
  else
  {
    
      if ($rcxConfig['cookie_httponly']) {
          if(version_compare(PHP_VERSION, '5.2.0', '>=')) {
              setcookie($this->cookie, $data, time()+$this->expiretime, '/', '', 0, 1);
          } else {
              header("Set-Cookie: " . rawurlencode($this->cookie) . "=" . rawurlencode($data) . "; expires=" . gmdate('D, d-M-Y H:i:s', time()+$this->expiretime) . " GMT; path=/; httponly");
          }
      } else {
      	setcookie($this->cookie, $data, time()+$this->expiretime, '/', '', 0);
      }
  }

return true;
}
} // END RCXUSERSESSION

}
?>
