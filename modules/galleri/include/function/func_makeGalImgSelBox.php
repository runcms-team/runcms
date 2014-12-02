<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeGalImgSelBox($cat_sel, $img_sel){
      global $db;
      
      $result = $db->query("SELECT count(*) FROM ".$db->prefix("galli_img")." WHERE cname='$cat_sel' and free=1 ORDER BY img");
      list($numrows)=$db->fetch_row($result);
        echo "<select name='img'>\n";
        if ($numrows>0) {
        $result = $db->query("SELECT id, img FROM ".$db->prefix("galli_img")." WHERE cname='$cat_sel' and free=1 ORDER BY img");
            while ( list($id, $img) = $db->fetch_row($result) ) {
            if($img == $img_sel) {
              echo "<option value='$img' selected='selected'>$img</option>\n";
            }else{
              echo "<option value='$img'>$img</option>\n";
            }
            }
      }else{
        echo "<option value='' selected='selected'>"._AD_MA_NOIMG."</option>\n";
      }
        echo "</select>\n";
    }

?>
