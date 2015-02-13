<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

error_reporting(2039);
ini_set('magic_quotes_runtime', 0);
init_wiz();

include_once("../include/functions.php");
include_once("../modules/system/cache/config.php");
include_once("../class/core.php");

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function init_wiz() {
global $_COOKIE, $_POST, $_GET, $_SERVER, $_ENV;

  define('RCX_ENT_ENCODING', 'ISO-8859-1'); // Encoding htmlspecialchars() and htmlentities() in PHP 5.4
  
  if (version_compare(PHP_VERSION, "5.4.0", ">=")) {
      define('RCX_ENT_FLAGS', ENT_COMPAT | ENT_HTML401); // Flags  htmlspecialchars() and htmlentities() in PHP 5.4
  } else {
      define('RCX_ENT_FLAGS', ENT_COMPAT);
  }

$globals_test = @ini_get('register_globals');
if ( isset($globals_test) && empty($globals_test) ) {
	if ( !empty($_GET) )  { extract($_GET, EXTR_SKIP);  }
	if ( !empty($_POST) ) { extract($_POST, EXTR_OVERWRITE); }
	define('_GLOBALS', FALSE);
	} else {
		define('_GLOBALS', TRUE);
	}

define('_PHP_SELF', $_SERVER['PHP_SELF']);

!empty($_SERVER['HTTP_HOST'])       ? define('_HTTP_HOST'      , $_SERVER['HTTP_HOST'])       : define('_HTTP_HOST'      , $_ENV['HTTP_HOST']);
!empty($_SERVER['QUERY_STRING'])    ? define('_QUERY_STRING'   , $_SERVER['QUERY_STRING'])    : define('_QUERY_STRING'   , $_ENV['QUERY_STRING']);
!empty($_SERVER['SCRIPT_NAME'])     ? define('_SCRIPT_NAME'    , $_SERVER['SCRIPT_NAME'])     : define('_SCRIPT_NAME'    , $_ENV['SCRIPT_NAME']);
!empty($_SERVER['HTTP_REFERER'])    ? define('_HTTP_REFERER'   , $_SERVER['HTTP_REFERER'])    : define('_HTTP_REFERER'   , $_ENV['HTTP_REFERER']);
!empty($_SERVER['REQUEST_METHOD'])  ? define('_REQUEST_METHOD' , $_SERVER['REQUEST_METHOD'])  : define('_REQUEST_METHOD' , $_ENV['REQUEST_METHOD']);
!empty($_SERVER['HTTP_USER_AGENT']) ? define('_HTTP_USER_AGENT', $_SERVER['HTTP_USER_AGENT']) : define('_HTTP_USER_AGENT', $_ENV['HTTP_USER_AGENT']);

$R_URI = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_ENV['REQUEST_URI'];
!empty($R_URI) ? define('_REQUEST_URI', $R_URI) : define('_REQUEST_URI', _PHP_SELF._QUERY_STRING);

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

$base_path = str_replace('\\', '/', getcwd());
if ( substr($base_path, -1) == '/') {
	$base_path = substr($base_path, 0, -1);
}
define('WIZ_PATH', $base_path);

if ( !defined('RCX_ROOT_PATH') &&  RCX_ROOT_PATH != '' ) {
	define('RCX_ROOT_PATH', preg_replace("/\/_install.*/i", "", WIZ_PATH));
}

$parts = pathinfo(_PHP_SELF);
define('BASE_URL', preg_replace("/\/_install.*/i", "", $parts["dirname"]));

if ( !defined('RCX_URL') && RCX_URL != '' ) {
	$root_url = "http://" . _HTTP_HOST. preg_replace("'/_install/install\.php$'i", "", _PHP_SELF);
	define("RCX_URL", $root_url);
}

$lang = !empty($_POST['lang']) ? $_POST['lang'] : $_COOKIE['lang'];

if ( @file_exists(WIZ_PATH."/language/".$lang."/main.php") ) {
	include_once(WIZ_PATH."/language/".$lang."/main.php");
	} else {
		include_once(WIZ_PATH."/language/russian/main.php");
	}

if ( @file_exists("../language/".$lang."/global.php") ) {
	include_once("../language/".$lang."/global.php");
	} else {
		include_once("../language/russian/global.php");
	}

if ( @file_exists("../language/".$lang."/admin.php") ) {
	include_once("../language/".$lang."/admin.php");
	} else {
		include_once("../language/russian/admin.php");
	}

if ( @file_exists("../language/".$lang."/user.php") ) {
	include_once("../language/".$lang."/user.php");
	} else {
		include_once("../language/russian/user.php");
	}
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function wiz_header($title=_INSTALL_G_TITLE) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CHARSET;?>" />
	<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#ffffff">
<table border="0" align="center" cellpadding="0" cellspacing="0" width="950">
  <tr>
   <td><img src="images/spacer.gif" width="950" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td><img name="images_r1_c1" src="images/images_r1_c1.jpg" width="950" height="336" border="0" id="images_r1_c1" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="336" border="0" alt="" /></td>
</tr>
  <tr>
   <td class="installtext"><br /><br />

<?php
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function wiz_footer() {
?>
 <br /></td>
  </tr>
  <tr>
   <td><img name="images_r3_c1" src="images/images_r3_c1.jpg" width="950" height="70" border="0" id="images_r3_c1" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="70" border="0" alt="" /></td>
  </tr>
</table>
<p align="center">
	<!--- you are not allowed to remove the copyright and link in this footer --->
<a href='http://www.runcms.ru' target='_blank'><font color="red"><?php echo RCX_VERSION;?> &copy; 2002-2015</font></a>
</p>
</body>
</html>
<?php
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function version_check($min, $curr) {

	list($min_major,$min_minor,$min_sub) = split(".", $min);
	list($cur_major,$cur_minor,$cur_sub) = split(".", $curr);
	if ( intval($cur_major) >= intval($min_major) ) { 
		if (intval($cur_minor) >= intval($min_minor) )  {
			if (intval($cur_sub) >= intval($min_minor) ) { return true; } 
		}
	}
	
	return false;



}
// insert random prefix 10-11-09
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
		
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		
		return $str;
	}
// insert randaom prefix end
?>
