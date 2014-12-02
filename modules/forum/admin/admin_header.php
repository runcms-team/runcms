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
include_once('../config.php');
include_once('../cache/config.php');
include_once('../functions.php');

include_once(RCX_ROOT_PATH.'/class/rcxlists.php');
include_once(RCX_ROOT_PATH.'/include/cp_functions.php');
include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');

if ( $rcxUser ) {
        $rcxModule = RcxModule::getByDirname('forum');
        if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
                redirect_header(RCX_URL.'/', 3, _NOPERM);
                exit();
        }
        } else {
                redirect_header(RCX_URL.'/', 3, _NOPERM);
                exit();
        }

if ( @file_exists('../language/'.$rcxConfig['language'].'/admin.php') ) {
        include_once('../language/'.$rcxConfig['language'].'/admin.php');
        } else {
                include_once('../language/english/admin.php');
        }

if ( @file_exists('../language/'.$rcxConfig['language'].'/main.php') ) {
        include_once('../language/'.$rcxConfig['language'].'/main.php');
        } else {
                include_once('../language/english/main.php');
        }

rcx_cp_header();
OpenTable();
?>