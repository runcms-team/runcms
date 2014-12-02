<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( !defined("GALL_CPFUNCTIONS_INCLUDED") ) {
  define("GALL_CPFUNCTIONS_INCLUDED",1);
    
  function gall_cp_header(){
    global $rcxConfig, $rcxUser, $galerieConfig, $op_coad;
    rcx_header();
    echo "</head><body topmargin='0' leftmargin='0' marginheight='0' marginwidth='0'>";
    echo "<table border='0' width='100%' cellspacing='0' cellpadding='0'><tr class='bg3'><td align='left' width='30%'>&nbsp;</td>";
    echo "<td align='center' width='40%'><b>Администрирование фотоальбома</b></td>";
    echo "<td align='right' width='30%'><a href='".RCX_URL."/'>"._YOURHOME."</a> &nbsp;&nbsp;&nbsp;</td></tr></table>";
    echo "<table border='1' cellpadding='0' cellspacing='5' width='100%'><tr>";
    echo "<td valign='top' width='150'>\n";
        if ($galerieConfig['install'] == 1){
            OpenTable();
            echo "<h5>CoAdmin-"._AD_MA_MENUE."</h5>";
            echo "<b>"._STD_FONT._AD_MA_CONF."</b><br>";
            echo "&nbsp;&nbsp;--&nbsp;<a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=cat_conf&op_coad=".$op_coad."'>"._Editfile."</a><br>";   
            echo "<hr>";
            echo "<b>"._STD_FONT._IMAGES."</b><br>";
            echo "&nbsp;&nbsp;--&nbsp;<a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=img_conf&op_coad=".$op_coad."'>"._AD_MA_FILEMANAG."</a><br>";   
            echo "<hr>";
            echo "<b>"._STD_FONT._AD_MA_Help."</b><br>";
            echo "&nbsp;&nbsp;--&nbsp;<a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=online_help&op_coad=".$op_coad."'>Online</a><br>";   
            echo "&nbsp;&nbsp;--&nbsp;<a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=gd_info&op_coad=".$op_coad."'>"._AD_MA_GDINFO2."</a><br>";
            CloseTable();
            echo "<br>";
        }
        OpenTable();
        echo "<center><img src='".IMG_URL."/webdes.jpg' border='0' alt='Gьnter Bauer Webdesign Nьrnberg' width='101' height='47'></center>";
        CloseTable();
        echo "</td><td valign='top'>";
  }

  function gall_cp_footer(){
    echo"</td></tr></table>";
        echo"<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='right' class='tb_footer'>Powered by&nbsp;<a href='http://www.gall-webdesign.de/' target='_blank'>gall-webdesign.de</a> &copy; 2003&nbsp;</td></tr></table>";
        rcx_footer();
  }

  function OpenTable($br='100%') {
    echo "<table width=".$br." border='0' cellspacing='1' cellpadding='0'><tr class='bg2'><td valign='top'>\n";
    echo "<table width='100%' border='0' cellspacing='1' cellpadding='8'><tr class='bg3'><td valign='top'>\n";
  }

  function CloseTable() {
    echo "</td></tr></table></td></tr></table>\n";
  }

}
?>