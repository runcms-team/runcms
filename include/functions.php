<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("ERCX_FUNCTIONS_INCLUDED")) {
  define("ERCX_FUNCTIONS_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
function rcx_header($closehead=true) {
global $db, $meta, $rcxUser, $rcxConfig;

$http_cached = 0;

if ( !headers_sent() ) {
    
    header('Content-Type: text/html; charset='._CHARSET);
    header('Content-language: ' . _LANGCODE );
    
    if ( !empty($meta['p3p']) ) {
        header("P3P: CP='".$meta['p3p']."'");
    }
    
    if (!empty($rcxConfig['x_frame_options'])) {
        header("X-Frame-Options: SAMEORIGIN");
    }

    if (!empty($rcxConfig['x_xss_protection'])) {
        header("X-XSS-Protection: 1; mode=block");
    }

    if (!empty($rcxConfig['x_content_typ_options_nosniff'])) {
        header("X-Content-Type-Options: nosniff");
    }    
    
    if ($rcxConfig['use_http_caching'] == 1 && !empty($rcxConfig['http_cache_time']) && !empty($rcxConfig['http_caching_user_agent']) && isset($_SERVER["HTTP_USER_AGENT"]) && preg_match("/" . $rcxConfig['http_caching_user_agent'] . "/i", $_SERVER["HTTP_USER_AGENT"])){
        
        $ctime = $rcxConfig['http_cache_time'] * 60;
        
        if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])) {
            
            list($since) = explode(';', $_SERVER['HTTP_IF_MODIFIED_SINCE'], 2); // IE fix
            $since = substr($since, 5); // To avoid potential ambiguity
            
            if (strtotime($since) >=  (time() - $ctime)){
                ob_end_clean();
                header("HTTP/1.1 304 Not Modified");
                header("Content-Encoding: identity");
                exit();
            } else {
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Expires: ".gmdate("D, d M Y H:i:s", time() + $ctime)." GMT");
                $http_cached = 1;
            }
        } else {
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Expires: ".gmdate("D, d M Y H:i:s", time() + $ctime)." GMT");
            $http_cached = 1;
        }

    } elseif ( $rcxUser || ($meta['pragma'] == 1) ) {
        header('Expires: Sat, 18 Aug 2002 05:30:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0');
    }
}


// We only generate keywords if in debug mode, or if it's really a search engine.
if ($meta['extractor']) {
  if (!$meta['cloaking']) {
    include_once(RCX_ROOT_PATH . "/modules/system/admin/meta-generator/include/functions.php");
    } elseif ( $meta['cloaking'] && !preg_match("/(".$meta['user_agents'].")/i", _HTTP_USER_AGENT) ) {
      include_once(RCX_ROOT_PATH . "/modules/system/admin/meta-generator/include/functions.php");
    }
}

?>
<?php echo "<?xml version=\"1.0\" encoding=\""._CHARSET."\"?>\n";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo _LANGCODE;?>" lang="<?php echo _LANGCODE;?>">
<head>
<title><?php echo $meta['title'];?></title>
<?php if ($rcxConfig['no_redirect'] == 1 && defined("RCX_INDEX")): ?>
<base href="<?php echo RCX_URL;?>/modules/<?php echo $rcxConfig['startpage'];?>/" />
<?php endif;?> 
<meta http-equiv="content-type" content="text/html; charset=<?php echo _CHARSET;?>" />
<meta http-equiv="content-language" content="<?php echo _LANGCODE;?>" />
<?php if ($meta['pragma'] == 1 && empty($http_cached)) { ?>
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />
<?php } ?>
<meta name="rating" content="<?php echo $meta['rating'];?>" />
<meta name="robots" content="<?php echo $meta['index'];?>, <?php echo $meta['follow'];?>" />
<?php if (empty($meta['nogenerator'])) { ?>
<meta name="generator" content="<?php echo RCX_VERSION;?>" />
<?php } ?>
<meta name="keywords" content="<?php echo $meta['keywords'];?>" />
<meta name="description" content="<?php echo $meta['description'];?>" />
<?php if (!empty($meta['author'])) { ?>
<meta name="author" content="<?php echo $meta['author'];?>" />
<?php } ?>
<?php if (!empty($meta['copyright'])) { ?>
<meta name="copyright" content="<?php echo $meta['copyright'];?>" />
<?php } ?>
<?php readfile(RCX_ROOT_PATH . "/modules/system/cache/header.php");?>

