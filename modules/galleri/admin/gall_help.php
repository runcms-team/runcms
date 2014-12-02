<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include("../../../mainfile.php");
        include(RCX_ROOT_PATH."/modules/galleri/language/dansk/help_txt.php");
        $helpmsg = array(
                "0100" => _HP_UEBERCAT,
                "0101" => _HP_KA1,
                "0102" => _HP_KA2,
                "0103" => _HP_KA3,
                "0104" => _HP_UEBERIMG,
                "0105" => _HP_IMG2,
                "0106" => _HP_IMG3,
                "0107" => _HP_IMG4,
                "0108" => _HP_IMG5,
                "0109" => _HP_IMG6,
                "0110" => _HP_IMG7,
                "0111" => _HP_IMG8,
                "0112" => _HP_KA4,
                "0113" => _HP_KA5,
                "0114" => _HP_KA6,
                "0115" => _HP_UEBERCATMOD,
                "0116" => _HP_KA_S1,
                "0117" => _HP_KA_S2,
                "0118" => _HP_KA_S3,
                "0119" => _HP_KA_S4,

                "9999" => _HP_NOHELP
        );
        $helpno = array_keys($helpmsg);
        switch ($errnr){
                case 1:                $h_code = array("0100","0101","0102","0103","0113","0114"); break;
                case 2:                $h_code = array("0104","0101","0105","0106","0107","0108","0110","0111"); break;
                case 3:                $h_code = array("0104","0101","0105","0106","0107","0108","0109","0110","0111"); break;
                case 4:                $h_code = array("0100","0101","0102","0112","0114"); break;
                case 5:                $h_code = array("0115","0116","0117","0118"); break;
                case 6:                $h_code = array("0115","0116","0117","0118","0119"); break;

                default:         $h_code = array("9999"); break;
        }
        rcx_header();
        echo "<table width='100%' border='0' cellspacing='0' cellpadding='2' class='bg2'><tr><td>&nbsp;</td></tr><tr>";
           echo "<td align='center' class='bg1'>";
           echo "<br><font size='2'><b>"._HP_WELCOM."</b>";
        echo "</font><br><br>";
           echo "<table border=0><tr><td>";
        echo "<b>".$helpmsg[$h_code[0]]."</b><br><br>";
        for($x=1;$x<sizeof($h_code);$x++){
                   if (!in_array($h_code[$x], $helpno)) {
                           $h_code[$x] = '9999';
                   }
                   echo $helpmsg[$h_code[$x]]."<br><br>";
        }
        echo "<br><br><center><form><input type='button' value='"._HP_CLOSE."' onClick='javascript:window.close();'></form></center>";
        echo "</td></tr></table>";
           echo "</td></tr><tr><td>&nbsp;";
           echo "</td></tr></table>";
//        break;
?>