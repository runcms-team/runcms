<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeThumbnailFrame($name){
      global $galerieConfig;
    $img_size = GetImageSize($name);
      $img_width = $img_size[0];
      $img_height = $img_size[1];
    $frame_w=round($img_width * $galerieConfig['ppm_tnheight'] / $img_height);
    echo "<iframe name='Thumbnail' src='".RCX_URL."/modules/galleri/include/thframe.php?name=".$name."&jpegcomp=".$galerieConfig['ppm_jpegcomp']."&tn_height=".$galerieConfig['ppm_tnheight']."&gd2=".$galerieConfig['gd2']."&gif_ok=".$galerieConfig['gif_ok']."' marginwidth='0' marginheight='0' height='".$galerieConfig['ppm_tnheight']."' width='".$frame_w."' scrolling='no' align='middle' border='0' frameborder='0'></iframe>";
    }

?>
