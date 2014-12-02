<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ Themename : Runcms2
* @ License: Proprietary
*
*/
define("RCX_THEME", "runcms2");
function themeheader($show_rblock=0) {
global $rcxConfig, $rcxUser, $meta;
include ("page/themeheader.html");}
function themefooter($show_rblock=0, $footer='') {include ("page/themefooter.html");}
function themesidebox_left($title='', $content) {include ("page/themesidebox_left.html");}
function themesidebox_right($title='', $content) {include ("page/themesidebox_right.html");}
function themecenterbox_left($title='', $content) {include ("page/themecenterbox_left.html");}
function themecenterbox_center($title='', $content) {include ("page/themecenterbox_center.html");}
function themecenterbox_right($title='', $content) {include ("page/themecenterbox_right.html");}
function themenews($poster,$time,$title,$counter,$thetext,$timglink,$adminlink,$morelink='') {include ("page/themenews.html");}
function themecenterposts($title='', $content) {include ("page/themecenterposts.html");}
function theme_post($subject,$text,$color_number='',$subject_image='',$post_date='',$ip_image='',$reply_image='',$edit_image='',$delete_image='',$username='',$rank_title='',$rank_image='',$avatar_image='',$reg_date='',$posts='',$user_from='',$online_image='',$profile_image='',$pm_image='',$email_image='',$www_image='',$icq_image='',$aim_image='',$yim_image='',$msnm_image='') {
if ($color_number == 1) {$bg1 = 'bg1';$bg2 = 'bg3';} else {$bg1 = 'bg3';$bg2 = 'bg1';}include ("page/theme_post.html");}
function theme_waitbox() {include ("page/theme_waitbox.html");}
function OpenTable($width='100%') {?>
<table width="<?php echo $width;?>" border="0" cellspacing="1" cellpadding="0"><tr>
<td valign="top">
<table width="100%" border="0" cellspacing="1" cellpadding="0"><tr class="bg1">
<td valign="top">
<?php
}
function CloseTable() {?>
</td></tr></table></td></tr></table>
<?php
}
function themebox_template($title='', $content, $show_template) {
$dir  =   RCX_ROOT_PATH."/themes/".RCX_THEME."/template/";
include($dir.$show_template);	
}?>