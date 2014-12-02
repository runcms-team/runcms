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

if ( !defined('RCX_HEADER_INCLUDED') ) {
  define('RCX_HEADER_INCLUDED', 1);

site_cache('read');
rcx_header(false);

$currenttheme = getTheme();
include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/theme.php');

  if (@file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.RC_ULANG.'.php'))
    include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.RC_ULANG.'.php');
  elseif (@file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php'))
    include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php');

$rcxOption['show_rblock'] = (!empty($rcxOption['show_rblock'])) ? $rcxOption['show_rblock'] : 0;
themeheader($rcxOption['show_rblock']);
make_cblock(RCX_CENTERBLOCK_TOPALL);
?>

<!-- START MODULE SPAN CSS -->
<div id="<?php global $rcxModule; if ($rcxModule) { echo $rcxModule->dirname();}?>_dom" class="<?php if ($rcxModule) { echo $rcxModule->dirname();}?>_css">
<!-- START MODULE SPAN CSS -->

<?php
}
?>
