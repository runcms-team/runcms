<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  // missing argument error
//	function makeRahmen($link, $bild_url, $bild_pf, $alt_txt){
	function makeRahmen($link, $bild_url, $bild_pf){

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
        echo "><tr><td height='".$hoehe."' align='center'>";
          $size = @getimagesize($bild_pf);
          echo "<table border='0' cellspacing='0' cellpadding='0'>";

// ALT tag - remove pic from <td> 
//          echo "<tr><td style='background-image:url(".$bild_url.")'>";
          echo "<tr><td>";

//         echo $link."<img src='".RCX_URL."/modules/galleri/images/blank.gif' ".$size[3]." border='0' alt='".$alt_txt."'></a>";
          echo $link."<img src='".$bild_url."' ".$size[3]." border='0' alt='".$alt_txt."'></a>";

          echo "</td></tr></table>";
          echo "</td></tr></table>";
      }else{
        echo "<table border='".$galerieConfig['haupt_tb1_bo']."' cellspacing='".$galerieConfig['haupt_tb1_cspa']."' cellpadding='".$galerieConfig['haupt_tb1_cpad']."' bordercolor='#".$galerieConfig['haupt_tb1_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb1_bgcol']."'>";
            echo "<tr><td>";
            echo "<table border='".$galerieConfig['haupt_tb2_bo']."' cellspacing='".$galerieConfig['haupt_tb2_cspa']."' cellpadding='".$galerieConfig['haupt_tb2_cpad']."' bordercolor='#".$galerieConfig['haupt_tb2_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb2_bgcol']."'>";
            echo "<tr><td align='center'>";
          $size = @getimagesize($bild_pf);
          echo "<table border='0' cellspacing='0' cellpadding='0'>";
          echo "<tr><td style='background-image:url(".$bild_url.")'>";
          echo $link."<img src='".RCX_URL."/modules/galleri/images/blank.gif' ".$size[3]." border='0'></a>";
          echo "</td></tr></table>";
      }
        echo "</td></tr></table>";
      echo "</td></tr></table>";
    }
?>
