<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined('RCX_MAINFILE_INCLUDED')) {
  die('Sorry, but this file cannot be requested directly');
} else {
  error_reporting(2039); // 2047 for debug also setup in /class/database.php for other way set 2039
  function rc_stripslashes_deep($value)
  { // function renamed for conflict prevention
    return (is_array($value) ? array_map('rc_stripslashes_deep', $value) : stripslashes($value));
  }
  // ######### Backward compatibility array ####################
  if (!isset($_SERVER))
  {
    $_GET     = &$HTTP_GET_VARS;
    $_POST    = &$HTTP_POST_VARS;
    $_ENV     = &$HTTP_ENV_VARS;
    $_SERVER  = &$HTTP_SERVER_VARS;
    $_COOKIE  = &$HTTP_COOKIE_VARS;
  $_SESSION = &$HTTP_SESSION_VARS; 
    $_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
  }
  if (get_magic_quotes_gpc())
  {
    $_REQUEST = array_map('rc_stripslashes_deep', $_REQUEST);
  }
  set_magic_quotes_runtime(0);
if (!ini_get('register_long_arrays'))
{
 $HTTP_POST_VARS =& $_POST;
 $HTTP_GET_VARS =& $_GET;
 $HTTP_COOKIE_VARS =& $_COOKIE;
 $HTTP_SERVER_VARS =& $_SERVER;
 $HTTP_ENV_VARS =& $_ENV;
 $HTTP_POST_FILES =& $_FILES;
}
  // ################## Include core ###########################
  include_once(RCX_ROOT_PATH.'/class/core.php');
  require_once(RCX_ROOT_PATH.'/class/rctoken.php');
  $api = new core_api();
  $objCache = new stdClass();
// #################### Include global config files ###############
  include_once(RCX_ROOT_PATH.'/modules/system/cache/config.php');
  include_once(RCX_ROOT_PATH.'/modules/system/cache/editor.php');
  if (intval($rcxConfig['gzip_compression']) == 1)
  {
    if (extension_loaded('zlib') && !headers_sent())
    {
      ob_start('ob_gzhandler');
    }
  }
  else
  {
    ob_start();
  }
//################### sql injection protection class  ###########################
require_once(RCX_ROOT_PATH.'/class/class_sql_inject.php');
if ($_SERVER["QUERY_STRING"] != "")
{
  $log = RCX_ROOT_PATH.'/cache/sqlinject.txt' ;
  $redirect = RCX_URL."/abuse.php" ;
  $sql = new sql_inject($log,TRUE,$redirect);
  $sql->test($_SERVER["QUERY_STRING"]);
}
// abuse hack 
// #################### Detect variables now, reuse later ###########################
define('_PHP_SELF', $_SERVER['PHP_SELF']);
//define('_PHP_SELF', $api->rc_getenv('PHP_SELF'));
// SERVER followed by ENV comparison :: apache/iis, cgi/isapi :: ..so check'em all :)
define('_HTTP_HOST'       , $api->rc_getenv('HTTP_HOST'));
define('_QUERY_STRING'    , $api->rc_getenv('QUERY_STRING'));
define('_SCRIPT_NAME'     , $api->rc_getenv('SCRIPT_NAME'));
define('_HTTP_REFERER'    , $api->rc_getenv('HTTP_REFERER'));
define('_REQUEST_METHOD'  , $api->rc_getenv('REQUEST_METHOD'));
define('_HTTP_USER_AGENT' , $api->rc_getenv('HTTP_USER_AGENT'));
$R_URI = $api->rc_getenv('REQUEST_URI');
!empty($R_URI) ? define('_REQUEST_URI', $R_URI) : define('_REQUEST_URI', _PHP_SELF.'?'._QUERY_STRING);
define('_REMOTE_ADDR', $api->getip());
//CHECKING FOR GET VARS ABUSERS
//CHECK $_GET
$abuse = false;
$my_get_vars = is_array($_GET) ? $_GET : $HTTP_GET_VARS;

/**
 * (kromped at yahoo dot com) http://php.net/manual/en/function.implode.php#96100
 */
function r_implode( $glue, $pieces )
{
  foreach( $pieces as $r_pieces ) {
    if( is_array( $r_pieces ) ) {
      $retVal[] = r_implode( $glue, $r_pieces );
    } else {
      $retVal[] = $r_pieces;
    }
  }
  return implode( $glue, $retVal );
} 

foreach ($my_get_vars as $key => $content) {
    
  if (is_array($content)) $content = r_implode(' ', $content);

  if (preg_match('/<(.*?)>/s', $content)) {
    $abuse = true;
    $ab_array[$key] = $content;
  }
  if (preg_match('/cd (.*?)>/s',$content)) {
    $abuse = true;
    $ab_array[$key] = $content;   
  }
  if (preg_match('/chmod (.*?)/s',$content)) {
    $abuse = true;
    $ab_array[$key] = $content;   
  } 
  if (preg_match('/ls (.*?)/s',$content)) {
    $abuse = true;
    $ab_array[$key] = $content;   
  } 
  if (preg_match('/uname (.*?)/s',$content)) {
    $abuse = true;
    $ab_array[$key] = $content;   
  } 
}
if ($abuse){
  $ab_time  = date("Y_m_d-H_i_s");
  $content = _REMOTE_ADDR.' tried to abuse the system:'."\n";
  foreach ($ab_array as $key => $var_content) {
    $content .= 'With trying to set the get var: '.$key.' to '.$var_content."\n";
  }
  $content .= "Query String: "._QUERY_STRING." Location: "._PHP_SELF;
  $filename = RCX_ROOT_PATH."/cache/abuse-".$ab_time.".log";
  if ( $file = fopen($filename, "w") ) {
    fwrite($file, $content);
    fclose($file);
  } 
  header('Status: 302 Found');
  header("Location: ".RCX_URL."/abuse.php");
}
// abuse hack 
// Some backwards compatibility settings
$rcxConfig['rcx_url'] = RCX_URL;
$rcxConfig['root_path'] = RCX_ROOT_PATH.'/';
define('RCX_SIDEBLOCK_LEFT' , 0);
define('RCX_SIDEBLOCK_RIGHT', 1);
define('RCX_SIDEBLOCK_BOTH' , 2);
define('RCX_CENTERBLOCK_TOPLEFT'     , 3);
define('RCX_CENTERBLOCK_TOPRIGHT'    , 4);
define('RCX_CENTERBLOCK_TOPCENTER'   , 5);
define('RCX_CENTERBLOCK_TOPALL'      , 6);
define('RCX_CENTERBLOCK_BOTTOMLEFT'  , 7);
define('RCX_CENTERBLOCK_BOTTOMRIGHT' , 8);
define('RCX_CENTERBLOCK_BOTTOMCENTER', 9);
define('RCX_CENTERBLOCK_BOTTOMALL'   , 10);
define('RCX_BLOCK_INVISIBLE', 0);
define('RCX_BLOCK_VISIBLE'  , 1);
define('RCX_MATCH_START'  , 0);
define('RCX_MATCH_END'    , 1);
define('RCX_MATCH_EQUAL'  , 2);
define('RCX_MATCH_CONTAIN', 3);
define('RCX_ADMIN_URL', RCX_URL.'/admin.php');
// Check if https is on
//$tmp_https = $_SERVER['HTTPS'] ? $_SERVER['HTTPS'] : $_ENV['HTTPS'];
//(strtoupper($tmp_https) == 'ON') ? define('_HTTPS', TRUE) : define('_HTTPS', FALSE);
define('_HTTPS', getenv('HTTPS'));
// Detect platform
switch(strtoupper(PHP_OS)) {
  case 'WINDOWS':
  case 'CYGWIN':
  case 'WINNT':
  case 'WIN32':
    define('_OS', 'W');
    break;
  case 'DARWIN':
  case 'OSX':
    define('_OS', 'M');
    break;
  default:
    define('_OS', 'U');
}
// ################# :: Register Globals Compatibility :: #################
$globals_test = @ini_get('register_globals');
if (isset($globals_test) && empty($globals_test))
{
  // These still need some work :: Cookie|Server|Env are ok now.
  if ( !empty($_GET) )  { extract($_GET, EXTR_SKIP);  }
  if ( !empty($_POST) ) { extract($_POST, EXTR_SKIP); }
  define('_GLOBALS', FALSE);
}
else
{
  define('_GLOBALS', TRUE);
}
// #################### Error reporting settings ##################
include_once(RCX_ROOT_PATH.'/class/debug/debug.php');
// ############## Include common functions file ##############
include_once(RCX_ROOT_PATH.'/include/functions.php');
// ############## Ban unwanted IP address ##############
if (hasMatch($rcxBadIps, _REMOTE_ADDR) || hasMatch($rcxBadAgents, _HTTP_USER_AGENT))
{
  header('Status: 404 Not Found');
  exit();
}
// ################# Include version info file ##########################
include_once(RCX_ROOT_PATH.'/modules/system/cache/meta.php');
// #################### Include rcx check ##################
include_once(RCX_ROOT_PATH.'/include/rcxcheck.php');
// #################### Connect to DB ##################
if ($rcxConfig['prefix'] && $rcxConfig['dbhost'] && $rcxConfig['dbname'] && $rcxConfig['database']) {
  include_once(RCX_ROOT_PATH.'/class/database/'.$rcxConfig['database'].'.php');
  $db = new Database();
  $db->setPrefix($rcxConfig['prefix']);
  $result1 = @$db->connect($rcxConfig['dbhost'], $rcxConfig['dbuname'], $rcxConfig['dbpass'], $rcxConfig['db_pconnect']);
  if (!$result1) {
    echo $db->error();
    exit();
  }
  $result2 = @$db->select_db($rcxConfig['dbname']);
  if (!$result2) {
    echo $db->error();
    exit();
  }
  $db->setDebug($rcxConfig['debug_mode']);
}else die('Impossible connect to db');
// ######### define core db tables ###########################
// use table name $db class for modules but not for RC core
define('RC_PREFIX',$rcxConfig['prefix'].'_');
define('RC_USERS_TBL', RC_PREFIX.'users');
define('RC_RANKS_TBL',RC_PREFIX.'ranks');
define('RC_SESS_TBL',RC_PREFIX.'session');
define('RC_GROUP_TBL',RC_PREFIX.'groups');
define('RC_SMILES_TBL',RC_PREFIX.'smiles');
define('RC_MODULES_TBL',RC_PREFIX.'modules');
define('RC_NEWBLOCKS_TBL',RC_PREFIX.'newblocks');
define('RC_GRP_MOD_LINK_TBL',RC_PREFIX.'groups_modules_link');
define('RC_GRP_USERS_LINK_TBL',RC_PREFIX.'groups_users_link');
define('RC_GRP_BLOCK_LINK_TBL',RC_PREFIX.'groups_blocks_link');
// #################### Include text sanitizer ##################
include_once(RCX_ROOT_PATH.'/class/module.textsanitizer.php');
$myts = new MyTextSanitizer();
$myts->setAllowImage($rcxConfig['allow_image']);
$myts->setAllowLibrary($rcxConfig['allow_library']);
// ############## Login a user if there is a valid session ###########
if (intval($rcxConfig['use_sessions']) == 1)
{
  if ($rcxConfig['session_name'] =='')
  {
    $rcxConfig['session_name'] = 'rcsess';
  }
  if (isset($_COOKIE[$rcxConfig['session_name']]))
  {  
    session_id($_COOKIE[$rcxConfig['session_name']]);
  }
  else
  {
    $_SESSION = array();
  }
  if (function_exists('session_cache_expire'))
  {
    $session_cache_expire = intval($rcxConfig['session_expire']);
    @session_cache_expire($session_cache_expire / 60);
  }
  
  // Start auto-login hack for PHP sessions /by LARK 22.06.2010/
  
  // $session_path = $_SERVER['DOCUMENT_ROOT'] . '/../rc_sessions';
  // if (!is_dir($session_path)) mkdir($session_path, 0777); // !!! Only if safe-mode is disabled and the function mkdir() allowed !!! 
  // session_save_path($session_path);
  // @ini_set('session.gc_maxlifetime', (int)$rcxConfig['session_expire']);
  // session_set_cookie_params((int)$rcxConfig['session_expire']);
  
  // End auto-login hack for PHP sessions /by LARK 22.06.2010/
  
  session_name($rcxConfig['session_name']);
  session_start();
  // fix troubles with IE 6 - lost session after clicking on a link
  // uncomment or insert in meta
  //  header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
  $session_var = $_SESSION[$rcxConfig['session_name']];
}
elseif (isset($_COOKIE[$rcxConfig['session_name']]))
{
  $session_var = $_COOKIE[$rcxConfig['session_name']];
}
else
{
  $session_var = '';
}
$clearsess = false;
if (!empty($session_var))
{
  include(RCX_ROOT_PATH.'/class/sessions.class.php');
  $session = new RcxUserSession($session_var);
  if ($session->isValid())
  {
    $rcxUser = new RcxUser($session->uid());
    // define user language
    define('RC_ULANG',$rcxUser->getVar('language'));  // use RC_ULANG later
    // ########## Get modules info if module active ##################
    $url_arr = explode('/', strstr(_PHP_SELF, '/modules/')); // Fix by HDMan /http://MoscowVolvoClub.ru/)
    $module_dir = $url_arr[2];
    $rcxModule =& RcxModule::getByDirname($module_dir);
    // update user session with module ID
    $session->update();
    unset($session);
  }
  else
  {
    $clearsess = true;
  }
}
else
{
  $clearsess = true;
}
if ($clearsess)
{
  define('RC_ULANG', $rcxConfig['language']);
  unset($rcxUser);
  unset($_COOKIE[$rcxConfig['session_name']]);
  @session_destroy();
  // ########## Get modules info if module active ##################
  $url_arr = explode('/', strstr(_PHP_SELF, '/modules/')); // Fix by HDMan /http://MoscowVolvoClub.ru/)
  $module_dir = $url_arr[2];
  $rcxModule =& RcxModule::getByDirname($module_dir);
}
// #################### Include site-wide lang file ##################
if (@file_exists(RCX_ROOT_PATH.'/language/'.RC_ULANG.'/global.php'))
{
  include_once(RCX_ROOT_PATH.'/language/'.RC_ULANG.'/global.php');
}
else
{
  include_once(RCX_ROOT_PATH.'/language/english/global.php');
}

// #################### Set error handler ############################
set_error_handler('ex_error_handler');
// ################ Include page-specific lang file ##################
if (isset($rcxOption['pagetype']))
{
  if (@file_exists(RCX_ROOT_PATH.'/language/'.RC_ULANG.'/'.$rcxOption['pagetype'].'.php'))
  {
    include_once(RCX_ROOT_PATH.'/language/'.RC_ULANG.'/'.$rcxOption['pagetype'].'.php');
  }
  else
  {
    include_once(RCX_ROOT_PATH.'/language/english/'.$rcxOption['pagetype'].'.php');
  }
}
if (!defined('_USE_MULTIBYTES'))
{
  define('_USE_MULTIBYTES', 0);
}
// ############## Setup module specific stuff if in a module dir #####
if (@file_exists('include/rcxv.php'))
{
  if (!$rcxModule || !$rcxModule->isActivated())
  {
    include_once(RCX_ROOT_PATH.'/header.php');
    echo '<h4>'._MODULENOEXIST.'</h4>';
    include_once(RCX_ROOT_PATH.'/footer.php');
    exit();
  }
  if ($rcxUser)
  {
    if (!RcxGroup::checkRight('module', $rcxModule->mid(), $rcxUser->groups()))
    {
      header("Location:".RCX_URL."/whyregister.php");
      exit();
    }
  }
  elseif (!RcxGroup::checkRight('module', $rcxModule->mid(), 0))
  {
    header("Location:".RCX_URL."/whyregister.php");
    exit();
  }
  if (empty($rcxOption['page_style']) && ($module_dir == $rcxConfig['startpage']) && (basename(_PHP_SELF) == 'index.php'))
  {
    $rcxOption['page_style'] = 1; // start
  }
  elseif (empty($rcxOption['page_style']) && (basename(_PHP_SELF) == 'index.php'))
  {
    $rcxOption['page_style'] = 2; // index
  }
  elseif (empty($rcxOption['page_style']))
  {
    $rcxOption['page_style'] = 4; // other
  }
  if (@file_exists(RCX_ROOT_PATH.'/modules/'.$module_dir.'/language/'.RC_ULANG.'/main.php'))
  {
    include_once(RCX_ROOT_PATH.'/modules/'.$module_dir.'/language/'.RC_ULANG.'/main.php');
  }
  elseif (@file_exists(RCX_ROOT_PATH.'/modules/'.$module_dir.'/language/english/main.php'))
  {
    include_once(RCX_ROOT_PATH.'/modules/'.$module_dir.'/language/english/main.php');
  }
}
clearstatcache();
if (empty($rcxOption['page_style']) && (basename(_PHP_SELF) == 'index.php'))
{
  $rcxOption['page_style'] = 2; // index
}
elseif (empty($rcxOption['page_style']))
{
  $rcxOption['page_style'] = 4; // other
}
/**
 * NEW THEME SHORTCUT FUNCTIONS 15-07-2005
 */
define('THEME'      , getTheme());
define('THEME_PATH' , RCX_ROOT_PATH.'/themes/'.THEME);
define('THEME_URL'  , RCX_URL.'/themes/'.THEME);
define('TIMAGE_PATH', THEME_PATH.'/images');
define('TIMAGE_URL' , THEME_URL.'/images');
} // END RCX_MAINFILE_INCLUDED
?>