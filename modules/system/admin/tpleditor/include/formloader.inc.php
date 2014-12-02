<?php 
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/ 
if (!defined("_FORMLOADER_INCLUDED")) {
    define("_FORMLOADER_INCLUDED", 1);

    include_once(RCX_ROOT_PATH . "/class/form/formlabel.php");
    include_once(RCX_ROOT_PATH . "/class/form/formelementtray.php");
    include_once(RCX_ROOT_PATH . "/class/form/formtext.php");
    include_once(RCX_ROOT_PATH . "/class/form/formhidden.php");
    include_once(RCX_ROOT_PATH . "/class/form/formtextarea.php");
    include_once(RCX_ROOT_PATH . "/class/form/formselect.php");
    include_once(RCX_ROOT_PATH . "/class/form/formfile.php");
    include_once(RCX_ROOT_PATH . "/class/form/formcheckbox.php");
    include_once(RCX_ROOT_PATH . "/class/form/formbutton.php");
	
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/class/form_class/themeform.php");
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/class/form_class/formheadingrow.php");
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/class/form_class/formcolortray.php");
} 

?>
