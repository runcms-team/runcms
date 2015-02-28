<?php

//%%%%%%  Admin Module Name  AdminGroup   %%%%%
define("_MD_AM_SITEPREF","Site Preferences");
define("_MD_AM_SITENAME","Site name");
define("_MD_AM_ADMINML","Admin mail address");
define("_MD_AM_MAILFUNC","Default mail function");
define("_MD_AM_LANGUAGE","Default language");
define("_MD_AM_STARTPAGE","Module for your start page");
define("_MD_AM_SERVERTZ","Server timezone");
define("_MD_AM_DEFAULTTZ","Default timezone");
define("_MD_AM_DTHEME","Default theme");
define("_MD_AM_ANONNAME","Username for anonymous users");
define("_MD_AM_ANONPOST","Allow anonymous users to post comments?");
define("_MD_AM_MAXPMS","Maximum inbox pm per/user. 0=No Limit");
define("_MD_AM_MINPASS","Minimum length of password required");
define("_MD_AM_NEWUNOTIFY","Notify by mail when a new user is registered?");
define("_MD_AM_SELFDELETE","Allow users to delete own account?");
define("_MD_AM_LOADINGIMG","Display loading.. image?");
define("_MD_AM_USEGZIP","Use gzip compression? PHP version 4.0.5 or higher recommended. Your server version is %s");
define("_MD_AM_UNAMELVL","How strict should the allowed chars for username be?");
define("_MD_AM_STRICT","Strict (only alphabets and numbers)");
define("_MD_AM_MEDIUM","Medium");
define("_MD_AM_LIGHT","Light (recommended for multi-byte chars)");
define("_MD_AM_USERCOOKIE","Name for user cookies. This cookie contains only a user name and is saved in a user pc for a year (if the user wishes). If a user have this cookie, username will be automatically inserted in the login box.");
define("_MD_AM_SESSCOOKIE","Name for sessions. Enables a user to stay logged in untill the session expires or the user logs out.");
define("_MD_AM_SESSEXPIRE","Maximum duration of session idle time in seconds before user gets logged out automaticly.");
define("_MD_AM_SESSUSE","Use php sessions instead of cookie sessions for logging in?");
define("_MD_AM_BANNERS","Activate banner ads?");

define("_MD_AM_DEFHTML","HTML tags which admins & users are allowed to use in various parts of the site: (where applies)");
define("_MD_AM_ADMHTML","HTML tags which admins are allowed to use in posts (where applies).");
define("_MD_AM_ADMTAGS","Admin Tags:");
define("_MD_AM_USRHTML","HTML tags which users are allowed to use in posts (where applies).");
define("_MD_AM_USRTAGS","User Tags:");

define("_MD_AM_INVLDMINPASS","Invalid value for minimum length of password.");
define("_MD_AM_INVLDUCOOK","Invalid value for cookie_name.");
define("_MD_AM_INVLDSCOOK","Invalid value for session_name.");
define("_MD_AM_INVLDSEXP","Invalid value for session expiration time.");
define("_MD_AM_ADMNOTSET","Admin mail is not set.");
define("_MD_AM_DONTCHNG","Don't change!");
define("_MD_AM_REMEMBER","Remember to chmod 666 this file in order to let the system write to it properly.");
define("_MD_AM_IFUCANT","If you can't change the permissions you can edit the rest of this file by hand.");


define("_MD_AM_COMMODE","Default Comment Display Mode");
define("_MD_AM_COMORDER","Default Comments Display Order");
define("_MD_AM_ALLOWHTML","Allow HTML tags in user comments?");

define("_MD_AM_ALLOW_REGISTER", "Allow new users to register on your site?");
define("_MD_AM_VERIFY_IMG", "Verify for manual signups? Requires GD!");
define("_MD_AM_AUTOREGISTER","Automaticly activate new users on signup?");

define("_MD_AM_DEBUGMODE","Debug Level: Sets verbose level of debug mode.");
define("_MD_AM_DBGERR","Errors");
define("_MD_AM_DBGTIME","Timing");
define("_MD_AM_DBGINFO","Info");
define("_MD_AM_DBGLOG","Info & Log");
define("_MD_AM_DBGVIS","Visual");

define("_MD_AM_CACHETIME","Time in minutes that site pages are cached, if at all.");
define("_MD_AM_INVLDMAILFUNC", "Warning, %s() does not seem to exist!");
define("_MD_AM_AVATARALLOW","Allow custom avatar upload?");
define("_MD_AM_AVATARW","Avatar image max width");
define("_MD_AM_AVATARH","Avatar image max height");
define("_MD_AM_AVATARMAX","Avatar image max filesize (bytes)");
define("_MD_AM_AVATARCONF","Custom avatar settings");
define("_MD_AM_CHNGUTHEME","Change all users themes");
define("_MD_AM_NOTIFYTO","Notify to group:");
define("_MD_AM_ALLOWTHEME","Allow users to select theme?");
define("_MD_AM_ALLOWIMAGE","Allow users to display external images in posts, comments, & signatures?");

