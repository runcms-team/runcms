<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once('../../mainfile.php');
include_once('config.php');
include_once('class/class.permissions.php');
include_once('functions.php');
include_once('include/ui_functions.php');

if (@file_exists('./language/'.RC_ULANG.'/main.php'))
  include_once('./language/'.RC_ULANG.'/main.php');
else
  include_once('./language/english/main.php');

function forum_page_header()
{
  global $forumConfig, $rcxOption, $rcxConfig, $rcxModule, $HTTP_USER_AGENT, $_SERVER;

  site_cache('read');
  rcx_header(false);

  // Add the CSS + Javascript required for Forum Plus into the head element
  include_once('class/hover.css');
  include_once('include/forum.js');
?>
<script type="text/javascript" src="<?php echo RCX_URL; ?>/modules/forum/class/tabpane.js" ></script>
<?php
  include_once('class/tab.css');

  // Link in the RSS Feed - this allows aggregators to auto-discover the feed
  if ($forumConfig['rss_enable'])
  {
    echo '<link rel="alternate" type="application/rss+xml" title="Forum RSS" href="cache/forum.xml"/>';
  }

  $currenttheme = getTheme();
  include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/theme.php');

  if ( @file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.$rcxConfig['language'].'.php') )
  {
    include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.$rcxConfig['language'].'.php');
  }
  elseif ( @file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php') )
  {
    include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php');
  }

if ($rcxConfig['startpage'] == "forum")
  {        $rcxOption['show_rblock'] = 1;
} else {
  $rcxOption['show_rblock'] = 0;                       }
themeheader($rcxOption['show_rblock']);
  make_cblock(RCX_CENTERBLOCK_TOPALL);
?>
  <!-- START MODULE SPAN CSS -->
  <div id="<?php if ($rcxModule) { echo $rcxModule->dirname();}?>_dom" class="<?php if ($rcxModule) { echo $rcxModule->dirname();}?>_css">
  <!-- START MODULE SPAN CSS -->
<?php
}

?>