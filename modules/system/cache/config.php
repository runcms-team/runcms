<?php
/*********************************************************************
Remember to chmod 666 this file in order to let the system write to it properly.
If you can't change the permissions you can edit the rest of this file by hand.
*********************************************************************/

// Admin mail address
$rcxConfig['adminmail'] = "admin@mysite.com";

// Default mail function
$rcxConfig['mail_function'] = "mail";

// How Much PM's Send At Once Before Pause:
$rcxConfig['pm_atonce'] = "300";

// How Much Email's Send At Once Before Pause:
$rcxConfig['ml_atonce'] = "20";

// Pause After Mail's/PM's Packet Will Be Send (sec.):
$rcxConfig['send_pause'] = "1";

// SMTP Host:
$rcxConfig['smtp_host'] = "localhost";

// SMTP User Name:
$rcxConfig['smtp_uname'] = "";

// SMTP Password:
$rcxConfig['smtp_pass'] = "";

// Default language
$rcxConfig['language'] = "russian";

// Module for your start page
$rcxConfig['startpage'] = "news";

// Default theme
$rcxConfig['default_theme'] = "runcms2";

// Allow users to select theme? (1=Yes 0=No)
$rcxConfig['allow_theme'] = 0;

// Username for anonymous users
$rcxConfig['anonymous'] = "Anonyme";

// Minimum length of password required
$rcxConfig['minpass'] = 5;

// Allow anonymous users to post comments? (1=Yes 0=No)
$rcxConfig['anonpost'] = 0;

// Maximum inbox pm per/user. 0=No Limit
$rcxConfig['max_pms'] = 100;

// Allow HTML tags in user comments? (1=Yes 0=No)
$rcxConfig['allow_html'] = 0;

// Allow users to use library images in posts? (1=Yes 0=No)
$rcxConfig['allow_library'] = 0;

// Allow users to upload images to the library? (1=Yes 0=No)
$rcxConfig['lib_allow_upload'] = 0;

// Library image max width
$rcxConfig['lib_width'] = 140;

// Library image max height
$rcxConfig['lib_height'] = 140;

// Library image max filesize (bytes)
$rcxConfig['lib_maxsize'] = 3072;

// Allow users to display external images in posts, comments, & signatures? (1=Yes 0=No)
$rcxConfig['allow_image'] = 0;

// Allow new users to register on your site? (1=Yes 0=No)
$rcxConfig['allow_register'] = 1;

// Verify for manual signups? Requires GD! (1=Yes 0=No)
$rcxConfig['img_verify'] = 1;

// Automaticly activate new users on signup? (1=Yes 0=No)
$rcxConfig['auto_register'] = 0;

// Notify by mail when a new user is registered? (1=Yes 0=No)
$rcxConfig['new_user_notify'] = 1;

// Notify to group:
$rcxConfig['new_user_notify_group'] = 1;

// Allow users to delete own account? (1=Yes 0=No)
$rcxConfig['self_delete'] = 0;

// Display loading.. image? (1=Yes 0=No)
$rcxConfig['display_loading_img'] = 0;

// Use gzip compression? PHP version 4.0.5 or higher recommended. Your server version is 5.2.9 (1=Yes 0=No)
$rcxConfig['gzip_compression'] = 1;

// How strict should the allowed chars for username be?  (Strict (only alphabets and numbers)=0 Medium=1 Light (recommended for multi-byte chars)=2)
$rcxConfig['uname_test_level'] = 0;

// Name for user cookies. This cookie contains only a user name and is saved in a user pc for a year (if the user wishes). If a user have this cookie, username will be automatically inserted in the login box.
$rcxConfig['cookie_name'] = "rc2_user";

// Name for sessions. Enables a user to stay logged in untill the session expires or the user logs out.
$rcxConfig['session_name'] = "rc2_sess";

// Maximum duration of session idle time in seconds before user gets logged out automaticly.
$rcxConfig['session_expire'] = 2678400;

// Use php sessions instead of cookie sessions for logging in?
$rcxConfig['use_sessions'] = 0;

// Server timezone
$rcxConfig['server_TZ'] = "2";

// Default timezone
$rcxConfig['default_TZ'] = "1";

// Activate banner ads? (1=Yes 0=No)
$rcxConfig['banners'] = 1;

// Debug Level: Sets verbose level of debug mode.
$rcxConfig['debug_mode'] = 1;

// Time in minutes that site pages are cached, if at all.
$rcxConfig['cache_time'] = 0;

// Default Comment Display Mode (0=No Comments flat=Flat thread=Threaded)
$rcxConfig['com_mode'] = "flat";

// Default Comments Display Order (0=Oldest First 1=Newest First)
$rcxConfig['com_order'] = 0;

// Allow custom avatar upload? (1=Yes 0=No)
$rcxConfig['avatar_allow_upload'] = 0;

// Avatar image max width
$rcxConfig['avatar_width'] = 75;

// Avatar image max height
$rcxConfig['avatar_height'] = 100;

// Avatar image max filesize (bytes)
$rcxConfig['avatar_maxsize'] = 4000;

// HTML tags which admins are allowed to use in posts (where applies).
$rcxConfig['admin_html'] = "a|abbr|acronym|address|applet|area|b|bdo|big|blockquote|br|button|caption|center|cite|code|col|colgroup|dd|del|dfn|dir|div|dl|dt|em|embed|fieldset|font|form|frameset|h1|h2|h3|h4|h5|h6|hr|i|iframe|img|input|ins|kbd|label|legend|li|map|menu|noscript|object|ol|optgroup|option|p|param|pre|q|s|samp|script|select|small|span|strike|strong|sub|sup|table|tbody|td|textarea|tfoot|th|thead|tr|tt|u|ul|var";

// HTML tags which users are allowed to use in posts (where applies).
$rcxConfig['user_html'] = "br";

// Maintenance Mode
$rcxConfig['maintenance'] = 0;

?>