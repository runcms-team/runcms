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

if ( !defined('RCX_FOOTER_INCLUDED') ) {
  define('RCX_FOOTER_INCLUDED', 1);
make_cblock(RCX_CENTERBLOCK_BOTTOMALL);

$footer  = join('', file(RCX_ROOT_PATH . '/modules/system/cache/footer.php'));
/* you are not allowed to remove or changes this copyright and link in this footer  */
$footer .= "<br /><a href='http://www.runcms.ru/' target='_blank' title='-&nbsp;RUNCMS&nbsp;Copyright&nbsp;2002-".date('Y')." -'><img src='".RCX_URL."/images/rcxversion.gif' alt='-&nbsp;RUNCMS&nbsp;Copyright&nbsp;2002-".date('Y')."&nbsp;-' /></a><br /><br />";
?>
</div>
<?php
themefooter($rcxOption['show_rblock'], $footer);
rcx_footer();
}
?>
