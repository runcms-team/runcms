<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeImgCopyToImg($old_image, $save=0, $logo=""){
      global $galerieConfig;

      if ($logo == "../images/copyright/" || !@file_exists($logo)){
            $logo = "../images/watermark.jpg";
        }
      $file_info = pathinfo($logo);
      $file_ext = $file_info["extension"];
      $file_ext = strtolower($file_ext);
      if ($file_ext == "jpg" || $file_ext == "jpeg") {$logo = imagecreatefromjpeg($logo);} 
      if ($file_ext == "png") {$logo = imagecreatefrompng($logo);}
      if ($file_ext == "gif") {$logo = imagecreatefromgif($logo);}
      if ($file_ext == "wbmp") {$logo = imagecreatefromwbmp($logo);}
      $file_info = pathinfo($old_image);
      $file_ext = $file_info["extension"];
      $file_ext = strtolower($file_ext);
      if ($file_ext == "jpg" || $file_ext == "jpeg") { $imgtype = 'JPEG';$new_image = imagecreatefromjpeg($old_image);} 
      if ($file_ext == "png") {$imgtype = 'PNG';$new_image = imagecreatefrompng($old_image);}
      if ($file_ext == "gif") {$imgtype = 'GIF';$new_image = imagecreatefromgif($old_image);}
      if ($file_ext == "wbmp") {$imgtype = 'WBMP';$new_image = imagecreatefromwbmp($old_image);}
        $org_breite = imageSX($new_image);
        $org_hoehe = imageSY($new_image);
        $logo_breite = imageSX($logo);
        $logo_hoehe = imageSY($logo);
    if ($galerieConfig['test_wz_ob_un'] == 0){  
      if ($galerieConfig['test_wz_li_re'] == 0){  
        $start_li = 0;
        $start_ob = 0;
      }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
        $start_li = ($org_breite/2) - ($logo_breite/2);
        $start_ob = 0;
      }else{                    
        $start_li = $org_breite - $logo_breite;
        $start_ob = 0;
      }
    }elseif ($galerieConfig['test_wz_ob_un'] == 1){ 
      if ($galerieConfig['test_wz_li_re'] == 0){
        $start_li = 0;
        $start_ob = ($org_hoehe/2) - ($logo_hoehe/2);
      }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
        $start_li = ($org_breite/2) - ($logo_breite/2);
        $start_ob = ($org_hoehe/2) - ($logo_hoehe/2);
      }else{                    
        $start_li = $org_breite - $logo_breite;
        $start_ob = ($org_hoehe/2) - ($logo_hoehe/2);
      }
    }else{                      
      if ($galerieConfig['test_wz_li_re'] == 0){  
        $start_li = 0;
        $start_ob = $org_hoehe - $logo_hoehe;
      }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
        $start_li = ($org_breite/2) - ($logo_breite/2);
        $start_ob = $org_hoehe - $logo_hoehe;
      }else{                    
        $start_li = $org_breite - $logo_breite;
        $start_ob = $org_hoehe - $logo_hoehe;
      }
    }
        if ($galerieConfig['gd2'] == 1){
            imagecopyresampled($new_image, $logo, $start_li, $start_ob, 0, 0, $logo_breite, $logo_hoehe, $logo_breite, $logo_hoehe);
        }else{
            imagecopyresized($new_image, $logo, $start_li, $start_ob, 0, 0, $logo_breite, $logo_hoehe, $logo_breite, $logo_hoehe);
        }
      if ($save == 0){
        if ($imgtype == "PNG"){ 
          header("Content-Type: image/png");
              imagepng($new_image);
        }elseif ($imgtype == "GIF"){ 
          header("Content-Type: image/gif");
              imagegif($new_image);
        }elseif ($imgtype == "WBMP"){ 
          header("Content-Type: image/vnd.wap.wbmp");
              imagewbmp($new_image); 
          }else{ 
          header("Content-Type: image/jpeg");
              imagejpeg($new_image); 
          }
        imagedestroy($new_image); 
      }else{
        if ($imgtype == "PNG"){ 
              imagepng($new_image, $old_image);
        }elseif ($imgtype == "GIF"){ 
              imagegif($new_image, $old_image);
        }elseif ($imgtype == "WBMP"){ 
              imagewbmp($new_image, $old_image); 
          }else{ 
              imagejpeg($new_image, $old_image);
          }
        imagedestroy($new_image);
        return 1;
      }
    }
?>
