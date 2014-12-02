<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  include ("../../../mainfile.php");

    $system=explode(".",$name); 
    if (preg_match("/jpg|jpeg/",$system[1])){$imgtype = 'JPEG';$src_img=imagecreatefromjpeg($name);} 
    if (preg_match("/png/",$system[1])){$imgtype = 'PNG';$src_img=imagecreatefrompng($name);}
  if (preg_match("/wbmp/",$system[1])){$imgtype = 'WBMP';$src_img=imagecreatefromwbmp($name);}
  if (preg_match("/gif/",$system[1])){$imgtype = 'GIF';$src_img=imagecreatefromgif($name);}
  if ($src_img == ''){
    return $imgtype.' '.PPM_FORMATNOTSUPPORTED; 
  }else{
  
    $old_x=imageSX($src_img); 
      $old_y=imageSY($src_img); 
    $new_w=round($old_x * $tn_height / $old_y);
    $thumb_w=$new_w; 
      $thumb_h=$tn_height;
    if ($gd2 == 0){ 
          $dst_img=ImageCreate($thumb_w,$thumb_h); 
          imagecopyresized($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
      }else{ 
          $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h); 
          imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
      }
    if (preg_match("/png/",$system[1])){ 
      header("Content-Type: image/png");
          imagepng($dst_img);
    }elseif (preg_match("/gif/",$system[1])){ 
      header("Content-Type: image/gif");
          imagegif($dst_img);
    }elseif (preg_match("/wbmp/",$system[1])){ 
      header("Content-Type: image/vnd.wap.wbmp");
          imagewbmp($dst_img); 
      }else{ 
      header("Content-Type: image/jpeg");
          imagejpeg($dst_img,"",$jpegcomp); 
      } 
      imagedestroy($dst_img); 
      imagedestroy($src_img); 
    
  }
    
?>