<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
	function checkgd(){
      $gd2 = "";
      ob_start();
      phpinfo(8);
      $phpinfo = ob_get_contents();
      ob_end_clean();
      $phpinfo = strip_tags($phpinfo);
      $phpinfo = stristr($phpinfo,"gd version");
      $phpinfo = stristr($phpinfo,"version");
      $end = strpos($phpinfo," ");
      $phpinfo = substr($phpinfo,0,25);
      $phpinfo = substr($phpinfo,7);
      if (stristr($phpinfo,"2.")){$gd2="yes";}
      return $gd2;
    }

?>
