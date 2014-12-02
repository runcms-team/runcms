<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    function gd_table(){
      ob_start();
      phpinfo();
      $phpinfo = ob_get_contents();
      ob_end_clean();
      $gdinfo = stristr($phpinfo,"module_gd");
        $gdinfo = stristr($gdinfo,"<table");
        $end = strpos($gdinfo, "<br");
        $gdinfo = substr($gdinfo,0,$end);
        $laenge = strlen($gdinfo);
        return $gdinfo;
    }
?>