<link rel="shortcut icon" href="<?php echo $meta['icon'];?>" />
<?php include_once(RCX_ROOT_PATH ."/include/rcxjs.php");?>
<link href="<?php echo RCX_URL;?>/include/style.css" rel="stylesheet" type="text/css" />
<?php


$themecss = getcss(getTheme());
if ($themecss) {
  echo "
  <style type='text/css' media='all'>
  <!-- @import url($themecss); -->
  </style>";
}


if(isset($rcxConfig['maintenance']) && $rcxConfig['maintenance']==1)
{
  if(!$rcxUser || !$rcxUser->isAdmin())
  {
    $currenttheme = getTheme();
    include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/theme.php');
    global $myts, $meta, $rcxUser, $rcxConfig;
    include_once(RCX_ROOT_PATH.'/modules/system/cache/maintenance.php');
    $myts->setType('admin');
    $texte = stripCSlashes($texte);   
    $texte = $myts->makeTareaData4Show($texte,1,1,1,$myts->allowLibrary = "true",$myts->allowImage = "true");
        
    if ( @file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.RC_ULANG.'.php') ) {
      include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.RC_ULANG.'.php');
    } elseif ( @file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php') ) {
      include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php');
    }

    echo "</head><body><br /><br /><br />";
    echo "<div align=center>";
    OpenTable("70%");
    echo "<div align=center><img src='".RCX_URL."/images/logo.gif'></div>";


OpenTable("100%");
  
    //added EsseBe
    $title = _CLOSED__FOR_MAINTENANCE;
    if ($in_block == 0 || $texte == "")
    {
      echo "<center><font size='+1'><b> $title</b></font><br> <hr width=90%>";
    
      if (!$texte =="")
      {
        echo "<table width='90%' ><tr><td ><center>$texte</center></td></tr></table>";
        echo "<hr width=90%>";
      }
      echo "</center><br>";
    }else{
      themecenterbox_center($title, $texte);
    }
    echo "<form action='".RCX_URL."/user.php' method='post'>";
    echo "<input type='hidden' name='op' value='login' />";
    echo '<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="50%">';
    echo '<tr><td class="bg2">';
    echo '<table border="0" cellpadding="4" cellspacing="1" width="100%">';
    echo '<tr class="bg4" align="center"><td colspan=2><b>'._ADMIN_LOGIN.'</b></td></tr>';
    echo '<tr align="center"><td class="bg3"><b>'._ADMIN_LOGIN_USER.'</b></td><td class="bg1" align=left><input type="text" class="text" name="uname" size="12" maxlength="25"></td></tr>';
    echo '<tr align="center"><td class="bg3"><b>'._ADMIN_LOGIN_PASS.'</b></td><td class="bg1" align=left><input type="password" class="text" name="pass" size="12" maxlength="20" ></td></tr>';
    echo '<tr class="bg4" align="center"><td colspan=2><input type="submit" class="button" value="'._SUBMIT.'"></td></tr>';
    echo "</table>";
    echo "</table>";
    echo "</form><br /><br />";
    CloseTable();
    echo "</div><br /><br /><br />";
    rcx_footer(0);
    die();
  }
}

