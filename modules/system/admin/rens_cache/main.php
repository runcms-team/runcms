<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

//error_reporting (E_ALL);
if (!preg_match("/admin\.php/i", $_SERVER['PHP_SELF']))
    exit();

include(RCX_ROOT_PATH."/mainfile.php");
include(RCX_ROOT_PATH."/include/cp_functions.php");
include_once(RCX_ROOT_PATH."/class/rcxmodule.php");
include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
rcx_cp_header();
OpenTable();	
echo "<br /><br />\n";
define('_HTTP', getenv('HTTP'));
// Detect platform
switch(strtoupper(PHP_OS)) {
  case 'WINDOWS':
  case 'CYGWIN':
  case 'WINNT':
  case 'WIN32':
    define('_OS', 'W');

	  chdir(RCX_ROOT_PATH."/cache/sql");
     //system("del  *.php");
     $GLOBALS['db']->clear_cache();
    break;

  case 'DARWIN':
  case 'OSX':
    define('_OS', 'M');
    break;

  default:
    define('_OS', 'U');
  chdir(RCX_ROOT_PATH."/cache/sql");
//system("rm -rf -- .php *");
$GLOBALS['db']->clear_cache();
}
echo" <center><table border='0'><tr><td width='325px'>";
echo "<br>"._MD_AM_RENSETCACHE."<br>";
 $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( "<b>"._MD_AM_MAINRETURN."</b>" , "button", " - MENU - "  , "button");
         $retur_button->setExtra("onClick=\"location='admin.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
echo" </td></tr></table></center>";
CloseTable();
rcx_cp_footer();
?>