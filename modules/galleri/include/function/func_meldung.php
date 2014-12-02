<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function meldung($meldung, $meld_img="0", $f_class="fg5", $t_form="center"){
        OpenTable();
        echo "<table width='90%' cellspacing='0' cellpadding='5' align='center' class='tb_titel'><tr>";
        if ($meld_img > 0){ 
            echo "<td height='120' align='center' valign='middle'>";
            echo "<img src='".IMG_URL."/galleri_logo.png' width='120' height='116' border='0'></td></tr><tr><td align='center'>";
            echo "</td></tr><tr>";
        }
        echo "<td align='".$t_form."'>";
        echo $meldung;
        echo "</tr></td></table>";
        CloseTable();
    }
?>
