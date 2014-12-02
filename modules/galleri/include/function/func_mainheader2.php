<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function mainheader2() {
      global $galerieConfig, $meta;
      echo "<p><br><div align='center'>"; 
    if ( ($galerieConfig['titelimg_yes_no'] == 1) && @is_file("".IMG_PATH."/title_logo/".$galerieConfig['titelimg']."")){
      echo "<a href='".GALL_URL."/index.php'><img src='".IMG_URL."/title_logo/".$galerieConfig['titelimg']."' border='0' alt='"._WELCOM." ".$meta['title']."' /></a>";
    }else{
      echo "<h5>"._WELCOM."".$meta['title']."</h5>";    
    }
      echo "</div></p>";
    }
?>
