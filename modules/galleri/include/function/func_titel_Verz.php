<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  function titel_Verz($titel1, $titel2, $catorimg, $err_nr=0){
    global $db, $rcxConfig, $galltree, $galerieConfig, $op_coad;
        include_once(FUNC_INCL_PATH."/func_gallHelp.php");
        include_once(GALLI_PATH."/class/Gal_Tree.php");
        echo "<h4 style='text-align:left;'>".$titel1."</h4>";
    echo "<table width=100% border=0 cellspacing=3 cellpadding=2 class='bg2'><tr>";
    echo "<td width=97% valign='middle'><font size='2' color='#".$galerieConfig['tab_titel']."'><b>".$titel2."</b></font></td>";
    echo "<td width=3% align=right>";
    if ( $err_nr >= 1 ){gallHelp($err_nr);}else{echo "&nbsp;";}
      echo "</td></tr><tr>";
    echo "<td colspan='2' class='bg1'>";
    $galltree = new GalTree($db->prefix("galli_category"),"cid","scid");    
        if (GALL_PAGE == "index.php"){
        $galltree->makeVerzeichnis("cname", "cname", 0, 0, "", "", $catorimg);  
        }else{
            $galltree->makeVerzeichnisCoAdmin("cname", "cname", $op_coad, 0, "", "", $catorimg);  
        }
    echo "</td>";
    echo "</tr><tr>";
    echo "<td colspan='2'>&nbsp;";
    echo "</td>";
    echo "</tr></table>\n";
  }

?>
