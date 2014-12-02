<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
// Welcome Screen
define("_INSTALL_W_WELCOME"   , "Welcome to the Setup Wizard for %s");
define("_INSTALL_W_CHOOSE"    , "Please choose the action you wish to perfom:");
define("_INSTALL_W_CHOOSELANG", "Please choose the language to be used for the installation process");
define("_INSTALL_W"    , "Install ---->:");

// Server Tests
define("_INSTALL_ST_TESTS"       , "These are the results after testing your server:");
define("_INSTALL_ST_MAINFILE_OK" , "<b>OK</b> :: Your mainfile.php is writable..");
define("_INSTALL_ST_MAINFILE_BAD", "<b><i>ERROR</i></b> :: mainfile.php in your root folder needs to be chmodded to (0666 Unix / read-write Win32) before continuing..");
define("_INSTALL_ST_MYSQL_OK"    , "<b>OK</b> :: Your mysql version is %s, which is sufficient..");
define("_INSTALL_ST_MYSQL_BAD"   , "<b>ERROR</b> :: Your mysql version is %s, which is not high enough to run correct ..");
define("_INSTALL_ST_MYSQL_BAD2"  , "Could not determine your mysql version, MySQL 4.1.20 minimum is required.");
define("_INSTALL_ST_GLOBALS_OK"  , "<b>OK</b> :: Register Globals are ON..");
define("_INSTALL_ST_GLOBALS_BAD" , "<b>OK</b> :: Register Globals are OFF..");
define("_INSTALL_ST_PHP_OK"      , "<b>OK</b> :: Your PHP version is %s, which is sufficient..");
define("_INSTALL_ST_PHP_BAD"     , "<b><i>ERROR</i></b> :: You only have version %s of PHP. You need a higher version to run correct");
define("_INSTALL_ST_NEXT"        , "If the above results are positive, then continue..");
define("_INSTALL_PHPINFO"        , "<b>PHP-INFO</b>");

// DBFORM
define("_INSTALL_DF_DB"          ,"Database");
define("_INSTALL_DF_DB1"         ,"Choose the type of database to be used.");
define("_INSTALL_DF_HOST"        ,"Database Hostname");
define("_INSTALL_DF_HOST1"       ,"Hostname of the database server. ( If you are unsure, 'localhost' works in most cases. )");
define("_INSTALL_DF_UNAME"       ,"Database Username");
define("_INSTALL_DF_UNAME1"      ,"Your database user account on the host. ( Often root when installed on your local machine. )");
define("_INSTALL_DF_PASS"        ,"Database Password");
define("_INSTALL_DF_PASS1"       ,"Password for your database user account.");
define("_INSTALL_DF_DBNAME"      ,"Database Name");
define("_INSTALL_DF_DBNAME1"     ,"The name of database on the host. The installer will attempt to create the database if not exist.");
define("_INSTALL_DF_PREFIX"      ,"Table Prefix");
define("_INSTALL_DF_PREFIX1"     ,"This Præfix are createt randomize it can replace with one createt by ourself but are not recommanded!.<br />Prefix are added to all new tables created to avoid name conflict in the database.");
define("_INSTALL_DF_PCONNECT"    ,"Use persistent connection?");
define("_INSTALL_DF_PCONNECT1"   ,"Default is 'No'. Choose 'No' if you are unsure.");
define("_INSTALL_DF_PATH"        ,"Physical Path");
define("_INSTALL_DF_PATH1"       ,"Physical path to your main RUNCMS directory WITHOUT trailing slash. ( On windows use simple forward slashes & be sure to include the drive letter. c:/myfolder )");
define("_INSTALL_DF_URL"         ,"Virtual Path (URL)");
define("_INSTALL_DF_URL1"        ,"Virtual path to your main RUNCMS directory WITHOUT trailing slash. ( http://www.mysite.com/myfolder )");
define("_INSTALL_DF_PLEASE_ENTER","Please enter a valid %s");
define("_INSTALL_DF_ERRORS"      , "Encountered the following errors:");
define("_INSTALL_DF_BADROOT"     , "The physical path you specified doesnt seem to exist.");
define("_INSTALL_DF_BADDB"       , "Cannot connect to or create the database with the information you specified.");
define("_INSTALL_DF_OK"          , "All seems to be ok, continue to save your configuration.");
define("_INSTALL_LANG"           , "Default setup language.");


