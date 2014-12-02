<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
 if ($b == 1){
    echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
  }
  echo "<td width='".$br."%' align='center'>";
  $link = "<a href='".RCX_URL."/modules/galleri/viewcat.php?id=".$img_Dat->id()."&cid=$cid&min=$min&orderby=$orderby&show=$show'>";
  echo "<table width='100%' border='0' cellspacing='0' cellpadding='4'><tr><td align='center'>";
  if ($galerieConfig['safe_mode'] == 0){
        gall_function("makeRahmen", array($link, "./thumbnails/".$img_Dat->img(), "./thumbnails/".$img_Dat->img(), $alt));
  }else{
        gall_function("makeRahmenFrame", array("./thumbnails/".$img_Dat->img()), explode("|",$img_Dat->size()));
    }
  echo "</td></tr><tr><td align='center'>".$link."";
  if ($titre){echo $titre;}else{echo $img;}
  echo "</a></td></tr></table>";
  echo "</td>";
  if ($b == $galerieConfig['temp_haupt_width'] || $numrows == $min+$x+1 ){
    echo "</tr></table><br>";
    $b = 1;
  }else{
    $b++;
  }
?>