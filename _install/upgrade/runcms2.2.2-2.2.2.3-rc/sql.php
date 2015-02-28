<?php
include_once(RCX_ROOT_PATH . "/class/rcxmodule.php");

if (file_exists(RCX_ROOT_PATH . "/modules/system/admin/preferences/language/" . RC_ULANG . "/preferences.php")) {
    include(RCX_ROOT_PATH . "/modules/system/admin/preferences/language/" . RC_ULANG . "/preferences.php");
} elseif (file_exists(RCX_ROOT_PATH . "/modules/system/admin/preferences/language/english/preferences.php")) {
    include(RCX_ROOT_PATH . "/modules/system/admin/preferences/language/english/preferences.php");
}

@set_time_limit(300);

$um = new UpgradeMessage;

if (RcxModule::moduleExists('news')) {
    $sql[0] = "ALTER TABLE `" . $db->prefix("stories") . "` CHANGE `title` `title` VARCHAR( 255 ) NOT NULL DEFAULT ''";
    $sql[1] = "ALTER TABLE `" . $db->prefix("topics") . "` CHANGE `topic_title` `topic_title` VARCHAR( 255 ) NOT NULL DEFAULT ''";
}

if (RcxModule::moduleExists('sections')) {
    $sql[2] = "ALTER TABLE `" . $db->prefix("nseccont") . "` CHANGE `title` `title` VARCHAR( 255 ) NOT NULL DEFAULT ''";
    $sql[3] = "ALTER TABLE `" . $db->prefix("nsections") . "` CHANGE `secname` `secname` VARCHAR( 255 ) NOT NULL DEFAULT ''";
}

$sql[4] = "ALTER TABLE `" . $db->prefix("session") . "` DROP PRIMARY KEY";

$sql[5] = "CREATE TABLE `" . $db->prefix("cpsession") . "` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uname` varchar(30) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `mid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(40) NOT NULL DEFAULT '',
  KEY `idx` (`uid`,`hash`)
) ENGINE=MyISAM;";

$sql[6] = "CREATE TABLE `" . $db->prefix("login_log") . "` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uname` varchar(30) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL,
  `status` enum('success','fail') NOT NULL DEFAULT 'fail',
  `type` enum('admin','user') NOT NULL DEFAULT 'admin',
  `reason` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;";

$sql[7] = "ALTER TABLE `" . $db->prefix("modules") . "` CHANGE `version` `version` VARCHAR( 16 ) NOT NULL DEFAULT '1.0.0'";

foreach ($sql as $key => $value) {

    if ($db->query($value)) {
        $um->addMessage($message[$key]['noerror']);
    } else {
        $um->addErrors($message[$key]['error'] . ': "' . $db->error() . '"');
    }
}

$db->clear_cache();

save_rcx_config();
save_rcx_meta();

$dirs = array(
    RCX_ROOT_PATH . '/class/kcaptcha/fonts',
    RCX_ROOT_PATH . '/modules/headlines/magpierss'
);

foreach ($dirs as $dir) {

    if (file_exists($dir) && treermdir($dir) === true) {
        $um->addMessage(sprintf(_UPGRADE_RMDIR, $dir));
    } else {
        $um->addErrors(sprintf(_UPGRADE_NO_RMDIR, $dir));
    }
}

$modules = & RcxModule::getInstalledModules();

foreach ($modules as $module) {

    if ($module->update() === false) {
        $um->addErrors($module->errors);
    } else {
        $um->addMessage(sprintf(_UPGRADE_MODULE_UPDATE, $module->name()));
    }
}

echo "<h2>" . _UPGRADE_CONGRAT . "<font color='#FF0000'> \"_install\" </font></h2>";
wizOpenTable();
echo $um->getErrors();
wizCloseTable();
echo "<br />";
wizOpenTable();
echo $um->getMessage();
wizCloseTable();
echo "<br /><hr>";

/**
 * 
 * @global type $rcxConfig
 * @global UpgradeMessage $um
 */