// Mainfile setup
define("_INSTALL_MF_FAILOPEN" ,"Could not open mainfile.php. Please check the file permission and try again.");
define("_INSTALL_MF_FAILWRITE","Could not write to mainfile.php. Contact the server administrator for details.");
define("_INSTALL_MF_WRITEOK"  ,"Configuration data has been saved successfully.");

// Admin Setup
define("_INSTALL_AD_MSG"     , "Now were ready to setup your admin account:");
define("_INSTALL_AD_UNAME"   , "User Name:");
define("_INSTALL_AD_EMAIL"   , "Admin Email:");
define("_INSTALL_AD_PASS"    , "Password:");
define("_INSTALL_AD_BADPASS" , "Please enter a password bigger than %s characters big");
define("_INSTALL_AD_BADUNAME", "Only use alphanumerical characters  in you name without spaces");
define("_INSTALL_AD_BADEMAIL", "That doesnt seem to be a valid email format.");

// DB CREATION
define("_INSTALL_DB_DBERROR" , "Database table creation failed. Tables where removed.");
define("_INSTALL_DB_TRYAGAIN", "Click <a href='%s'>here</a> to try again with step one.");

// Finish
define("_INSTALL_F_CONGRAT" , "Congratulations, RUNCMS is now installed");
define("_INSTALL_F_CHMOD"   , "Be sure to chmod files below to their proper values:");
define("_INSTALL_F_CHMODMSG", "If you have access to your servers command line, then you may also want download a chmod script for your operating system. Simply save it to your disk & run it from the command line");
define("_INSTALL_F_VISIT"   , "You may visit your site by clicking <a href='%s/'>here</a>");

// Some general stuff
define("_INSTALL_G_TITLE" , "Installation");
define("_INSTALL_U_CHOOSE", "Please choose a upgrade package:");
define("_INSTALL_U_NOTE"  , "NOTE: Your old mainfile.php must already be in place & contain the right information.");
define("_INSTALL_U_README", "Click <a href='%s' target='_blank'>here</a> to see the <b>README</b> for more information.");



// index.php //
define("_MI_DOCHMOD_TEXT", "Fill out the form with your FTP access info to your server,<br> to CHMOD your new site automatically,<br>PHP will CHMOD the needed files for you and save you the work:");
define("_MI_DOCHMOD_MANUAL", "You can also use your FTP client if you rather do it manual,<br>below you can see the list of files to CHMOD and CHMOD value they must have.<br> Connect with your FTP client to the site and set correct CHMODs<br> renew the list regularly so you can see what you're missing.<br>When everything is ok there would be a link that allows you to close in to your new site!");
define("_MI_DOCHMOD_FTPDOMAIN","Domain on FTP acces(f.x: ftp.yoursite.com)");
define("_MI_DOCHMOD_FTPUSER","Username :");
define("_MI_DOCHMOD_FTPPASS","Password :");
define("_MI_DOCHMOD_FTPPATH","FTP Folder in wich mainfile.php are (f.x: httpdocs/ , domainname/, /,  ...)");
define("_MI_DOCHMOD_BUTTON","Login");
define("_MI_DOCHMOD_BROWSETOMAINFILE","Browse to the folder in wich your mainfile.php are");
define("_MI_DOCHMOD_HASMAINFILEPHP"," You have found the mainfile.php file, shall we start to CHMOD?");
define("_MI_DOCHMOD_ERRORS"," %s  error.");
define("_MI_DOCHMOD_COMPLETE","Installationen CHMOD list are Complet:");
define("_MI_DOCHMOD_TITLEERROR", "<b>ERROR!</b>");
define("_MI_DOCHMOD_CONNERROR1","There was a error and the connection failed failed. Try to connect on");
define("_MI_DOCHMOD_CONNERROR2","With Username");
define("_MI_DOCHMOD_CONNERROR3","BACK");
define("_MI_DOCHMOD_CONNERROR4","FTP path ERROR! mainfile.php does not exist in this path!.");
define("_MI_DOCHMOD_OKTITLE","<b>That's all!</b>");
define("_MI_DOCHMOD_OKDESCRIPTION","REMEMBER TO ENSURE YOUR SITE TO DELETE  _install director.");
define("_FILEMISSINGUPLOADTHISAGAIN","Missing a file, upload this again.");

?>