if ( $closehead ) {
  echo "</head><body>";
}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function rcx_footer($debug=1) {
global $rcxConfig;

if ($rcxConfig['display_loading_img'] == 1) {
  CloseWaitBox();
}

site_cache("cache");

if ( !empty($rcxConfig['debug_mode']) && !empty($debug) ) {
  debug_info($rcxConfig['debug_mode']);
}

echo "</body></html>";
ob_end_flush();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function site_cache($option) {
global $rcxOption, $rcxConfig, $rcxUser, $meta;

$cache_time      = $rcxConfig['cache_time'];
$browser_pattern = 'mozilla\/[0-9]|netscape|opera|konqueror|msie [0-9]|iweng|ncsa mosaic|lynx';
$r_uri           = _REQUEST_URI;
$u_agent         = _HTTP_USER_AGENT;
$r_method        = _REQUEST_METHOD;
$no_cache        = isset($rcxOption['nocache']) ? intval($rcxOption['nocache']) : 1;

if (
    $no_cache
    && !empty($cache_time)
    && empty($rcxUser)
    && $r_method == 'GET'
    && !empty($r_uri)
    && preg_match("/($browser_pattern)/i", $u_agent)
   ) {

$curr_time   = time();
$path        = RCX_ROOT_PATH.'/cache/system/';

$tmp_name    = preg_replace('/[^a-z0-9_-]/i', '', $r_uri);
$cache_file  = $path.'.'.$tmp_name.'.cache';

$last_cached = @filemtime($cache_file);
$last_cached ? $last_cached = $last_cached : $last_cached = 0;

$cached_size = @filesize($cache_file);
$cached_size ? $cached_size = $cached_size : $cached_size = 0;

if ( ($option == 'cache') && (($last_cached+$cache_time) < $curr_time) ) {
  $content = ob_get_contents();

  // Cleanup stale files that might have been generated by search engines, etc.
  if ( $handle = @opendir($path) ) {
    while (false !== ($file = @readdir($handle))) {
      if ( @is_file($path.$file) ) {
      $timestamp = @filemtime($path.$file);
        if ( (($timestamp+$cache_time) < $curr_time) ) {
          @unlink($path.$file);
        }
      }
    }
    closedir($handle);
  } // END Cleanup

  if ($fp = fopen($cache_file, 'w')) {
    fwrite($fp, $content.'</body></html>');
    fclose($fp);
    }
    } elseif ( ($option == 'read') && (($last_cached+$cache_time) > $curr_time) && ($cached_size > 5120) ) {
      if ( !headers_sent() ) {
        header('Last-Modified: '.gmdate("D, d M Y H:i:s", $last_cached).' GMT');
        header("Cache-Control: max-age=$cache_time, s-maxage=$cache_time, proxy-revalidate, post-check=$cache_time, pre-check=$cache_time");
        if ( !empty($meta['p3p']) ) {
          header("P3P: CP='".$meta['p3p']."'");
        }
      }
      readfile($cache_file);
      if ( !empty($rcxConfig['debug_mode']) ) {
        debug_info($rcxConfig['debug_mode']);
      }
      if (!headers_sent()) {
        header('ETag: '.md5(ob_get_length()));
      }
      ob_end_flush();
      exit();
    }
  } elseif (!headers_sent()) {
    header('ETag: '.md5(uniqid(ex_srand())));
    header('Expires: Sat, 18 Aug 2002 05:30:00 GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0');
  } // END CACHE
}

/**
* Function to display formatted times in user timezone
*/
function formatTimestamp($time, $format="l", $timeoffset="") {
global $rcxConfig, $rcxUser;

if ($timeoffset == "") {
  if ($rcxUser) {
    $timeoffset = $rcxUser->getVar("timezone_offset");
    } else {
      $timeoffset = $rcxConfig['default_TZ'];
    }
  }

if ( $format == "s" ) {
  $datestring = _SHORTDATESTRING;
  } elseif ( $format == "m" ) {
    $datestring = _MEDIUMDATESTRING;
    } elseif ( $format == "l" ) {
      $datestring = _DATESTRING;
      } elseif ( $format == "mysql" ) {
        $datestring = "Y-m-d H:i:s";
        } elseif ( $format != "" ) {
          $datestring = $format;
          } else {
            $datestring = _DATESTRING;
          }

$usertimestamp = ($time + (($timeoffset - ($rcxConfig['server_TZ'] - date('I'))) * 3600));
$datetime = date($datestring, $usertimestamp);
$datetime = ucfirst($datetime);

return $datetime;
}

/**
* Function to calculate server timestamp from user entered time (timestamp)
*/
function userTimeToServerTime($timestamp, $userTZ=NULL) {
global $rcxConfig;

if ( !isset($userTZ) ) {
  $userTZ = $rcxConfig['default_TZ'];
}

$offset    = $userTZ - $rcxConfig['server_TZ'];
$timestamp = $timestamp - ($offset * 3600);

return $timestamp;
}

/**
* Functions to display dhtml loading image box
*/
function OpenWaitBox() {
global $rcxConfig;

if ($rcxConfig['display_loading_img'] == 1) {
?>
  <div id="waitDiv" style="position:absolute; left:40%; top:50%; visibility:hidden; text-align:center;">
  <?php theme_waitbox();?>
  </div>
  <script type='text/javascript'>
  <!--
  toggle_visibility('waitDiv', 1);
  //-->
  </script>
<?php
}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function CloseWaitBox()  {
?>
  <script type='text/javascript'>
  <!--
  toggle_visibility('waitDiv', 0);
  //-->
  </script>
<?php
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function ex_srand() {
  $seed = hexdec(substr(md5(microtime()), -8)) & 0x7fffffff;
  mt_srand($seed);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function makepass() {

$consonents = "bcdfghjklmnpqrstvwxyz";
$voyelles   = "aeiou";

ex_srand();
$makepass='';
for ($i=0; $i<4; $i++) {
  $makepass .= substr($consonents, mt_rand(0, strlen($consonents)-1), 1);
  $makepass .= substr($voyelles  , mt_rand(0, strlen($voyelles)-1)  , 1);
}

return ($makepass);
}


/**
* Description
*
* @param array  $input An array of regular expressions
* @param string $match The string we are matching
* @return bool True/False based on matches
*/
function hasMatch($input=array(), $match='') {

if (!empty($input) && !empty($match)) {
  $matches='';
  foreach ($input as $entry)
  {
    $entry = trim($entry);
    if (!empty($entry) && preg_match($entry, trim($match), $matches))
      return $matches;
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
function checkIp($ip=0) {
global $rcxBadIps;
return hasMatch($rcxBadIps, $ip);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function checkEmail($email) {

if ( empty($email) || !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $email) ) {
  return false;
  }

return true;
}

/**
* NOT DONE DONT USE
* Returns the GMT timestamp for now or a given offset
*
* @param type $var description
* @return type description
*/
function gmtime($time=0, $offset=0) {

if ( empty($offset) ) {
  return gmmktime();
  } else {
    return gmmktime(0, 0, 0, 0, 0, 0, intval($offset));
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function formatURL($url='', $file='') {

if ( ($url != '') && !preg_match("'^((http|https|ftp|ftps|ed2k|ajsfp)://{1})$'i", $url) ) {
  if ($file != '') {
    if ( preg_match("'^((http|https|ftp|ftps|ed2k|ajsfp)://{1}.{3,})'i", $file) ) {
      return $file;
      } elseif (substr($url, -1) != '/') {
        $file = '/'.$file;
      }
  }
  if ( preg_match("'^((http|https|ftp|ftps|ed2k|ajsfp)://{1}.{3,})'i", $url) ) {
    return $url.$file;
    } else {
      return "http://".$url.$file;
    }
}
return NULL;
}

/**
* Prints allowed html tags on this site
*/
function get_allowed_html() {
global $rcxUser, $rcxModule, $rcxConfig;

if ($rcxUser) {
  $mid = $rcxModule ? $rcxModule->mid() : 0;
  if ($rcxUser->isAdmin($mid)) {
    $html = $rcxConfig['admin_html'];
    } else {
      $html = $rcxConfig['user_html'];
    }
  $allowed = str_replace("|", "> <", "<".$html.">");
  $allowed = htmlspecialchars($allowed, RCX_ENT_FLAGS, RCX_ENT_ENCODING);
}

return $allowed;
}

/**
* DEPRACTED ..use getMailer()
*/
function rcx_mail($to, $subject, $message, $headers='') {
global $rcxConfig, $meta;

$mail =& getMailer();
$mail->useMail();

$mail->setFromName($meta['title']);
$mail->setFromEmail($rcxConfig['adminmail']);
$mail->setToEmails($to);
$mail->setSubject($subject);
$mail->setBody($message);

$mail->send();

echo $mail->getSuccess();
echo $mail->getErrors();
}

/**
* Function to display banners in all pages
*/
function showbanner($display="N")
{
global $rcxConfig;
  if (intval($rcxConfig['banners']) == 1)
  {
    if (file_exists(RCX_ROOT_PATH .'/modules/banners/include/functions.php'))
    {
      include_once(RCX_ROOT_PATH .'/modules/banners/include/functions.php');
      if (function_exists('show_banner'))
      {
        show_banner($display);
      }
    }
  }
}

/**
* Function to redirect a user to certain pages
*/
function redirect_header($url, $time=4, $message=_TAKINGBACK) {
global $rcxConfig, $meta;

if ( !headers_sent() ) {
    
    header('Content-Type: text/html; charset='._CHARSET);
    header('Content-language: ' . _LANGCODE );
}

?>
<html><head>
<title><?php echo $meta['title'];?></title>
<meta http-equiv="Expires" content="Thu, Jan 1 1970 00:00:00 GMT"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CHARSET;?>" /> 
<meta http-equiv="Refresh" content="<?php echo $time;?>; url=<?php echo $url;?>" /> 
<style type="text/css">
  .redirect {
    width: 70%;
    text-align: center;
    padding: 25px;
    border: 1px dotted;
  }
</style>
<?php
$themecss = getcss(getTheme());
if ($themecss) {
  echo "<link href='$themecss' rel='stylesheet' type='text/css' />";
  } 
  ?>
  </head><body> 
  <center>
  <br /><br /><br /><br /><br /><br /> 
  <table width="70%" border="0" align="center" cellspacing="5" cellpadding="5">
  <tr>
    <td align="center" class="redirect">
      <h4><?php echo $message;?></h4>
      <hr size="1" noshade="noshade" />
      <b>
        <?php
          printf(_IFNOTRELOAD, $url);
        ?>
      </b>
    </td>
  </tr>
</table>
</center>
</body></html>
<?php
}

/**
* Function to get a user selected theme file
*/
function getTheme() {
global $rcxConfig, $rcxUser;

  if (!$rcxUser)
  {
    return $rcxConfig['default_theme'];
  }

  $themedir = RCX_ROOT_PATH . "/themes";
  $theme    = $rcxUser->getVar("theme");
  
  if (@file_exists("$themedir/$theme/theme.php"))
  {
    return $theme;
  }
  else
  {
    return $rcxConfig['default_theme'];
  }
}

/**
* Function to get css file for a certain theme
*/
function getcss($theme) {
global $rcxModule;

$theme_dir = RCX_ROOT_PATH.'/themes/'.$theme.'/style';
$theme_url = RCX_URL.'/themes/'.$theme.'/style';
$mod_dir   = $rcxModule ? $rcxModule->dirname() : FALSE;

if ( preg_match('/(MSIE)|(Opera)/i', _HTTP_USER_AGENT) ) {

  if ( $mod_dir && @file_exists($theme_dir.'/'.$mod_dir.'_style.css') ) {
    return ($theme_url.'/'.$mod_dir.'_style.css');

    } elseif ( @file_exists($theme_dir.'/style.css') ) {
      return ($theme_url.'/style.css');
    }

  } else {

  if ( $mod_dir && @file_exists($theme_dir.'/'.$mod_dir.'_styleNN.css') ) {
    return ($theme_url.'/'.$mod_dir.'_styleNN.css');

    } elseif ( @file_exists($theme_dir.'/styleNN.css') ) {
      return ($theme_url.'/styleNN.css');

      } elseif ( $mod_dir && @file_exists($theme_dir.'/'.$mod_dir.'_style.css') ) {
        return ($theme_url.'/'.$mod_dir.'_style.css');

        } elseif ( @file_exists($theme_dir.'/style.css') ) {
          return ($theme_url.'/style.css');
    }

  }
}

/**
* Returns resized dimension values for a given image
* Copy this function if ya like, but dont use it ..will prolly be moved.
*
* Example:
* if ( $size = resizedImage("/images/image.gif", 50, "h") ) {
*   $size = " height='$size[h]' width='$size[w]'";
*   }
* echo "<img src='".RCX_URL."/images/image.gif' border='0'$size>";
*
* @param string $image File or URL path to image in question
* @param integer $maxsize Maximum size of image
* @param string $orientation What $maxsize applies to: height or width
* @return array An array containing the height/width values
*/
function resizedImage($image, $maxsize=150, $orientation="w" ) {

if ( $maxsize == 0 || !is_numeric($maxsize) ) {
  $maxsize = 150;
  }

if ( $orientation != "w" && $orientation != "h" ) {
  $orientation = "w";
  }

$size = @getimagesize($image);

if ( is_numeric($size[0]) && is_numeric($size[1]) ) {
  $img['w'] = $size[0];
  $img['h'] = $size[1];

  switch($orientation) {
  case "w":
    if ( $img['w'] > $maxsize ) {
      $img['h'] = round( ( $img['h'] / ($img['w'] / $maxsize) ) );
      $img['w'] = $maxsize;
    }
    break;

  case "h":
    if ( $img['h'] > $maxsize ) {
      $img['w'] = round( ( $img['w'] / ($img['h'] / $maxsize) ) );
      $img['h'] = $maxsize;
    }
    break;
  }
  return $img;
  } else {
    return(FALSE);
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function avatarExists($uid) {
global $rcxConfig;

// recommend not to change this
$allowed_ext = array("gif", "jpeg", "jpg", "png");

  foreach($allowed_ext as $ext)
  {
    if (@file_exists(RCX_ROOT_PATH."/images/avatar/users/".$uid.".".$ext ))
    {
      return "users/".$uid.".".$ext;
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
function &getMailer() {
global $rcxConfig;

if ( class_exists("rcxmailer") ) {
  return new RcxMailer();
  } else {
    include_once(RCX_ROOT_PATH."/class/rcxmailer.php");
    return new RcxMailer();
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function cookie($name, $value='', $time=0, $path='/') {

$expire = gmdate("D, d-M-Y H:i:s", time()+$time);
$time ? header("Set-Cookie: $name=$value; expires=$expire GMT; path=$path") : header("Set-Cookie: $name=$value; path=$path");
}


// #################### Block functions from here ##################

//----------------------------------------------------------------------------------------//
/**
* Purpose : Builds the blocks on both sides
* Input   : $side = On wich side should the block are displayed?
* 0, l, left : On the left side
* 1, r, right: On the right side
*  other:   Only on one side (
* Call from theme.php makes all blocks on the left side
* and from theme.php for the right site)
*/
function make_sidebar($side) {
global $rcxUser, $rcxModule, $rcxOption;

$rcxblock = new RcxBlock();
$arr        = array();
//$mid        = $rcxModule ? $rcxModule->mid() : 0;
$page_style = intval($rcxOption['page_style']);
$page_style = empty($page_style) ? 4 : $page_style;

$mid        = $rcxModule ? $rcxModule->mid() : 0;
/*
* Remaked by SVL for sidebar choose
* 0 - no bar, 1 - left bar only, 2 - right bar only, 3 - both
*/
$bar        = $rcxModule ? $rcxModule->sidebar() : 3;

  if ($bar == 0)
    return;
  elseif ($side == "left" && $bar != 2)
    $side = RCX_SIDEBLOCK_LEFT;
  elseif ($side == "right" && $bar != 1)
    $side = RCX_SIDEBLOCK_RIGHT;
  elseif ($bar == 3)
    $side = RCX_SIDEBLOCK_BOTH;
  else
    return;

/*
$page_style
1 = start
2 = index
4 = other
8 = special
*/
/* originaversion
/*if ($side == "left") {
  $side = RCX_SIDEBLOCK_LEFT;
  } elseif ( $side == "right" ) {
    $side = RCX_SIDEBLOCK_RIGHT;
    } else {
      $side = RCX_SIDEBLOCK_BOTH;
    }
*/

if ($rcxUser)
{
  $arr =& $rcxblock->getAllBlocksByGroup($rcxUser->groups(), true, $side, RCX_BLOCK_VISIBLE, "b.weight, b.bid", 1, $mid, $page_style);
}
else
{
  $arr =& $rcxblock->getAllBlocksByGroup(RcxGroup::getByType("Anonymous"), true, $side, RCX_BLOCK_VISIBLE, "b.weight, b.bid", 1, $mid, $page_style);
}
$myblock='';
foreach ($arr as $myblock)
{
  $block = array();
  $block =& $myblock->buildBlock();

  if ($block)
  {
    if ($side == RCX_SIDEBLOCK_LEFT)
    {
      $sideblock = RCX_SIDEBLOCK_LEFT;
    }
    else
    {
      $sideblock = RCX_SIDEBLOCK_RIGHT;
    }

    echo $myblock->showBlock($sideblock, $block['title'], $block['content']);
  }
  unset($myblock);
  unset($block);
} // END FOREACH
}

/**
* Function to display center block
*/
function make_cblock($side=RCX_CENTERBLOCK_TOPALL) {
global $rcxUser, $rcxModule, $rcxOption;

// Backwards compatibility with old modules
if (!defined('CENTERBLOCKS_'.$side.'_INCLUDED')) {
  define('CENTERBLOCKS_'.$side.'_INCLUDED', 1);
  } else {
    return;
  }

$rcxblock = new RcxBlock();
$cc_block   = $cl_block = $cr_block = "";
$arr        = array();
$side       = ($side == RCX_CENTERBLOCK_TOPALL) ? RCX_CENTERBLOCK_TOPALL : RCX_CENTERBLOCK_BOTTOMALL;
$mid        = $rcxModule ? $rcxModule->mid() : 0;
$page_style = intval($rcxOption['page_style']);
$page_style = empty($page_style) ? 4 : $page_style;   //

/*
$page_style
1 = start
2 = index
4 = other
8 = special
*/

if ($rcxUser) {
  $arr =& $rcxblock->getAllBlocksByGroup($rcxUser->groups(), true, $side, RCX_BLOCK_VISIBLE, "b.weight, b.bid", 1, $mid, $page_style);
  } else {
    $arr =& $rcxblock->getAllBlocksByGroup(RcxGroup::getByType("Anonymous"), true, $side, RCX_BLOCK_VISIBLE, "b.weight, b.bid", 1, $mid, $page_style);
  }

if (!empty($arr)) {

if ($side == RCX_CENTERBLOCK_BOTTOMALL) {
  echo '<br />';
}

OpenTable();
$nextblock=0;
foreach ($arr as $myblock) {
  $block = array();
  $block =& $myblock->buildBlock();

  $nextblock++;
  $prevblock = ($nextblock-2);

  if ($prevblock >= 0) {
    $prev = $arr[$prevblock]->getVar("side");
    } else {
      $prev = '';
    }

  if ( $nextblock < count($arr) ) {
    $curr = $myblock->getVar("side");
    $next = $arr[$nextblock]->getVar("side");
    } else {
      $curr = $myblock->getVar("side");
      $next = '';
    }

if ($block) {

if (($myblock->getVar("side") == RCX_CENTERBLOCK_TOPLEFT) || ($myblock->getVar("side") == RCX_CENTERBLOCK_BOTTOMLEFT)) {
  $sideblock = $myblock->getVar("side");
  if (($next == RCX_CENTERBLOCK_TOPRIGHT) || ($next == RCX_CENTERBLOCK_BOTTOMRIGHT)) {
    echo "
    <table align='center' width='100%' cellpadding='0' cellspacing='0' border='0'>
    <tr><td align='center' valign='top' width='50%'>";
    
    echo $myblock->showBlock($sideblock, $block['title'], $block['content']);
    echo "</td>";
    } else {
      echo "
      <table align='center' width='100%' cellpadding='0' cellspacing='0' border='0'>
      <tr><td align='center' valign='top' width='50%'>";
      
      echo $myblock->showBlock($sideblock, $block['title'], $block['content']);
      echo "</td><td width='50%'>&nbsp;</td></tr></table>";
    }

} elseif (($myblock->getVar("side") == RCX_CENTERBLOCK_TOPRIGHT) || ($myblock->getVar("side") == RCX_CENTERBLOCK_BOTTOMRIGHT)) {

  $sideblock = $myblock->getVar("side");
  if (($prev == RCX_CENTERBLOCK_TOPLEFT) || ($prev == RCX_CENTERBLOCK_BOTTOMLEFT)) {
    echo "<td align='center' valign='top' width='50%'>";
    
    echo $myblock->showBlock($sideblock, $block['title'], $block['content']);
    echo "</td></tr></table>";
    } else {
      echo "
      <table align='center' width='100%' cellpadding='0' cellspacing='0' border='0'>
      <tr><td width='50%'>&nbsp;</td><td align='center' valign='top' width='50%'>";
      
      echo $myblock->showBlock($sideblock, $block['title'], $block['content']);
      echo "</td></tr></table>";
    }

} elseif (($myblock->getVar("side") == RCX_CENTERBLOCK_TOPCENTER) || ($myblock->getVar("side") == RCX_CENTERBLOCK_BOTTOMCENTER)) {
    $sideblock = $myblock->getVar("side");
    echo $myblock->showBlock($sideblock, $block['title'], $block['content']);
}


} // END $block
unset($myblock);
unset($block);
} // END FOREACH

CloseTable();
} // END count($arr)
}

function WhyRegTop($ad_titel, $t=0, $csp=0, $cp=4){   
    if(file_exists(RCX_ROOT_PATH."/images/whyinfo.gif")){
      echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr>";
        echo "<td><br /><center><b><h3>".$ad_titel."</h3></b></center></td>";
      echo "<td width='30' border='0'><img src='".RCX_URL."/images/whyinfo.gif' alt='' width='30'></td>";
      echo "<td width='30'>&nbsp;</td>";
      echo "</tr></table>";
    }else{
      echo $ad_titel;
    }
  }
/**
* Depracted
*/
function openThread($width="100%") {
}
/**
* Depracted
*/
function closeThread() {
}

/**
* Depracted & moved to theme :: use theme_post()
* Shows thread content for forum/comments
*/
function showThread($color_number, $subject_image, $subject, $text, $post_date, $ip_image, $reply_image, $edit_image, $delete_image, $username="", $rank_title="", $rank_image="", $avatar_image="", $reg_date="", $posts="", $user_from="", $online_image="", $profile_image="", $pm_image="", $email_image="", $www_image="", $icq_image="", $aim_image="", $yim_image="", $msnm_image="") {

if ( function_exists('theme_post') ) {
  theme_post($subject, $text, $color_number, $subject_image, $post_date, $ip_image, $reply_image, $edit_image, $delete_image, $username, $rank_title, $rank_image, $avatar_image, $reg_date, $posts, $user_from, $online_image, $profile_image, $pm_image, $email_image, $www_image, $icq_image, $aim_image, $yim_image, $msnm_image);
  } else {
    if ($color_number == 1) {
      $bg1 = 'bg1';
      $bg2 = 'bg3';
      } else {
        $bg1 = 'bg3';
        $bg2 = 'bg1';
      }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function ex_error_handler($errno='', $errstr='', $errfile='', $errline='') {
global $rcxUser, $rcxConfig;

$errortype = array (
      1    => _ERR_ERROR,
      2    => _ERR_WARNING,
      4    => _ERR_PARSE,
      8    => _ERR_NOTICE,
      16   => _ERR_CORE_ERROR,
      32   => _ERR_CORE_WARNING,
      64   => _ERR_COMPILE_ERROR,
      128  => _ERR_COMPILE_WARNING,
      256  => _ERR_USER_ERROR,
      512  => _ERR_USER_WARNING,
      1024 => _ERR_USER_NOTICE
      );

if (($rcxConfig['debug_mode'] & 1) && (error_reporting() & $errno)) {
  $output = '
    <div class="errhandler">
    '._ERR_NUMBER.': '.$errno.' ['.$errortype[$errno].']<br />
    '._ERR_MESSAGE.': <b>'.$errstr.'</b><br />
    '._ERR_FILE.': <a href="'.RCX_URL.'/class/debug/highlight.php?file='.$errfile.'&line='.$errline.'#'.$errline.'" title="'._ERR_SHOW.'" target="errcode">'.$errfile.'</a><br />
    '._ERR_LINE.': '.$errline.'
    </div><br />';
    if (isset($rcxUser) && $rcxUser->isAdmin(1))
    {
      echo $output;
    }
    else
    {
      echo sprintf(" Error ");
    }
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function rc_shatool($vara='', $varb='', $varc='') {
  if (function_exists('sha1'))
  {
    $shatool = 'sha1';
  }
  else
  {
    require_once RCX_ROOT_PATH."/include/rcsha.php";
    $shatool = 'rcsha1';
  }

return $shatool($vara.$varb.$varc);
}

/**
 * Enter description here...
 *
 * @param unknown_type $reason
 * @param unknown_type $uname
 * @param unknown_type $uid
 * @param unknown_type $status
 * @param unknown_type $type
 * @return unknown
 */
function rcx_set_login_log($reason, $uname, $uid = 0, $status = 'fail', $type = 'admin')
{
    global $myts, $db;

    switch ($type) {
        case 'admin':
            $date = 'DATE_SUB(NOW(), INTERVAL 3 MONTH)';
            break;
        default:
            $date = 'DATE_SUB(NOW(), INTERVAL 3 DAY)';
            break;
    }

    $sql = "DELETE FROM " . $db->prefix('login_log') . " WHERE date < " . $date . ")";

    $result = $db->query($sql);

    $sql = "
    INSERT INTO " . $db->prefix('login_log') . " SET 
    uname='" . $myts->makeTboxData4Save($uname) . "',
    uid=" . (int)$uid . ",
    date='" . date('Y-m-d H:i:s') . "',
    ip='" . _REMOTE_ADDR . "',
    status='" . $status . "', 
    type='" . $type . "',
    reason='" . strip_tags($myts->makeTboxData4Save($reason)) . "'";

    if (!$result = $db->query($sql)) {
        return false;
    }

    return true;
}

/**
 * Enter description here...
 *
 * @param unknown_type $type
 * @return unknown
 */
function rcx_check_bruteforce_login()
{
    global $db, $rcxConfig;
    
    $failed_lock_time = !empty($rcxConfig['failed_lock_time']) ? $rcxConfig['failed_lock_time'] : 15;

    $sql = "SELECT COUNT(*)
    FROM " . $db->prefix('login_log') . " 
    WHERE date > DATE_SUB(NOW(), INTERVAL " . $failed_lock_time . " MINUTE) 
    AND ip = '" . _REMOTE_ADDR . "' 
    AND status = 'fail'";

    if (!$result = $db->query($sql)) {
        return 0;
    }

    list($count) = $db->fetch_row($result);

    return $count;

}

/**
 * Enter description here...
 *
 * @param unknown_type $type
 * @return unknown
 */
function rcx_404_error()
{
    global $meta, $rcxOption;

    ob_end_clean();

    header("Content-Encoding: identity");

    if (strncasecmp(PHP_SAPI, 'cgi', 3)) { 
        header("HTTP/1.1 404 Not Found");
    } else { 
        header("Status: 404 Not Found");
    }
    
    $meta['title'] = _404_PAGE_TITLE;

    include (RCX_ROOT_PATH . '/header.php');

    $rcxOption['show_rblock'] = 1;

    OpenTable();

    echo '<div class="error">';

    echo '<h4>' . _404_PAGE_H1 . '</h4>';

    echo '<p>' . _404_PAGE_DESCRIPTION . '</p>';

    echo '</div>';

    CloseTable();

    include (RCX_ROOT_PATH . '/footer.php');    
    
    exit();
}

}
?>