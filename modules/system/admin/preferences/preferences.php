<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// check if the user is authorised
if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
  include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
  include_once(RCX_ROOT_PATH."/class/rcxlists.php");

  function show_pref() {
    global $rcxConfig, $rcxUser;

    $amail          = !empty($rcxConfig['adminmail']) ? $rcxConfig['adminmail'] : $rcxUser->getVar("email", "E");
    $adminmail_text = new RcxFormText(_MD_AM_ADMINML, "adminmail", 50, 100, $amail);
    $mail_function  = new RcxFormSelect(_MD_AM_MAILFUNC, "mail_function", $rcxConfig['mail_function']);
// remove email 	$mail_function->addOptionArray(array("mail"=>"mail()", "email"=>"email()", "SMTP"=>"SMTP"));
	$mail_function->addOptionArray(array("mail"=>"mail()", "SMTP"=>"SMTP"));
// SMTP addon by SVL
    $pm_atonce_txt  = new RcxFormText(_MD_AM_PMATONCE, "pm_atonce", 5, 5, $rcxConfig['pm_atonce']);
    $mail_atonce_txt= new RcxFormText(_MD_AM_MLATONCE, "ml_atonce", 5, 5, $rcxConfig['ml_atonce']);
    $send_pause_txt = new RcxFormText(_MD_AM_SLEEP, "send_pause", 5, 5, $rcxConfig['send_pause']);
    $smtp_host_txt  = new RcxFormText(_MD_AM_SMTPH, "smtp_host", 50, 100, $rcxConfig['smtp_host']);
    $smtp_uname_txt = new RcxFormText(_MD_AM_SMTPU, "smtp_uname", 50, 100, $rcxConfig['smtp_uname']);
    $smtp_pass_txt  = new RcxFormPassword(_MD_AM_SMTPP, "smtp_pass", 50, 100, $rcxConfig['smtp_pass']);            
//    
    $lang_select       = new RcxFormSelectLang(_MD_AM_LANGUAGE, "language", $rcxConfig['language']);
    $mod_select        = new RcxFormSelect(_MD_AM_STARTPAGE, "startpage", $rcxConfig['startpage']);
    $moduleslist       =& RcxModule::getHasMainModulesList(true);
    $moduleslist["-1"] = _NONE;
    $mod_select->addOptionArray($moduleslist);
    $defaulttz_select = new RcxFormSelectTimezone(_MD_AM_DEFAULTTZ, "default_TZ", $rcxConfig['default_TZ']);
    $theme_select     = new RcxFormSelectTheme("", "default_theme", $rcxConfig['default_theme']);
    $theme_cbox       = new RcxFormCheckBox("", "changeusers");
    $theme_cbox->addOption(1, _MD_AM_CHNGUTHEME);
    $theme_tray = new RcxFormElementTray(_MD_AM_DTHEME, "&nbsp;");
    $theme_tray->addElement($theme_select);
    $theme_tray->addElement($theme_cbox);
    $allowtheme_radio     = new RcxFormRadioYN(_MD_AM_ALLOWTHEME, "allow_theme", $rcxConfig['allow_theme'], _YES,_NO);
    $anon_text            = new RcxFormText(_MD_AM_ANONNAME, "anonymous", 50, 100, $rcxConfig['anonymous']);
    $minnpass_text        = new RcxFormText(_MD_AM_MINPASS, "minpass", 10, 10, $rcxConfig['minpass']);
    $anonpost_radio       = new RcxFormRadioYN(_MD_AM_ANONPOST, "anonpost", $rcxConfig['anonpost'], _YES,_NO);

    $max_pms              = new RcxFormText(_MD_AM_MAXPMS, "max_pms", 5, 5, $rcxConfig['max_pms']);

    $allowhtml_radio      = new RcxFormRadioYN(_MD_AM_ALLOWHTML, "allow_html", $rcxConfig['allow_html'], _YES,_NO);
    $allow_register       = new RcxFormRadioYN(_MD_AM_ALLOW_REGISTER, "allow_register", $rcxConfig['allow_register'], _YES,_NO);
    $img_verify           = new RcxFormRadioYN(_MD_AM_VERIFY_IMG, "img_verify", $rcxConfig['img_verify'], _YES,_NO);
    $allowimage_radio     = new RcxFormRadioYN(_MD_AM_ALLOWIMAGE, "allow_image", $rcxConfig['allow_image'], _YES,_NO);

    $libuse_radio    = new RcxFormRadioYN(_MD_AM_LIBUSE, "allow_library", $rcxConfig['allow_library'], _YES,_NO);
    $libupload_radio = new RcxFormRadioYN(_MD_AM_LIBUPLOAD, "lib_allow_upload", $rcxConfig['lib_allow_upload'], _YES, _NO);
    $libwidth_text   = new RcxFormText(_MD_AM_LIBW, "lib_width", 4, 4, $rcxConfig['lib_width']);
    $libheight_text  = new RcxFormText(_MD_AM_LIBH, "lib_height", 4, 4, $rcxConfig['lib_height']);
    $libsize_text    = new RcxFormText(_MD_AM_LIBMAX, "lib_maxsize", 7, 7, $rcxConfig['lib_maxsize']);
    $lib_tray        = new RcxFormElementTray(_MD_AM_LIBCONF, "<br />");
    $lib_tray->addElement($libuse_radio);
    $lib_tray->addElement($libupload_radio);
    $lib_tray->addElement($libwidth_text);
    $lib_tray->addElement($libheight_text);
    $lib_tray->addElement($libsize_text);

    $auto_register        = new RcxFormRadioYN(_MD_AM_AUTOREGISTER, "auto_register", $rcxConfig['auto_register'], _YES,_NO);
    $newuser_radio        = new RcxFormRadioYN("", "new_user_notify", $rcxConfig['new_user_notify'], _YES,_NO);
    $newuser_group_select = new RcxFormSelectGroup(_MD_AM_NOTIFYTO, "new_user_notify_group", false, $rcxConfig['new_user_notify_group'], 1, false);
    $newuser_tray         = new RcxFormElementTray(_MD_AM_NEWUNOTIFY, "<br />");
    $newuser_tray->addElement($newuser_radio);
    $newuser_tray->addElement($newuser_group_select);
    $sdelete_radio  = new RcxFormRadioYN(_MD_AM_SELFDELETE, "self_delete", $rcxConfig['self_delete'], _YES,_NO);
    $loading_radio  = new RcxFormRadioYN(_MD_AM_LOADINGIMG, "display_loading_img", $rcxConfig['display_loading_img'], _YES,_NO);
    $gzip_radio     = new RcxFormRadioYN(sprintf(_MD_AM_USEGZIP,phpversion()), "gzip_compression", $rcxConfig['gzip_compression'], _YES,_NO);
    $unamelv_select = new RcxFormSelect(_MD_AM_UNAMELVL, "uname_test_level", $rcxConfig['uname_test_level']);
    $unamelv_select->addOptionArray(array(0=>_MD_AM_STRICT,1=>_MD_AM_MEDIUM,2=>_MD_AM_LIGHT));

    $ucookie_text      = new RcxFormText(_MD_AM_USERCOOKIE, "cookie_name", 50, 100, $rcxConfig['cookie_name']);
    $scookie_text      = new RcxFormText(_MD_AM_SESSCOOKIE, "session_name", 50, 100, $rcxConfig['session_name']);
    $scookieold_hidden = new RcxFormHidden("old_session_name", $rcxConfig['session_name']);
    $sexpire_text      = new RcxFormText(_MD_AM_SESSEXPIRE, "session_expire", 15, 8, $rcxConfig['session_expire']);
    $suse_sessions     = new RcxFormRadioYN(_MD_AM_SESSUSE, "use_sessions", $rcxConfig['use_sessions'], _YES, _NO);
    $suse_old_hidden   = new RcxFormHidden("old_session_use", $rcxConfig['use_sessions']);

    $banner_radio      = new RcxFormRadioYN(_MD_AM_BANNERS, "banners", $rcxConfig['banners'], _YES, _NO);

    $debug_ops[] = ($rcxConfig['debug_mode'] & 1)  ? 1  : 0;
    $debug_ops[] = ($rcxConfig['debug_mode'] & 2)  ? 2  : 0;
    $debug_ops[] = ($rcxConfig['debug_mode'] & 4)  ? 4  : 0;
    $debug_ops[] = ($rcxConfig['debug_mode'] & 8)  ? 8  : 0;
    $debug_ops[] = ($rcxConfig['debug_mode'] & 16) ? 16 : 0;
    $debug_radio   = new RcxFormCheckBox(_MD_AM_DEBUGMODE, "debug_mode", $debug_ops, 1);
    $debug_options = array(
            "1" =>_MD_AM_DBGERR,
            "2" =>_MD_AM_DBGTIME,
            "4" =>_MD_AM_DBGINFO,
            "8" =>_MD_AM_DBGLOG,
            "16"=>_MD_AM_DBGVIS);
    $debug_radio->addOptionArray($debug_options);

    $cache_text = new RcxFormSelect(_MD_AM_CACHETIME, "cache_time", $rcxConfig['cache_time']);
    $cache_text->addOptionArray(array(0=>_OFF, 300=>5, 600=>10, 900=>15, 1800=>30, 3600=>60, 5400=>90, 7200=>120, 10800=>180));
    $cmode_select = new RcxFormSelect(_MD_AM_COMMODE, "com_mode", $rcxConfig['com_mode']);
    $cmode_select->addOptionArray(array("0"=>_NOCOMMENTS, "flat"=>_FLAT, "thread"=>_THREADED));
    $corder_select = new RcxFormSelect(_MD_AM_COMORDER, "com_order", $rcxConfig['com_order']);
    $corder_select->addOptionArray(array("0"=>_OLDESTFIRST, "1"=>_NEWESTFIRST));
    $avallow_radio = new RcxFormRadioYN(_MD_AM_AVATARALLOW, "avatar_allow_upload", $rcxConfig['avatar_allow_upload'], _YES, _NO);
    $avwidth_text  = new RcxFormText(_MD_AM_AVATARW, "avatar_width", 4, 4, $rcxConfig['avatar_width']);
    $avheight_text = new RcxFormText(_MD_AM_AVATARH, "avatar_height", 4, 4, $rcxConfig['avatar_height']);
    $avsize_text   = new RcxFormText(_MD_AM_AVATARMAX, "avatar_maxsize", 7, 7, $rcxConfig['avatar_maxsize']);
    $av_tray       = new RcxFormElementTray(_MD_AM_AVATARCONF, "<br />");
    $av_tray->addElement($avallow_radio);
    $av_tray->addElement($avwidth_text);
    $av_tray->addElement($avheight_text);
    $av_tray->addElement($avsize_text);
    $htmlarray    = RcxLists::getHtmlList();
    $atags        = array();
    $atags        = explode("|", $rcxConfig['admin_html']);
    $ahtml_select = new RcxFormSelect(_MD_AM_ADMTAGS, "atags", $atags, 10, true);
    $ahtml_select->addOptionArray($htmlarray);
    $utags        = array();
    $utags        = explode("|", $rcxConfig['user_html']);
    $uhtml_select = new RcxFormSelect(_MD_AM_USRTAGS, "utags", $utags, 10, true);
    $uhtml_select->addOptionArray($htmlarray);
    $html_tray = new RcxFormElementTray(_MD_AM_DEFHTML, "&nbsp;");
    $html_tray->addElement($ahtml_select);
    $html_tray->addElement($uhtml_select);
    $op_hidden     = new RcxFormHidden("op", "save");
    $submit_button = new RcxFormButton("", "button", _UPDATE, "submit");
    $maintenance     = new RcxFormRadioYN(_MD_AM_MAINTENANCE, "maintenance", $rcxConfig['maintenance'], _YES, _NO);

    $form = new RcxThemeForm(_MD_AM_SITEPREF, "pref_form", "admin.php?fct=preferences", "post", true);
    $form->addElement($adminmail_text);
    $form->addElement($mail_function);
// SMTP addon by SVL
    $form->addElement($pm_atonce_txt);
    $form->addElement($mail_atonce_txt);
    $form->addElement($send_pause_txt);
    $form->addElement($smtp_host_txt);
    $form->addElement($smtp_uname_txt);
    $form->addElement($smtp_pass_txt);
// sprogvalg
    $form->addElement($lang_select);
    $form->addElement($mod_select);
    $form->addElement($defaulttz_select);
    $form->addElement($theme_tray);
    $form->addElement($allowtheme_radio);
    $form->addElement($anon_text);
    $form->addElement($minnpass_text);
    $form->addElement($anonpost_radio);
    $form->addElement($max_pms);
    $form->addElement($allowhtml_radio);
    $form->addElement($allowimage_radio);
    $form->addElement($lib_tray);
    $form->addElement($allow_register);
    $form->addElement($img_verify);
    $form->addElement($auto_register);
    $form->addElement($newuser_tray);
    $form->addElement($sdelete_radio);
    $form->addElement($loading_radio);
    $form->addElement($gzip_radio);
    $form->addElement($unamelv_select);
    $form->addElement($ucookie_text);
    $form->addElement($scookie_text);
    $form->addElement($scookieold_hidden);
    $form->addElement($sexpire_text);
    $form->addElement($suse_sessions);
    $form->addElement($suse_old_hidden);
    $form->addElement($banner_radio);
    $form->addElement($debug_radio);
    $form->addElement($cache_text);
    $form->addElement($cmode_select);
    $form->addElement($corder_select);
    $form->addElement($av_tray);
    $form->addElement($html_tray);
    $form->addElement($maintenance);
    $form->addElement($op_hidden);
    $form->addElement($submit_button);

    OpenTable();
    $form->display();
    CloseTable();
  }

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_pref(
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
    $maintenance) {
    global $rcxConfig, $myts, $_COOKIE;

    $error = "";
// SMTP addon by SVL
    if ($mail_function != "SMTP") {
      if ( !function_exists("$mail_function") ) {
      $error .= "<h4>".sprintf(_MD_AM_INVLDMAILFUNC, $mail_function)."</h4>";
      }
    }
//
    if ( !is_numeric($minpass) ) {
      $error .= "<h4>"._MD_AM_INVLDMINPASS."</h4>";
    }
    if ( !is_numeric($session_expire) ) {
      $error .= "<h4>"._MD_AM_INVLDSEXP."</h4>";
    }
    if ( empty($cookie_name) || preg_match("/[^a-z0-9_-]/", $cookie_name) ) {
      $error .= "<h4>"._MD_AM_INVLDUCOOK."</h4>";
    }
    if ( empty($session_name) || preg_match("/[^a-z0-9_-]/i", $session_name) ) {
      $error .= "<h4>"._MD_AM_INVLDSCOOK."</h4>";
    }
    if ( empty($adminmail) ) {
      $error .= "<h4>"._MD_AM_ADMNOTSET."</h4>";
    }
    if ($error != "") {
      rcx_cp_header();
      echo $error;
      rcx_cp_footer();
      exit();
    }

    $admin_html = "";
    if ( count($atags) > 0 ) {
      foreach ( $atags as $atag ) {
        $admin_html .= $atag."|";
      }
      $admin_html = substr($admin_html, 0, -1);
    }
    $user_html = "";
    if ( count($utags) > 0 ) {
      foreach ( $utags as $utag ) {
        $user_html .= $utag."|";
      }
      $user_html = substr($user_html, 0, -1);
    }

    $debug_size = count($debug_mode);
    for ($i=0;$i<$debug_size;$i++) {
      $debug_out += $debug_mode[$i];
    }

// SMTP addon by SVL
$config = "<"."?php
/*********************************************************************
"._MD_AM_REMEMBER."
"._MD_AM_IFUCANT."
*********************************************************************/

// "._MD_AM_ADMINML."
\$rcxConfig['adminmail'] = \"".$myts->makeTboxData4PreviewInForm($adminmail)."\";

// "._MD_AM_MAILFUNC."
\$rcxConfig['mail_function'] = \"".$mail_function."\";

// "._MD_AM_PMATONCE."
\$rcxConfig['pm_atonce'] = \"".intval($pm_atonce)."\";

// "._MD_AM_MLATONCE."
\$rcxConfig['ml_atonce'] = \"".intval($ml_atonce)."\";

// "._MD_AM_SLEEP."
\$rcxConfig['send_pause'] = \"".intval($send_pause)."\";

// "._MD_AM_SMTPH."
\$rcxConfig['smtp_host'] = \"".$myts->makeTboxData4PreviewInForm($smtp_host)."\";

// "._MD_AM_SMTPU."
\$rcxConfig['smtp_uname'] = \"".$myts->makeTboxData4PreviewInForm($smtp_uname)."\";

// "._MD_AM_SMTPP."
\$rcxConfig['smtp_pass'] = \"".$myts->makeTboxData4PreviewInForm($smtp_pass)."\";

// "._MD_AM_LANGUAGE."
\$rcxConfig['language'] = \"".$myts->makeTboxData4PreviewInForm($language)."\";

// "._MD_AM_STARTPAGE."
\$rcxConfig['startpage'] = \"".$myts->makeTboxData4PreviewInForm($startpage)."\";

// "._MD_AM_DTHEME."
\$rcxConfig['default_theme'] = \"".$myts->makeTboxData4PreviewInForm($default_theme)."\";

// "._MD_AM_ALLOWTHEME." (1="._YES." 0="._NO.")
\$rcxConfig['allow_theme'] = ".intval($allow_theme).";

// "._MD_AM_ANONNAME."
\$rcxConfig['anonymous'] = \"".$myts->makeTboxData4PreviewInForm($anonymous)."\";

// "._MD_AM_MINPASS."
\$rcxConfig['minpass'] = ".intval($minpass).";

// "._MD_AM_ANONPOST." (1="._YES." 0="._NO.")
\$rcxConfig['anonpost'] = ".intval($anonpost).";

// "._MD_AM_MAXPMS."
\$rcxConfig['max_pms'] = ".intval($max_pms).";

// "._MD_AM_ALLOWHTML." (1="._YES." 0="._NO.")
\$rcxConfig['allow_html'] = ".intval($allow_html).";

// "._MD_AM_LIBUSE." (1="._YES." 0="._NO.")
\$rcxConfig['allow_library'] = ".intval($allow_library).";

// "._MD_AM_LIBUPLOAD." (1="._YES." 0="._NO.")
\$rcxConfig['lib_allow_upload'] = ".intval($lib_allow_upload).";

// "._MD_AM_LIBW."
\$rcxConfig['lib_width'] = ".intval($lib_width).";

// "._MD_AM_LIBH."
\$rcxConfig['lib_height'] = ".intval($lib_height).";

// "._MD_AM_LIBMAX."
\$rcxConfig['lib_maxsize'] = ".intval($lib_maxsize).";

// "._MD_AM_ALLOWIMAGE." (1="._YES." 0="._NO.")
\$rcxConfig['allow_image'] = ".intval($allow_image).";

// "._MD_AM_ALLOW_REGISTER." (1="._YES." 0="._NO.")
\$rcxConfig['allow_register'] = ".intval($allow_register).";

// "._MD_AM_VERIFY_IMG." (1="._YES." 0="._NO.")
\$rcxConfig['img_verify'] = ".intval($img_verify).";

// "._MD_AM_AUTOREGISTER." (1="._YES." 0="._NO.")
\$rcxConfig['auto_register'] = ".intval($auto_register).";

// "._MD_AM_NEWUNOTIFY." (1="._YES." 0="._NO.")
\$rcxConfig['new_user_notify'] = ".intval($new_user_notify).";

// "._MD_AM_NOTIFYTO."
\$rcxConfig['new_user_notify_group'] = ".intval($new_user_notify_group).";

// "._MD_AM_SELFDELETE." (1="._YES." 0="._NO.")
\$rcxConfig['self_delete'] = ".intval($self_delete).";

// "._MD_AM_LOADINGIMG." (1="._YES." 0="._NO.")
\$rcxConfig['display_loading_img'] = ".intval($display_loading_img).";

// ".sprintf(_MD_AM_USEGZIP,phpversion())." (1="._YES." 0="._NO.")
\$rcxConfig['gzip_compression'] = ".intval($gzip_compression).";

// "._MD_AM_UNAMELVL."  ("._MD_AM_STRICT."=0 "._MD_AM_MEDIUM."=1 "._MD_AM_LIGHT."=2)
\$rcxConfig['uname_test_level'] = ".intval($uname_test_level).";

// "._MD_AM_USERCOOKIE."
\$rcxConfig['cookie_name'] = \"".$cookie_name."\";

// "._MD_AM_SESSCOOKIE."
\$rcxConfig['session_name'] = \"".$session_name."\";

// "._MD_AM_SESSEXPIRE."
\$rcxConfig['session_expire'] = ".intval($session_expire).";

// "._MD_AM_SESSUSE."
\$rcxConfig['use_sessions'] = ".intval($use_sessions).";

// "._MD_AM_SERVERTZ."
\$rcxConfig['server_TZ'] = \"".(date('Z')/3600)."\";

// "._MD_AM_DEFAULTTZ."
\$rcxConfig['default_TZ'] = \"".$default_TZ."\";

// "._MD_AM_BANNERS." (1="._YES." 0="._NO.")
\$rcxConfig['banners'] = ".intval($banners).";

// "._MD_AM_DEBUGMODE."
\$rcxConfig['debug_mode'] = ".intval($debug_out).";

// "._MD_AM_CACHETIME."
\$rcxConfig['cache_time'] = ".intval($cache_time).";

// "._MD_AM_COMMODE." (0="._NOCOMMENTS." flat="._FLAT." thread="._THREADED.")
\$rcxConfig['com_mode'] = \"".$com_mode."\";

// "._MD_AM_COMORDER." (0="._OLDESTFIRST." 1="._NEWESTFIRST.")
\$rcxConfig['com_order'] = ".intval($com_order).";

// "._MD_AM_AVATARALLOW." (1="._YES." 0="._NO.")
\$rcxConfig['avatar_allow_upload'] = ".intval($avatar_allow_upload).";

// "._MD_AM_AVATARW."
\$rcxConfig['avatar_width'] = ".intval($avatar_width).";

// "._MD_AM_AVATARH."
\$rcxConfig['avatar_height'] = ".intval($avatar_height).";

// "._MD_AM_AVATARMAX."
\$rcxConfig['avatar_maxsize'] = ".intval($avatar_maxsize).";

// "._MD_AM_ADMHTML."
\$rcxConfig['admin_html'] = \"".$admin_html."\";

// "._MD_AM_USRHTML."
\$rcxConfig['user_html'] = \"".$user_html."\";

// "._MD_AM_MAINTENANCE."
\$rcxConfig['maintenance'] = ".intval($maintenance).";

?".">";
    $file = fopen(RCX_ROOT_PATH."/modules/system/cache/config.php", "w");
  if ( -1 != fwrite($file, $config) ) {
    if ( ( $session_name != $old_session_name) || ($use_sessions !=  $old_session_use) ) {
        global $_SESSION, $_COOKIE;
        if ($use_sessions == 1) {
          if (session_is_registered($old_session_name)) {
            $_SESSION[$session_name] = $_SESSION[$old_session_name];
            session_unregister($old_session_name);
            } else {
              session_start();
              $_SESSION[$session_name] = $_COOKIE[$old_session_name];
            }
          } else {
            if (session_is_registered($old_session_name)) {
              cookie($session_name, $_SESSION[$old_session_name], 360000);
              } else {
                cookie($session_name, $_COOKIE[$old_session_name], 360000);
                cookie($old_session_name);
              }
          }
      }
    fclose($file);
    redirect_header("admin.php?fct=preferences", 2, _UPDATED);
    exit();
  }
}
  } else {
    redirect_header(RCX_URL.'/', 2, _NOPERM);
    exit();
  }
?>
