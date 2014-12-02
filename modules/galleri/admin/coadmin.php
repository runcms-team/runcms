<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    define("GALL_PAGE", "coadmin.php");
    include("admin_header.php");
    
    switch($op){

      case "cat_conf":
        include(INCL_PATH."/coadmin_cat_conf.php");
      break;
    
      case "delCat":
        include(INCL_PATH."/coadmin_cat_del.php");
      break;
    
      case "delImg":
        include(INCL_PATH."/coadmin_img_del.php");
      break;
    
      case "editImg":
        include(INCL_PATH."/caadmin_edit_img.php");
      break;
    
      case "img_conf":
        include(INCL_PATH."/datei_manager_coadmin.php");
      break;

      case "gd_info":
            gall_cp_header();
            OpenTable();
            gall_function("meldung", array ("<h5>"._AD_MA_GDINFO."</h5><br>".gall_function("gd_table")."<br><br>", 1));
            CloseTable();
            gall_cp_footer();
      break;
    
      case "modCat":
        include(INCL_PATH."/coadmin_cat_mod.php");
      break;

      case "online_help":
            gall_cp_header();
            OpenTable();
            include(INCL_PATH."/online_help.php");
            CloseTable();
            gall_cp_footer();
      break;

      default:
        gall_cp_header();
            OpenTable();
            echo "<br>";
            include(INCL_PATH."/admin_index.php");
            echo "<br>";
            CloseTable();
            gall_cp_footer();
      break;
    }
    
?>