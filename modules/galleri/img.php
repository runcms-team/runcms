<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

  include("../../mainfile.php");
  if( !eregi(  RCX_URL, $HTTP_REFERER) || $image == 0) {
    echo "<table height='100%' width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='middle'><tr>";
    echo "<td align='center'><font size='2' color='#ff0000'><b>Selbst fotografieren macht Spass<br><br>(c) by ".RCX_URL."</b></font></td></tr></table>";
  }else{
    $result = $db->query("SELECT cname, img FROM ".$db->prefix("galli_img")." WHERE id=".$image."");
    list($cname, $img)=$db->fetch_row($db->query("SELECT cname, img FROM ".$db->prefix("galli_img")." WHERE id=".$image.""));
    $img_file = RCX_ROOT_PATH."/modules/galleri/galerie/".$cname."/".$img;
    if(@file_exists($img_file)){    
      $size = @getimagesize($img_file);
      echo "<table border='0' cellspacing='0' cellpadding='0'><tr>";
      echo "<td style='background-image:url(".RCX_URL."/modules/galleri/galerie/".$cname."/".$img.")'>";
      echo "<img src='".RCX_URL."/modules/galleri/images/blank.gif' ".$size[3]." border='0'>";
      echo "</td></tr></table>";
    }else{
      echo "Image not present";
    }
  }
?>

