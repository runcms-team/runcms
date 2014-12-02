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
include_once(RCX_ROOT_PATH.'/include/cp_functions.php');

if ( $rcxUser ) {
  $rcxModule = RcxModule::getByDirname('partners');
  if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
    redirect_header(RCX_URL.'/', 3, _NOPERM);
    exit();
    }
  } else {
    redirect_header(RCX_URL.'/', 3, _NOPERM);
    exit();
  }

if (@file_exists('../language/'.RC_ULANG.'/admin.php'))
  include_once('../language/'.RC_ULANG.'/admin.php');
else
  include_once('../language/english/admin.php');
?>