function save_rcx_config()
{
    global $rcxConfig, $um;

    if (!empty($rcxConfig)) {

        $rcxConfig['x_frame_options'] = 0;
        $rcxConfig['x_xss_protection'] = 0;
        $rcxConfig['x_content_typ_options_nosniff'] = 0;
        $rcxConfig['smtp_port'] = "25";
        $rcxConfig['clickable'] = 0;
        $rcxConfig['use_auth_admin'] = 0;
        $rcxConfig['use_session_regenerate_id'] = 0;
        $rcxConfig['session_regenerate_id_lifetime'] = 60;
        $rcxConfig['use_captcha_for_admin'] = 0;
        $rcxConfig['admin_login_notify'] = 0;
        $rcxConfig['check_bruteforce_login'] = 1;
        $rcxConfig['count_failed_auth'] = "5";
        $rcxConfig['failed_lock_time'] = "15";
        $rcxConfig['admin_bruteforce_notify'] = 0;
        $rcxConfig['hide_external_links'] = 0;
        $rcxConfig['cookie_httponly'] = 0;
        $rcxConfig['use_only_cookies'] = 0;
        $rcxConfig['ban_profile_viewer'] = 0;
        $rcxConfig['no_smile'] = 0;
        $rcxConfig['no_bbcode_user_sig'] = 0;
        $rcxConfig['bd_set_names'] = 0;
        $rcxConfig['bd_charset_name'] = "cp1251";
        $rcxConfig['use_http_caching'] = 0;
        $rcxConfig['http_cache_time'] = "10080";
        $rcxConfig['http_caching_user_agent'] = "Yandex|Googlebot|Yahoo|msnbot|StackRambler|WebAlta Crawler|aport|Mail\.Ru";
        $rcxConfig['no_redirect'] = 0;

        $config = "<" . "?php
/*********************************************************************
" . _MD_AM_REMEMBER . "
" . _MD_AM_IFUCANT . "
*********************************************************************/

// " . _MD_AM_X_FRAME_OPTIONS . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['x_frame_options'] = " . $rcxConfig['x_frame_options'] . ";
    
// " . _MD_AM_X_XSS_PROTECTION . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['x_xss_protection'] = " . $rcxConfig['x_xss_protection'] . ";
    
// " . _MD_AM_X_CONTENT_TYP_OPTIONS_NOSNIFF . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['x_content_typ_options_nosniff'] = " . $rcxConfig['x_content_typ_options_nosniff'] . ";

// " . _MD_AM_ADMINML . "
\$rcxConfig['adminmail'] = \"" . $rcxConfig['adminmail'] . "\";

// " . _MD_AM_MAILFUNC . "
\$rcxConfig['mail_function'] = \"" . $rcxConfig['mail_function'] . "\";

// " . _MD_AM_PMATONCE . "
\$rcxConfig['pm_atonce'] = \"" . $rcxConfig['pm_atonce'] . "\";

// " . _MD_AM_MLATONCE . "
\$rcxConfig['ml_atonce'] = \"" . $rcxConfig['ml_atonce'] . "\";

// " . _MD_AM_SLEEP . "
\$rcxConfig['send_pause'] = \"" . $rcxConfig['send_pause'] . "\";

// " . _MD_AM_SMTPH . "
\$rcxConfig['smtp_host'] = \"" . $rcxConfig['smtp_host'] . "\";

// " . _MD_AM_SMTPU . "
\$rcxConfig['smtp_uname'] = \"" . $rcxConfig['smtp_uname'] . "\";

// " . _MD_AM_SMTPP . "
\$rcxConfig['smtp_pass'] = \"" . $rcxConfig['smtp_pass'] . "\";
    
// " . _MD_AM_SMTPPORT . "
\$rcxConfig['smtp_port'] = \"" . $rcxConfig['smtp_port'] . "\";

// " . _MD_AM_LANGUAGE . "
\$rcxConfig['language'] = \"" . $rcxConfig['language'] . "\";

// " . _MD_AM_STARTPAGE . "
\$rcxConfig['startpage'] = \"" . $rcxConfig['startpage'] . "\";

// " . _MD_AM_DTHEME . "
\$rcxConfig['default_theme'] = \"" . $rcxConfig['default_theme'] . "\";

// " . _MD_AM_ALLOWTHEME . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['allow_theme'] = " . $rcxConfig['allow_theme'] . ";

// " . _MD_AM_ANONNAME . "
\$rcxConfig['anonymous'] = \"" . $rcxConfig['anonymous'] . "\";

// " . _MD_AM_MINPASS . "
\$rcxConfig['minpass'] = " . $rcxConfig['minpass'] . ";

// " . _MD_AM_ANONPOST . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['anonpost'] = " . $rcxConfig['anonpost'] . ";

// " . _MD_AM_MAXPMS . "
\$rcxConfig['max_pms'] = " . $rcxConfig['max_pms'] . ";

// " . _MD_AM_CLICKABLE . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['clickable'] = " . $rcxConfig['clickable'] . ";

// " . _MD_AM_ALLOWHTML . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['allow_html'] = " . $rcxConfig['allow_html'] . ";

// " . _MD_AM_LIBUSE . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['allow_library'] = " . $rcxConfig['allow_library'] . ";

// " . _MD_AM_LIBUPLOAD . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['lib_allow_upload'] = " . $rcxConfig['lib_allow_upload'] . ";

// " . _MD_AM_LIBW . "
\$rcxConfig['lib_width'] = " . $rcxConfig['lib_width'] . ";

// " . _MD_AM_LIBH . "
\$rcxConfig['lib_height'] = " . $rcxConfig['lib_height'] . ";

// " . _MD_AM_LIBMAX . "
\$rcxConfig['lib_maxsize'] = " . $rcxConfig['lib_maxsize'] . ";

// " . _MD_AM_ALLOWIMAGE . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['allow_image'] = " . $rcxConfig['allow_image'] . ";

// " . _MD_AM_ALLOW_REGISTER . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['allow_register'] = " . $rcxConfig['allow_register'] . ";

// " . _MD_AM_VERIFY_IMG . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['img_verify'] = " . $rcxConfig['img_verify'] . ";

// " . _MD_AM_AUTOREGISTER . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['auto_register'] = " . $rcxConfig['auto_register'] . ";

// " . _MD_AM_NEWUNOTIFY . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['new_user_notify'] = " . $rcxConfig['new_user_notify'] . ";

// " . _MD_AM_NOTIFYTO . "
\$rcxConfig['new_user_notify_group'] = " . $rcxConfig['new_user_notify_group'] . ";

// " . _MD_AM_SELFDELETE . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['self_delete'] = " . $rcxConfig['self_delete'] . ";

// " . _MD_AM_LOADINGIMG . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['display_loading_img'] = " . $rcxConfig['display_loading_img'] . ";

// " . sprintf(_MD_AM_USEGZIP, phpversion()) . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['gzip_compression'] = " . $rcxConfig['gzip_compression'] . ";

// " . _MD_AM_UNAMELVL . "  (" . _MD_AM_STRICT . "=0 " . _MD_AM_MEDIUM . "=1 " . _MD_AM_LIGHT . "=2)
\$rcxConfig['uname_test_level'] = " . $rcxConfig['uname_test_level'] . ";

// " . _MD_AM_USERCOOKIE . "
\$rcxConfig['cookie_name'] = \"" . $rcxConfig['cookie_name'] . "\";

// " . _MD_AM_SESSCOOKIE . "
\$rcxConfig['session_name'] = \"" . $rcxConfig['session_name'] . "\";

// " . _MD_AM_SESSEXPIRE . "
\$rcxConfig['session_expire'] = " . $rcxConfig['session_expire'] . ";

// " . _MD_AM_SESSUSE . "
\$rcxConfig['use_sessions'] = " . $rcxConfig['use_sessions'] . ";

// " . _MD_AM_SERVERTZ . "
\$rcxConfig['server_TZ'] = \"" . $rcxConfig['server_TZ'] . "\";

// " . _MD_AM_DEFAULTTZ . "
\$rcxConfig['default_TZ'] = \"" . $rcxConfig['default_TZ'] . "\";

// " . _MD_AM_BANNERS . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['banners'] = " . $rcxConfig['banners'] . ";

// " . _MD_AM_DEBUGMODE . "
\$rcxConfig['debug_mode'] = " . $rcxConfig['debug_mode'] . ";

// " . _MD_AM_CACHETIME . "
\$rcxConfig['cache_time'] = " . $rcxConfig['cache_time'] . ";

// " . _MD_AM_COMMODE . " (0=" . _NOCOMMENTS . " flat=" . _FLAT . " thread=" . _THREADED . ")
\$rcxConfig['com_mode'] = \"" . $rcxConfig['com_mode'] . "\";

// " . _MD_AM_COMORDER . " (0=" . _OLDESTFIRST . " 1=" . _NEWESTFIRST . ")
\$rcxConfig['com_order'] = " . $rcxConfig['com_order'] . ";

// " . _MD_AM_AVATARALLOW . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['avatar_allow_upload'] = " . $rcxConfig['avatar_allow_upload'] . ";

// " . _MD_AM_AVATARW . "
\$rcxConfig['avatar_width'] = " . $rcxConfig['avatar_width'] . ";

// " . _MD_AM_AVATARH . "
\$rcxConfig['avatar_height'] = " . $rcxConfig['avatar_height'] . ";

// " . _MD_AM_AVATARMAX . "
\$rcxConfig['avatar_maxsize'] = " . $rcxConfig['avatar_maxsize'] . ";

// " . _MD_AM_ADMHTML . "
\$rcxConfig['admin_html'] = \"" . $rcxConfig['admin_html'] . "\";

// " . _MD_AM_USRHTML . "
\$rcxConfig['user_html'] = \"" . $rcxConfig['user_html'] . "\";

// " . _MD_AM_MAINTENANCE . "
\$rcxConfig['maintenance'] = " . $rcxConfig['maintenance'] . ";

// " . _MD_AM_USE_AUTH_ADMIN . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['use_auth_admin'] = " . $rcxConfig['use_auth_admin'] . ";

// " . _MD_AM_USE_SESSION_REGENERATE_ID . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['use_session_regenerate_id'] = " . $rcxConfig['use_session_regenerate_id'] . ";

// " . _MD_AM_SESSION_REGENERATE_ID_LIFETIME . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['session_regenerate_id_lifetime'] = " . $rcxConfig['session_regenerate_id_lifetime'] . ";

// " . _MD_USE_CAPTCHA_FOR_ADMIN . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['use_captcha_for_admin'] = " . $rcxConfig['use_captcha_for_admin'] . ";

// " . _MD_ADMIN_LOGIN_NOTIFY . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['admin_login_notify'] = " . $rcxConfig['admin_login_notify'] . ";

// " . _MD_CHECK_BRUTEFORCE_LOGIN . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['check_bruteforce_login'] = " . $rcxConfig['check_bruteforce_login'] . ";

// " . _MD_COUNT_FAILED_AUTH . "
\$rcxConfig['count_failed_auth'] = \"" . $rcxConfig['count_failed_auth'] . "\";

// " . _MD_FAILED_LOCK_TIME . "
\$rcxConfig['failed_lock_time'] = \"" . $rcxConfig['failed_lock_time'] . "\";

// " . _MD_ADMIN_BRUTEFORCE_NOTIFY . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['admin_bruteforce_notify'] = " . $rcxConfig['admin_bruteforce_notify'] . ";

// " . _MD_AM_HIDE_EXTERNAL_LINKS . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['hide_external_links'] = " . $rcxConfig['hide_external_links'] . ";

// " . _MD_AM_COOKIE_HTTPONLY . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['cookie_httponly'] = " . $rcxConfig['cookie_httponly'] . ";

// " . _MD_AM_USE_ONLY_COOKIES . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['use_only_cookies'] = " . $rcxConfig['use_only_cookies'] . ";

// " . _MD_AM_BAN_PROFILE_VIEWER . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['ban_profile_viewer'] = " . $rcxConfig['ban_profile_viewer'] . ";

// " . _MD_AM_NO_SMILE . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['no_smile'] = " . $rcxConfig['no_smile'] . ";

// " . _MD_AM_NOBBCODE_USERSIG . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['no_bbcode_user_sig'] = " . $rcxConfig['no_bbcode_user_sig'] . ";
    
// " . _MD_AM_BD_SET_NAMES . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['bd_set_names'] = " . $rcxConfig['bd_set_names'] . ";
    
// " . _MD_AM_BD_CHARSET_NAME . "
\$rcxConfig['bd_charset_name'] = \"" . $rcxConfig['bd_charset_name'] . "\";
    
// " . _MD_AM_USE_HTTP_CACHING . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['use_http_caching'] = " . $rcxConfig['use_http_caching'] . ";
    
// " . _MD_AM_HTTP_CACHE_TIME . "
\$rcxConfig['http_cache_time'] = \"" . $rcxConfig['http_cache_time'] . "\";
    
// " . _MD_AM_HTTP_CACHING_USER_AGENT . "
\$rcxConfig['http_caching_user_agent'] = \"" . $rcxConfig['http_caching_user_agent'] . "\";
    
// " . _MD_AM_NO_REDIRECT . " (1=" . _YES . " 0=" . _NO . ")
\$rcxConfig['no_redirect'] = " . $rcxConfig['no_redirect'] . ";

?" . ">";

        $filename = RCX_ROOT_PATH . "/modules/system/cache/config.php";

        if ($file = fopen($filename, "w")) {
            fwrite($file, $config);
            fclose($file);
            $um->addMessage(_UPGRADE_SAVE_CONFIG);
        } else {
            $um->addErrors(_UPGRADE_NO_SAVE_CONFIG);
        }
    } else {
        $um->setErrors(_UPGRADE_NO_SAVE_CONFIG);
    }
}

