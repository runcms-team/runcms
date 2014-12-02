<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    include_once("header.php");
    include_once(RCX_ROOT_PATH."/class/rcxcomments.php");
    include_once(RCX_ROOT_PATH."/header.php");
    include_once(GALLI_PATH."/class/gall_img.php");
    $tempid = new GallImg($_GET['item_id']);
    if ($tempid->titre() == ""){
        $subject   = $tempid->img();
    }else{
        $subject   = $tempid->titre();
    }
    $pid = 0;    
    OpenTable();
    gall_function("mainheader", array("thumbnails/".$tempid->img()));    
    include_once(INCL_PATH."/commentform.inc.php");
    CloseTable();    
    include_once(RCX_ROOT_PATH."/footer.php");
?>
