<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function makeRahmenFrame($name, $img_size){
      global $galerieConfig;
      if ( $galerieConfig['haupt_egal'] == 1 ){
          echo "<table width='100%' border='".$galerieConfig['haupt_tb1_bo']."' cellspacing='".$galerieConfig['haupt_tb1_cspa']."' cellpadding='".$galerieConfig['haupt_tb1_cpad']."' bordercolor='#".$galerieConfig['haupt_tb1_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb1_bgcol']."'>";
            echo "<tr><td>";
            echo "<table width='100%' border='".$galerieConfig['haupt_tb2_bo']."' cellspacing='".$galerieConfig['haupt_tb2_cspa']."' cellpadding='".$galerieConfig['haupt_tb2_cpad']."' bordercolor='#".$galerieConfig['haupt_tb2_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb2_bgcol']."'>";
            echo "<tr><td align='center'>";
          $hoehe = $galerieConfig['ppm_tnheight']+40;
          echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'";
        if ( $galerieConfig['haupt_hgtrans'] == 1 ){
          if ( $galerieConfig['haupt_hgclass'] <> "" ){
            echo " class='".$galerieConfig['haupt_hgclass']."'";
          }else{
            echo "bgcolor='#".$galerieConfig['haupt_tb2_bgcol']."'";
          }
        }
        echo "><tr><td>&nbsp;</td></tr><tr><td height='".$galerieConfig['ppm_tnheight']."' align='center'>";
//        $img_size = @GetImageSize($name);
          $img_width = $img_size[0];
          $img_height = $img_size[1];
        $frame_w=round($img_width * $galerieConfig['ppm_tnheight'] / $img_height);
        echo "<iframe name='Thumbnail' src='".INCL_PATH."/thframe.php?name=".$name."&jpegcomp=".$galerieConfig['ppm_jpegcomp']."&tn_height=".$galerieConfig['ppm_tnheight']."&gd2=".$galerieConfig['gd2']."&gif_ok=".$galerieConfig['gif_ok']."' marginwidth='0' marginheight='0' height='".$galerieConfig['ppm_tnheight']."' width='".$frame_w."' scrolling='no' align='middle' border='0' frameborder='0'></iframe>";
          echo "</td></tr><tr><td>&nbsp;</td></tr></table>";
      }else{
        echo "<table border='".$galerieConfig['haupt_tb1_bo']."' cellspacing='".$galerieConfig['haupt_tb1_cspa']."' cellpadding='".$galerieConfig['haupt_tb1_cpad']."' bordercolor='#".$galerieConfig['haupt_tb1_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb1_bgcol']."'>";
            echo "<tr><td>";
            echo "<table border='".$galerieConfig['haupt_tb2_bo']."' cellspacing='".$galerieConfig['haupt_tb2_cspa']."' cellpadding='".$galerieConfig['haupt_tb2_cpad']."' bordercolor='#".$galerieConfig['haupt_tb2_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb2_bgcol']."'>";
            echo "<tr><td align='center'>";
        echo $aufruf;
      }
        echo "</td></tr></table>";
      echo "</td></tr></table>";
    }
?>
