<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function yes_no_hidden($text, $yes_form_action, $yes_hidden=array(), $yes_option="", $yes_buttontext, $no_form_action, $no_hidden=array(), $no_option="", $no_buttontext) {
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
        echo "<input type='submit' class='button' name='yes' value='".$yes_buttontext."'>&nbsp;&nbsp;";
        echo "</form>";
        echo "</td><td>";
        echo "<form method='post' action='".$no_form_action."'>";
        if ( is_array($no_hidden) && count($no_hidden) > 0 ) {
      foreach ( $no_hidden as $n ) {
        $where_query .= " $n AND";
                echo "<input type='hidden' ".$n."'>";
      }
    }                    
        echo $no_option;
        echo "<input type='submit' class='button' name='no' value='"._AD_MA_NO."'>";
        echo "</form>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        CloseTable();
    }
?>
