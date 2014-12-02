<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function carte_mail_table($uid){
        global $rcxConfig, $galerieConfig, $rcxUser;
        include_once(GALLI_PATH . '/class/gall_mail.php');
        $mail_total = GallMail::countAllMail(array("uid = ".$uid." "));       
        if ($mail_total > 0){
            OpenTable();
            echo "<h5>"._BG_LASTCARD."</h5>";
            echo "<TABLE width='100%' border='0' cellpadding='2' cellspacing='1' class='bg1'>";
            $mail_list = GallMail::getAllMail(array("uid = ".$uid." "), true);
            $rank = 1;
            $poidstotal = 0;
            echo "<tr class='bg2'>\n";
            echo "<td align='center'><b><font color='#".$galerieConfig['tab_titel']."'>"._MD_DATE."</font></b></td>\n";
            echo "<td align='center'><b><font color='#".$galerieConfig['tab_titel']."'>"._ECARDRECIP."</font></b></td>\n";
        echo "<td align='center'><b><font color='#".$galerieConfig['tab_titel']."'>"._BG_VERSDAT."</font></b></td>\n";
            echo "<td align='center'><b><font color='#".$galerieConfig['tab_titel']."'>"._BG_GELDAT."</font></b></td>\n";
            echo "<td align='center'><b><font color='#".$galerieConfig['tab_titel']."'>"._BG_ANZVISIT."</font></b></td></tr>\n";
            foreach ( $mail_list as $mail_Dat ) {
                if(is_integer($rank/2)){$color="bg4";}else{$color="bg3";}
                echo "<tr class='".$color."'>";
                echo "<td align='center'>".formatTimestamp($mail_Dat->date(), "l")."</td>\n";
                echo "<td align='center'><a href='".GALL_URL."/carte.php?op=visit&id=".$mail_Dat->id()."&key=".$mail_Dat->actkey()."'>".$mail_Dat->nom2()."</a></td>\n";
                echo "<td align='center'>".formatTimestamp($mail_Dat->date_vers(), "l")."</td>\n";
                echo "<td align='center'>";
                if ($mail_Dat->date_gelesen() > 0){
                    echo formatTimestamp($mail_Dat->date_gelesen(), "l");
                }else{    
                    echo "&nbsp;";
                }
                echo "</td>\n";
                echo "<td align='center'>".$mail_Dat->visit()."</td>\n";
                echo "</tr>";
                $rank++;
            }
            echo "</table>\n<br>";
            CloseTable();
        }
    }

?>
