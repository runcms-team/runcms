<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function admin_meldung($meldung, $f_class="fg5", $t_form="center"){
        gall_cp_header();
        OpenTable();
      echo "<br><table border='1'  cellspacing='0' cellpadding='5' width='90%'  align='center'><tr><td align='".$t_form."'>";
      echo "<br><font class='".$f_class."'>".$meldung."</font><br><br>";
      echo "</td></tr></table><br>";  
        CloseTable();
        gall_cp_footer();
    }
?>