function save_rcx_meta()
{
    global $meta, $um;

    if (!empty($meta)) {

        $meta['nogenerator'] = "0";

        $content = "<?php" . PHP_EOL;
        $content .= "\$meta['title'] = \"" . $meta['title'] . "\";" . PHP_EOL;
        $content .= "\$meta['author'] = \"" . $meta['author'] . "\";" . PHP_EOL;
        $content .= "\$meta['copyright'] = \"" . $meta['copyright'] . "\";" . PHP_EOL;
        $content .= "\$meta['nogenerator'] = \"" . $meta['nogenerator'] . "\";" . PHP_EOL;
        $content .= "\$meta['slogan'] = \"" . $meta['slogan'] . "\";" . PHP_EOL;
        $content .= "\$meta['keywords'] = \"" . $meta['keywords'] . "\";" . PHP_EOL;
        $content .= "\$meta['rating'] = \"" . $meta['rating'] . "\";" . PHP_EOL;
        $content .= "\$meta['p3p'] = \"" . $meta['p3p'] . "\";" . PHP_EOL;
        $content .= "\$meta['index'] = \"" . $meta['index'] . "\";" . PHP_EOL;
        $content .= "\$meta['follow'] = \"" . $meta['follow'] . "\";" . PHP_EOL;
        $content .= "\$meta['pragma'] = \"" . $meta['pragma'] . "\";" . PHP_EOL;
        $content .= "\$meta['icon'] = \"" . $meta['icon'] . "\";" . PHP_EOL;
        $content .= "\$meta['description'] = \"" . $meta['description'] . "\";" . PHP_EOL;
        $content .= "\$meta['extractor'] = \"" . $meta['extractor'] . "\";" . PHP_EOL;
        $content .= "\$meta['cloaking'] = \"" . $meta['cloaking'] . "\";" . PHP_EOL;
        $content .= "\$meta['max_words'] = \"" . $meta['max_words'] . "\";" . PHP_EOL;
        $content .= "\$meta['max_depth'] = \"" . $meta['max_depth'] . "\";" . PHP_EOL;
        $content .= "\$meta['user_agents'] = \"" . $meta['user_agents'] . "\";" . PHP_EOL;
        $content .= "?>";

        $filename = RCX_ROOT_PATH . "/modules/system/cache/meta.php";

        if ($file = fopen($filename, "w")) {
            fwrite($file, $content);
            fclose($file);
            $um->addMessage(_UPGRADE_SAVE_META);
        } else {
            $um->addErrors(_UPGRADE_NO_SAVE_META);
        }
    } else {
        $um->setErrors(_UPGRADE_NO_SAVE_META);
    }
}

/**
 * 
 * @link http://php.net/manual/ru/function.rmdir.php#110489 nbari at dalmp dot com
 * @param type $dir
 * @return type
 */
function treermdir($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? treermdir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
?>