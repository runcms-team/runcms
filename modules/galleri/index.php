<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
	include("header.php");
	include_once(GALLI_PATH."/class/galltree.php");
	$galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
    include_once(GALLI_PATH."/class/gall_cat.php");
    include_once(GALLI_PATH."/class/gall_img.php");
    
    $orderby = $myts->makeTboxData4Save($_GET['orderby']);
    
	if ($op == "top_ten"){
		$orderby = isset($orderby) ? gall_function("convertorderbyin", array($orderby)) : "clic DESC";
	}else{
		$orderby = isset($orderby) ? gall_function("convertorderbyin", array($orderby)) : $galerieConfig['newimg_sort'];
	}
	if($rcxConfig['startpage'] == "galleri"){
		$rcxOption['show_rblock'] = $galerieConfig['show_rblock'];
		$rcxOption['page_style'] = $galerieConfig['page_style'];
		include(RCX_ROOT_PATH."/header.php");
		make_cblock();
	}else{
		$rcxOption['show_rblock'] = $galerieConfig['show_rblock'];
		$rcxOption['page_style'] = $galerieConfig['page_style'];
		include(RCX_ROOT_PATH."/header.php");
	}	
    switch($op){
    
    	case "top_ten":
			include_once(INCL_PATH."/index_topten.php");
    	break;
    
    	case "comment":
			include_once(INCL_PATH."/index_comment.php");
    	break;

    	default:
			include_once(INCL_PATH."/index_start.php");
    	break;
    }
	include(GALLI_PATH."/footer.php");
	include(RCX_ROOT_PATH."/footer.php");
?>