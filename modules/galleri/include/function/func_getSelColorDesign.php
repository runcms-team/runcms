<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function getSelColorDesign($name3, $sel){
      $colorarray = array("00", "33", "66", "99", "CC", "FF");
      echo "<select name='".$name3."'>\n";
      foreach ( $colorarray as $color1 ) {
        foreach ( $colorarray as $color2 ) {
          foreach ( $colorarray as $color3 ) {
            if ( $color1.$color2.$color3 == $sel ){
              echo "<option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";' selected='selected'>#".$color1.$color2.$color3."</option>\n";
            }else{
              echo "<option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";'>#".$color1.$color2.$color3."</option>\n";
            }
          }
        }
      }
      echo "</select>\n";
    }

?>