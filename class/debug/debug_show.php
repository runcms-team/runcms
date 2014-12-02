<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("../../mainfile.php");
include_once("../../header.php");

global $rcxUser;

if( $rcxUser && $rcxUser->isAdmin() )
{{
   switch($_POST['debug_show']) 
   {
     case "show_files":
       show_files($_POST['loaded_files']);
     break;

     case "show_queries":
       show_queries($_POST['executed_queries'], $_POST['sorted']);
       break;
   }
}
} else {
		redirect_header(RCX_URL.'/', 0, _NOPERM);
    exit();
  }
include_once("../../footer.php");
?>
