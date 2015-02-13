<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: proprietary
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

include_once(RCX_ROOT_PATH.'/include/version.php');

// ############# Include basic constructor classes ##############
unset($rcxUser);
include_once(RCX_ROOT_PATH.'/class/rcxobject.php');
include_once(RCX_ROOT_PATH.'/class/rcxgroup.php');
include_once(RCX_ROOT_PATH.'/class/rcxuser.php');
include_once(RCX_ROOT_PATH.'/class/rcxmodule.php');
include_once(RCX_ROOT_PATH.'/class/rcxblock.php');
/**
* Description
*
* @param type $var description
* @return type description
*/
class core_api {

  var $env;

  function core_api() {
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function rc_getenv($var, $type='E') {

$types = explode(' ', $type);
$size  = count($types);

if ( !empty($size) ) {
  for ($i=0; $i<$size; $i++) {
    $sw = strtoupper($types[$i]);
    switch ($sw) {
      case 'G':
        global $_GET;
        return isset($_GET[$var]) ? $_GET[$var] : false;

      case 'P':
        global $_POST;
        return isset($_POST[$var]) ? $_POST[$var] : false;

      case 'C':
        global $_COOKIE;
        return isset($_COOKIE[$var]) ? $_COOKIE[$var] : false;

      case 'E':
        global $_SERVER, $_ENV;
        return isset($_SERVER[$var]) ? $_SERVER[$var] : @$_ENV[$var];

      case 'F':
        global $_FILES;
        return isset($_FILES[$var]) ? $_FILES[$var] : false;

      case 'S':
        global $_SESSION;
        return isset($_SESSION[$var]) ? $_SESSION[$var] : false;
    }
  }
}

return false;
}
//--------------//
function getip() {
  if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
  {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
    $ip = preg_replace('/,.*/', '', $ip);
  }
  elseif (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
    $ip = getenv("HTTP_CLIENT_IP");
  elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
    $ip = getenv("REMOTE_ADDR");
  elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
    $ip = $_SERVER['REMOTE_ADDR'];
  else
    $ip = "unknown";

  return($ip == "unknown" ? $ip : preg_replace("/[^0-9\.]/", "", $ip));
}
//------------//
}
$rcxBadUnames = file(RCX_ROOT_PATH.'/modules/system/cache/badunames.php');
$rcxBadEmails = file(RCX_ROOT_PATH.'/modules/system/cache/bademails.php');
$rcxBadWords  = file(RCX_ROOT_PATH.'/modules/system/cache/badwords.php');
$rcxBadIps    = file(RCX_ROOT_PATH.'/modules/system/cache/badips.php');
$rcxBadAgents = file(RCX_ROOT_PATH.'/modules/system/cache/badagents.php');

?>