define("_MD_AM_LIBCONF","Image library settings:");
define("_MD_AM_LIBUSE","Allow users to use library images in posts?");
define("_MD_AM_LIBUPLOAD","Allow users to upload images to the library?");
define("_MD_AM_LIBW","Library image max width");
define("_MD_AM_LIBH","Library image max height");
define("_MD_AM_LIBMAX","Library image max filesize (bytes)");
define("_MD_AM_MAINTENANCE","Maintenance Mode");
// SMTP addon by SVL
define("_MD_AM_PMATONCE","How many PM's Send At Once Before Pause:");
define("_MD_AM_MLATONCE","How many Email's Send At Once Before Pause:");
define("_MD_AM_SLEEP","Pause after Mail's/PM's packet will be send (sec.):");
define("_MD_AM_SMTPH","SMTP Host:");
define("_MD_AM_SMTPU","SMTP User Name:");
define("_MD_AM_SMTPP","SMTP Password:");

/**
 * @since 2.2.3.0
 */
define("_MD_AM_CLICKABLE", "Enable automatic conversion of the URL in the HTML link");
define("_MD_AM_SITE_SETTINGS", "Site settings");
define("_MD_AM_MAIL_SETTINGS", "Mail settings");
define("_MD_AM_USER_SETTINGS", "User settings");
define("_MD_AM_REGISTER_SETTING", "Registration settings");
define("_MD_AM_AUTH_SETTINGS", "Authentication settings");
define("_MD_AM_COMMENT_SETTINGS", "Settings comments");
define("_MD_AM_LIB_SETTINGS", "Settings Image Library");
define("_MD_AM_TEXT_PROCESSING", "Text processing");
define("_MD_AM_USE_AUTH_ADMIN", "Include individual authorization for the administrator");
define("_MD_AM_HIDE_EXTERNAL_LINKS", "Hide external links (using a redirect)");
define("_MD_AM_COOKIE_HTTPONLY", "Set access to the cookies <u> Authentication </u> only using HTTP protocol");
define("_MD_AM_USE_ONLY_COOKIES", "Forbidden to use the session ID in the URL");
define("_MD_AM_BAN_PROFILE_VIEWER", "Deny access unregistered users to user profiles");
define("_MD_AM_NO_SMILE", "Disable smileys");
define("_MD_AM_NOBBCODE_USERSIG", "Disable BB-code in a user's signature");
define("_MD_USE_CAPTCHA_FOR_ADMIN", "Enable CAPTCHA on login to admin panel");
define("_MD_ADMIN_LOGIN_NOTIFY", "Send to e-mail notification of the administrator log into the admin panel");
define("_MD_CHECK_BRUTEFORCE_LOGIN", "Enable protection from password guessing authorization");
define("_MD_COUNT_FAILED_AUTH", "The number of failed login attempts");
define("_MD_FAILED_LOCK_TIME", "Time (min.), to which will be blocked by the visitor's IP.");
define("_MD_ADMIN_BRUTEFORCE_NOTIFY", "Send to e-mail notification of the administrator password guessing attempts.");
define("_MD_AM_USE_SESSION_REGENERATE_ID", "Activate change the session ID.");
define("_MD_AM_SESSION_REGENERATE_ID_LIFETIME", "The lifetime of the Session ID (in seconds)");
define("_MD_AM_SECURITY_SETTINGS", "Security settings");
define("_MD_AM_X_FRAME_OPTIONS", "Clickjacking Protection");
define("_MD_AM_X_XSS_PROTECTION", "Enable the built-in browser protection against XSS-attacks (only for Internet Explorer 8 and above)");
define("_MD_AM_X_CONTENT_TYP_OPTIONS_NOSNIFF", "Disable MIME sniffing in the browser (only for Internet Explorer 8 and above).");
define("_MD_AM_BD_SET_NAMES", "Set the encoding connection to the database server");
define("_MD_AM_BD_CHARSET_NAME", "Encoding to connect to the database server");
define("_MD_AM_CACHE_SETTINGS", "Cache settings");
define("_MD_AM_USE_HTTP_CACHING", "Enable HTTP caching");
define("_MD_AM_HTTP_CACHING_USER_AGENT", "USER AGENT enabled for HTTP caching");
define("_MD_AM_HTTP_CACHE_TIME", "Time HTTP caching pages (min).");
define("_MD_AM_NO_REDIRECT", "Disable redirect to the home page");
define("_MD_AM_SMTPPORT", "SMTP Port:");

?>