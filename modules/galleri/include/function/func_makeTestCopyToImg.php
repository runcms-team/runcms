<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeTestCopyToImg($old_image, $save=0){
      global $galerieConfig;
      $len_text = strlen($galerieConfig['test_wz_text']);
      $file_info = pathinfo($old_image);
      $file_ext = $file_info["extension"];
      $file_ext = strtolower($file_ext);
      if ($file_ext == "jpg" || $file_ext == "jpeg") { $imgtype = 'JPEG';$new_image = imagecreatefromjpeg($old_image);} 
      if ($file_ext == "png") {$imgtype = 'PNG';$new_image = imagecreatefrompng($old_image);}
      if ($file_ext == "gif") {$imgtype = 'GIF';$new_image = imagecreatefromgif($old_image);}
      if ($file_ext == "wbmp") {$imgtype = 'WBMP';$new_image = imagecreatefromwbmp($old_image);}
      $image_x = imageSX($new_image); 
      $image_y = imageSY($new_image);
      
      if ($galerieConfig['test_wz_richtung'] == 0){   
        if ($galerieConfig['test_wz_ob_un'] == 0){  
          if ($galerieConfig['test_wz_li_re'] == 0){  
            $start_li = 30;
            $start_ob = 30;
          }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
            $start_li = ($image_x -($len_text*($galerieConfig['test_wz_font']+4)))/2;
            $start_ob = 30;
          }else{                    
            $start_li = $image_x -($len_text*($galerieConfig['test_wz_font']+4)+30);
            $start_ob = 30;
          }
        }elseif ($galerieConfig['test_wz_ob_un'] == 1){ 
          if ($galerieConfig['test_wz_li_re'] == 0){
            $start_li = 30;
            $start_ob = $image_y/2;
          }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
            $start_li = ($image_x -($len_text*($galerieConfig['test_wz_font']+4)))/2;
            $start_ob = $image_y/2;
          }else{                    
            $start_li = $image_x -($len_text*($galerieConfig['test_wz_font']+4)+30);
            $start_ob = $image_y/2;
          }
        }else{                      
          if ($galerieConfig['test_wz_li_re'] == 0){  
            $start_li = 30;
            $start_ob = $image_y-40;
          }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
            $start_li = ($image_x -($len_text*($galerieConfig['test_wz_font']+4)))/2;
            $start_ob = $image_y-40;
          }else{                    
            $start_li = $image_x -($len_text*($galerieConfig['test_wz_font']+4)+30);
            $start_ob = $image_y-40;
          }
        }
      }else{                        
        if ($galerieConfig['test_wz_ob_un'] == 0){  
          if ($galerieConfig['test_wz_li_re'] == 0){  
            $start_li = 30;
            $start_ob = $len_text*($galerieConfig['test_wz_font']+4)+30;
          }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
            $start_li = intval($image_x/2 - ($galerieConfig['test_wz_font']+4));
            $start_ob = $len_text*($galerieConfig['test_wz_font']+4)+30;
          }else{                    
            $start_li = $image_x-40;
            $start_ob = $len_text*($galerieConfig['test_wz_font']+4)+30;
          }
        }elseif ($galerieConfig['test_wz_ob_un'] == 1){ 
          if ($galerieConfig['test_wz_li_re'] == 0){
            $start_li = 30;
            $start_ob = $len_text*($galerieConfig['test_wz_font']+4)+30;
          }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
            $start_li = intval($image_x/2 - ($galerieConfig['test_wz_font']+4));
            $start_ob = ($image_y + $len_text*($galerieConfig['test_wz_font']+4))/2;
          }else{                  
            $start_li = $image_x-40;
            $start_ob = $len_text*($galerieConfig['test_wz_font']+4)+30;
          }
        }else{                      
          if ($galerieConfig['test_wz_li_re'] == 0){  
            $start_li = 30;
            $start_ob = $image_y-30;
          }elseif ($galerieConfig['test_wz_li_re'] == 1){ 
            $start_li = intval($image_x/2 - ($galerieConfig['test_wz_font']+4));
            $start_ob = $image_y-30;
          }else{                  
            $start_li = $image_x-40;
            $start_ob = $image_y-30;
          }
        }
      }
      
      $farbe_b = imagecolorallocate($new_image,$galerieConfig['test_wz_font_r'],$galerieConfig['test_wz_font_b'],$galerieConfig['test_wz_font_g']);
      if ($galerieConfig['test_wz_richtung'] == 0){
        imagestring ($new_image, $galerieConfig['test_wz_font'], $start_li, $start_ob, $galerieConfig['test_wz_text'], $farbe_b);
      }else{
        imagestringup ($new_image, $galerieConfig['test_wz_font'], $start_li, $start_ob, $galerieConfig['test_wz_text'], $farbe_b);
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
