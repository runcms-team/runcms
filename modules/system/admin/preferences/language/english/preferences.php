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
?>
