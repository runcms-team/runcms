<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if (!defined("GALL_ADMINHEADER_INCLUDED")) {
        define("GALL_PAGE", "index.php");
        include("admin_header.php");
    }
    if ($go_reset == 0){
        $sql ="update ".$db->prefix("galli_img")." SET thumbCorr=0";
        $result = $db->query($sql);
    }
    gall_function("thumbCorr", array(GAL_ADMIN_URL."/upload_thumbCorr.php", array("name='go_reset' value='1'")));
    redirect_header("index.php?op=upload_einst",1,_AD_MA_DBUPDATED);
?>
