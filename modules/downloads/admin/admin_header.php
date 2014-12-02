<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('../../../mainfile.php');
include_once('../include/functions.php');
include_once('../cache/config.php');
include_once(RCX_ROOT_PATH.'/class/xml-rss.php');
include_once(RCX_ROOT_PATH.'/class/rcxtree.php');
include_once(RCX_ROOT_PATH.'/class/fileupload.php');
include_once(RCX_ROOT_PATH.'/include/cp_functions.php');
include_once(RCX_ROOT_PATH.'/class/module.errorhandler.php');
include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');
if ($rcxUser) {
  $rcxModule = RcxModule::getByDirname('downloads');
  if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
    redirect_header(RCX_URL.'/', 3, _NOPERM);
    exit();
  }
  } else {
    redirect_header(RCX_URL.'/', 3, _NOPERM);
    exit();
  }
if (@file_exists('../language/'.RC_ULANG.'/main.php'))
  include_once('../language/'.RC_ULANG.'/main.php');
else
  include_once('../language/english/main.php');
?>
