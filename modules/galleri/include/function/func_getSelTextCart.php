<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function getSelTextCart($name1,$name2,$name3,$bg_class){
      $sizearray = array("xx-small", "x-small", "small", "medium", "large", "x-large", "xx-large");
      echo "<select name='".$name1."' onchange='setVisible(\"hiddenText\");setElementSize(\"hiddenText\",this.options[this.selectedIndex].value);'>\n";
      echo "<option value='SIZE'>"._SIZE."</option>\n";
      foreach ( $sizearray as $size ) {
        echo "<option value='$size'>$size</option>\n";
      }
      echo "</select>\n";
    
      $fontarray = array("Arial", "Courier", "Georgia", "Helvetica", "Impact", "Verdana");
      echo "<select name='".$name2."' onchange='setVisible(\"hiddenText\");setElementFont(\"hiddenText\",this.options[this.selectedIndex].value);'>\n";
      echo "<option value='FONT'>"._FONT."</option>\n";
      foreach ( $fontarray as $font ) {
        echo "<option value='$font'>$font</option>\n";
      }
      echo "</select>\n";
    
      $colorarray = array("00", "33", "66", "99", "CC", "FF");
      echo "<select name='".$name3."' onchange='setVisible(\"hiddenText\");setElementColor(\"hiddenText\",this.options[this.selectedIndex].value);'>\n";
      echo "<option value='COLOR'>"._COLOR."</option>\n";
      foreach ( $colorarray as $color1 ) {
        foreach ( $colorarray as $color2 ) {
          foreach ( $colorarray as $color3 ) {
            echo "<option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";'>#".$color1.$color2.$color3."</option>\n";
          }
        }
      }
      echo "</select></td><td width='50%' class='".$bg_class."'><center><span id='hiddenText'>"._EXAMPLE."</span></center>\n";
    }

?>
