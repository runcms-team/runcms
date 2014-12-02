<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    
    function carte_visit($id, $key) {
      global $db, $rcxConfig, $galerieConfig, $myts, $eh, $meta, $rcxUser;
        $numrows = GallMail::countAllMail(array("id = ".$id," actkey = '".$key."' "));
        if ($numrows == 1){
            $card_Dat = new GallMail($id);
            if ($rcxUser){
                if ($card_Dat->uid() != $rcxUser->uid() ){
                    if ($card_Dat->date_gelesen() == 0){
                        $card_Dat->setVar("date_gelesen", time());
                    }
                    $visit = $card_Dat->visit() + 1;
                    $card_Dat->setVar("visit", $visit);
                    $card_Dat->store();
                }
            }else{
                if ($card_Dat->date_gelesen() == 0){
                    $card_Dat->setVar("date_gelesen", time());
                }
                $visit = $card_Dat->visit() + 1;
                $card_Dat->setVar("visit", $visit);
                $card_Dat->store();
            }
            include(RCX_ROOT_PATH."/header.php");        
            $img_Dat = new GallImg($card_Dat->image());
            $size = explode("|",$img_Dat->size());   
            $image = $img_Dat->id();
    echo "<style type='text/css'>font {  font-family: ".$police."; font-size: ".$taille."; color: #".$color."}";
            echo "</style>";
//            if ($card_Dat->music() != ""){
//                echo "<BGSOUND src='Midi/".$card_Dat->music()."' AUTOSTART='true'>";
//                echo "<embed src='Midi/".$card_Dat->music()."' AUTOSTART='true' HIDDEN='true'></embed>";
//          }
            OpenTable();
            gall_function("mainheader2");
          echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' bgcolor='#".$card_Dat->body()."'><tr><td align='center'><br />";
            echo "<table width='95%' border='4' cellspacing='0' cellpadding='4' align='center' bordercolor='#".$card_Dat->border()."'><tr><td align='center'>";
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
            echo "<table width='80%' border='2' cellspacing='0' cellpadding='8' bordercolor='#".$card_Dat->border()."'><tr><td>";
            echo "<p><font color='".$card_Dat->color()."'>"._ECARDFOR.":<b> ".$card_Dat->nom2()."</b></font></p>";
            echo "<blockquote>";
            echo "<p>".$myts->makeTareaData4Show($card_Dat->message(), 1, 1, 1)."</p>";
            echo "</blockquote>";
            echo "<p align='right'><font color='".$card_Dat->color()."'>"._ECARDTRANS2." <b>".$card_Dat->nom1()."</b> email: <a href='mailto:".$card_Dat->email1()."'>".$card_Dat->email1()."</a></font></p>";
            echo "</td></tr></table>";
            echo "<p></p>";
            echo "</td></tr></table><br />";   
          echo "</td></tr></table>"; 
     // add by SVL
          CloseTable();

            if ($rcxUser){
                    gall_function("carte_mail_table", array($rcxUser->uid()));
                }
            include("footer.php");

            if ($card_Dat->music() != ""){
//                echo "<BGSOUND src='midi/".$card_Dat->music()."' AUTOSTART='true'>";
                echo "<embed src='midi/".$card_Dat->music()."' width='2' height='2' AUTOSTART='true' HIDDEN='true'></embed>";
          }

        include(RCX_ROOT_PATH."/footer.php");
      }else{
            redirect_header("index.php",5,_NOACTKEY);
          exit();
        }
    }
?>
