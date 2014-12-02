<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeZahlSelBox($name, $anfang, $ende, $sel_zahl){
      echo "<select name='".$name."'>\n";
        for($x=$anfang;$x<$ende+1;$x++){
            if($x == $sel_zahl) {
              echo "<option value='$x' selected='selected'>$x</option>\n";
            }else{
              echo "<option value='$x'>$x</option>\n";
            }
        }
          echo "</select>\n";
    }

?>