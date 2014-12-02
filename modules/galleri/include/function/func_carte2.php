<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    function carte2() {
      global $id, $db, $rcxConfig, $galerieConfig, $eh, $police, $taille, $color, $bodycolor, $bordercolor, $meta;
      global $nom1, $email1, $nom2, $email2, $sujet, $message, $music, $myts;
        $img_Dat = new GallImg($id);
        $size = explode("|",$img_Dat->size());   
        $image = $img_Dat->id();
        OpenTable();
        gall_function("mainheader2");
      echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' bgcolor='#".$bodycolor."'><tr><td align='center'><br />";
        echo "<table width='95%' border='4' cellspacing='0' cellpadding='4' align='center' bordercolor='#".$bordercolor."'><tr><td align='center'>";
      echo "<br>";    
        echo "<table border='0' cellspacing='0' cellpadding='0' align='center' class='bg2'><tr>";
      if ($galerieConfig['img_back'] == 1){
      echo "<td style='background-image:url(".GAL_URL."/".$img_Dat->img().")'>";
      echo "<img src='".IMG_URL."/blank.gif' border='0' width='".$size[0]."' height='".$size[1]."' alt='".$img_Dat->alt()."'>";
    }else{            
            echo "<td align='center'><img border='0' src='".GAL_URL."/".$img_Dat->img()."' alt='".$img_Dat->alt()."'>";
        }
        echo "</td></tr></table>";   
        echo "<p>&nbsp;</p>";
        echo "<table width='80%' border='2' cellspacing='0' cellpadding='8' bordercolor='#".$bordercolor."'><tr><td>";
        echo "<p><font color='".$color."'>"._ECARDFOR.":<b> ".$nom2."</b></font></p>";
        echo "<blockquote>";
        echo "<p>".$myts->makeTareaData4Show($message, 1, 1, 1)."</p>";
        echo "</blockquote>";
        echo "<p align='right'><font color='".$color."'>"._ECARDTRANS2." <b>".$nom1."</b> email: <a href='mailto:".$email1."'>".$email1."</a></font></p>";
        echo "</td></tr></table>";
        echo "<p></p>";
        echo "</td></tr></table><br />";   
      echo "</td></tr></table>"; 
        echo "<br />";   
        echo "<table border='0' cellspacing='0' cellpadding='4' align='center'><tr><td>";
      echo "<form method='post' action='carte.php'>";
      echo "<input type='hidden' name='id' value='".$id."'>";
        echo "<input type='hidden' name='image' value='".$image."'>";
        echo "<input type='hidden' name='nom1' value='".$nom1."'>";
        echo "<input type='hidden' name='email1' value='".$email1."'>";
        echo "<input type='hidden' name='nom2' value='".$nom2."'>";
        echo "<input type='hidden' name='email2' value='".$email2."'>";
        echo "<input type='hidden' name='sujet' value='".$sujet."'>";
        echo "<input type='hidden' name='message' value='".$message."'>";
        echo "<input type='hidden' name='music' value='".$music."'>";
        echo "<input type='hidden' name='bodycolor' value='".$bodycolor."'>";
        echo "<input type='hidden' name='bordercolor' value='".$bordercolor."'>";
        echo "<input type='hidden' name='police' value='".$police."'>";
        echo "<input type='hidden' name='taille' value='".$taille."'>";
        echo "<input type='hidden' name='color' value='".$color."'>"; 
      echo "<input type='hidden' name='op' value='carte3'>";
        echo "<p align='center'><input type='submit' class='button' name='Submit' value='"._ECARDTRANS."'>";
        echo "</form>";
        echo "</td><td>";
        echo "<form method='post' action='carte.php'>";
      echo "<input type='hidden' name='id' value='".$id."'>";
        echo "<input type='hidden' name='image' value='".$image."'>";
        echo "<input type='hidden' name='nom1' value='".$nom1."'>";
        echo "<input type='hidden' name='email1' value='".$email1."'>";
        echo "<input type='hidden' name='nom2' value='".$nom2."'>";
        echo "<input type='hidden' name='email2' value='".$email2."'>";
        echo "<input type='hidden' name='sujet' value='".$sujet."'>";
        echo "<input type='hidden' name='message' value='".$message."'>";
        echo "<input type='hidden' name='music' value='".$music."'>";
        echo "<input type='hidden' name='bodycolor' value='".$bodycolor."'>";
        echo "<input type='hidden' name='bordercolor' value='".$bordercolor."'>";
        echo "<input type='hidden' name='police' value='".$police."'>";
        echo "<input type='hidden' name='taille' value='".$taille."'>";
        echo "<input type='hidden' name='color' value='".$color."'>"; 
      echo "<input type='hidden' name='op' value='carte1'>";
        echo "<p align='center'><input type='submit' class='button' name='Submit' value='"._ECARDCANCEL2."'>";
        echo "</form>";
        echo "</td></tr></table>";
      CloseTable();
        if (strlen($music) > 4){
//            echo "<BGSOUND src='midi/".$music."' AUTOSTART='true'>";
            echo "<embed src='midi/".$music."' width='2' height='2' AUTOSTART='true' HIDDEN='true'></embed>";
      }else{
            $music = "";
        }

    } 
?>
