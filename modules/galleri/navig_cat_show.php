<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    $sql = "SELECT * FROM ".$db->prefix("galli_img")." WHERE free >= 1 and cid=".$cid;    
    $nav_result = $db->query($sql);
    $x=1;
    $menge = $db->num_rows($nav_result);
    while ($val = $db->fetch_array($nav_result)) {
      $bild[$x]["files"] = $val['img'];
      $bild[$x]["id"] = $val['id'];
      $y = $x;
      $x++;
      }
    for ($x=1;$x<($y+1);$x++){
      if ($bild[$x]["files"] == $img_Dat->img()){
        $aktuell = $x;
        $id_ret = $bild[$x-1]["id"];
        $id_next = $bild[$x+1]["id"];
      }
    }
    echo "<form method=post action=index.php>";
    echo "<table width='100%' border='0' cellspacing='0'>";
    echo "<tr><td align='center' width='33%'>";
    if ($aktuell > 1){
      echo "<input type='button' class='button' value='  <<  ' onClick=\"location='viewcat.php?id=$id_ret&cid=$cid&min=$min&orderby=$orderby&show=$show'\"></td>";
    }else{
      echo "&nbsp;</td>";
    } 
    echo "<td align='center' width='33%'><input type='button' class='button' value='"._MD_MAIN."' onClick=\"location='viewcat.php?cid=$cid&min=$min&orderby=$orderby&show=$show'\"></td>";
    echo "<td align='center' width='33%'>";
    if ($aktuell < $menge){
      echo "<input type='button' class='button' value='  >>  ' onClick=\"location='viewcat.php?id=$id_next&cid=$cid&min=$min&orderby=$orderby&show=$show'\"></td>";
    }else{
      echo "&nbsp;</td>";
    }
    echo "</table></form>";

?>