<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  function ppm_do_thumb($name,$filename,$new_h){
      global $gd2,$galerieConfig; 
    $file_info = pathinfo($name);
    $file_ext = $file_info["extension"];
    $file_ext = strtolower($file_ext);
    if ($file_ext == "jpg" || $file_ext == "jpeg") { $imgtype = 'JPEG'; $src_img = imagecreatefromjpeg($name);} 
    if ($file_ext == "png") {$imgtype = 'PNG'; $src_img = imagecreatefrompng($name);}
    if ($file_ext == "gif") {$imgtype = 'GIF'; $src_img = imagecreatefromgif($name);}
    if ($file_ext == "wbmp") {$imgtype = 'WBMP'; $src_img = imagecreatefromwbmp($name);}
    if ($src_img == ''){
      return $imgtype.' '.PPM_FORMATNOTSUPPORTED; 
    }else{
      $old_x=imageSX($src_img); 
        $old_y=imageSY($src_img); 
      $new_w=round($old_x * $new_h / $old_y);
      $thumb_w=$new_w; 
        $thumb_h=$new_h;
      if ($galerieConfig['gd2'] == 0){ 
            $dst_img=ImageCreate($thumb_w,$thumb_h); 
            imagecopyresized($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
        }else{ 
            $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h); 
            imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
        }
      if ($imgtype == "PNG"){ 
            imagepng($dst_img, $filename);
      }elseif ($imgtype == "GIF"){ 
            imagegif($dst_img, $filename);
      }elseif ($imgtype == "WBMP"){ 
            imagewbmp($dst_img, $filename); 
        }else{ 
            imagejpeg($dst_img, $filename, $galerieConfig['ppm_jpegcomp']);
        }
        imagedestroy($dst_img); 
        imagedestroy($src_img); 
      return 1;
    }
  }

?>
