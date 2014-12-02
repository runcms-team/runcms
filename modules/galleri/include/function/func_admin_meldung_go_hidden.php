<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    function admin_meldung_go_hidden($text, $yes_form_action, $yes_hidden=array(), $yes_option="", $yes_buttontext) {
        OpenTable();
        echo "<table width='90%' border='0' cellspacing='0' cellpadding='2' align='center' class='tb_titel'><tr><td>&nbsp;</td></tr><tr>";
        echo "<td align='center'>";
        echo "<br><font size='2'><b>".$text;
        echo "</b><br>";
        echo "</font><br>";
        echo "<table border=0><tr><td align='center'>";
        echo "<form method='post' action='".$yes_form_action."'>";
        if ( is_array($yes_hidden) && count($yes_hidden) > 0 ) {
      foreach ( $yes_hidden as $c ) {
                echo "<input type='hidden' ".$c."'>";
      }
    }                    
        echo $yes_option;
        echo "<input type='submit' class='button' name='yes' value='".$yes_buttontext."'>";
        echo "</form>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        CloseTable();
    }
?>
