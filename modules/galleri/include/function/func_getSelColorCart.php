<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function getSelColorCart($name3, $farbe){
      $colorarray = array("00", "33", "66", "99", "CC", "FF");
      echo "<select name='".$name3."'>\n";
      echo "<option value='".$farbe."'>"._COLOR."</option>\n";
      foreach ( $colorarray as $color1 ) {
        foreach ( $colorarray as $color2 ) {
          foreach ( $colorarray as $color3 ) {
            echo "<option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";'>#".$color1.$color2.$color3."</option>\n";
          }
        }
      }
      echo "</select>\n";
    }


?>
