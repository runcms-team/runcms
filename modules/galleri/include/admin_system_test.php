<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if ( defined('GALL_ADMIN') ) {

        switch($op_pref){
        
          case "save":
                $upd_conf = new GalliConf(2);
                $upd_conf->setVar("parm3", 0);
                $upd_conf->store();                
                header("Location: index.php");
          break;
    
          default:
                gall_cp_header();
                openTable();
                $text = "<h4>"._AD_MA_TESTTITEL."</h4>";
                $text .= "<img src='".IMG_URL."/galleri_logo.png' width='120' height='116' border='0'><br><br>";
                $text .= _AD_SYSTESTAUTO."<br>";
                $text .= _AD_MA_TESTTEXT."<br>";
                gall_function("admin_meldung_go_hidden", array ($text, "index.php", array("name='op' value='system_test'", "name='op_pref' value='save'"), "", _AD_MA_NEXT));
                closeTable();
                gall_cp_footer();
          break;
        }
    }
?>