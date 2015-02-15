<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }

$op = "default";
include (RCX_ROOT_PATH."/modules/system/admin/preferences/preferences.php");
if ( isset($_POST) ) {
  foreach ( $_POST as $k => $v ) {
    $$k = $v;
  }
}

if( $rcxUser->isAdmin($rcxModule->mid()) ) {

switch($op) {

case "save":
    
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      redirect_header('admin.php?fct=preferences', 3, $rcx_token->getErrors(true));
      exit();
  } 
    
  if ( !empty($changeusers) || empty($allow_theme) ) {
    $sql = "UPDATE ".RC_USERS_TBL." SET theme='$default_theme'";
    $db->query($sql);
  }

  if ( @!is_writable(RCX_ROOT_PATH."/modules/system/cache/config.php") ) {
    if ( @!chmod(RCX_ROOT_PATH."/modules/system/cache/config.php", 0666) ) {
      rcx_cp_header();
      printf(_MUSTWABLE, "<b>".RCX_ROOT_PATH."/modules/system/cache/config.php</b>");
      rcx_cp_footer();
      exit();
    }
  }

  save_pref(
    $adminmail,
    $mail_function,
// SMTP addon by SVL
    $pm_atonce,
    $ml_atonce,
    $send_pause,
    $smtp_host,
    $smtp_uname,
    $smtp_pass,
//
    $language,
    $startpage,
    $default_TZ,
    $default_theme,
    $allow_theme,
    $anonymous,
    $minpass,
    $anonpost,
    $max_pms,
    $allow_register,
    $img_verify,
    $auto_register,
    $new_user_notify,
    $new_user_notify_group,
    $self_delete,
    $display_loading_img,
    $gzip_compression,
    $uname_test_level,
    $cookie_name,
    $session_name,
    $old_session_name,
    $session_expire,
    $use_sessions,
    $old_session_use,
    $banners,
    $com_mode,
    $com_order,
    $atags,
    $admin_html,
    $utags,
    $user_html,
    $allow_html,
    $clickable,
    $allow_image,
    $allow_library,
    $lib_allow_upload,
    $lib_width,
    $lib_height,
    $lib_maxsize,
    $debug_mode,
    $cache_time,
    $avatar_allow_upload,
    $avatar_width,
    $avatar_height,
    $avatar_maxsize,
    $maintenance,
    $use_auth_admin,
    $hide_external_links,
    $cookie_httponly,
    $use_only_cookies,
    $ban_profile_viewer,
    $no_smile,
    $no_bbcode_user_sig,
    $use_captcha_for_admin,
    $admin_login_notify,
    $check_bruteforce_login,
    $count_failed_auth,
    $failed_lock_time,
    $admin_bruteforce_notify,
    $use_session_regenerate_id,
    $session_regenerate_id_lifetime,
    $x_frame_options,
    $x_xss_protection,
    $x_content_typ_options_nosniff,
    $bd_set_names,
    $bd_charset_name,
    $use_http_caching,
    $http_caching_user_agent,
    $http_cache_time );
    break;

default:
  rcx_cp_header();
  show_pref();
  echo "<br />";
  rcx_cp_footer();
  break;
}

}
?>
