<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function getColorArray(){
      $colorarray = array("00", "33", "66", "99", "CC", "FF");
        $ret = array();
        foreach ($colorarray as $color1) {
          foreach ($colorarray as $color2) {
            foreach ($colorarray as $color3) {
              array_push($ret, $color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";" =>"#".$color1.$color2.$color3);
            }
          }
        }
        return $ret;
    }
    
    
?>