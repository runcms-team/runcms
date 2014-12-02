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
	$galltree = new GallTree($db->prefix("gallgalerie3_category"),"cid","scid");
    include_once(GALLI_PATH."/class/gall_cat.php");
    include_once(GALLI_PATH."/class/gall_img.php");
	$orderby = isset($_GET['orderby']) ? gall_function("convertorderbyin", array($_GET['orderby'])) : $galerieConfig['newimg_sort'];

	if ( !defined('THUMBNAIL_POPUP_HEADER_INCLUDED') ) {include(GALLI_PATH."/thumbnail_popup_header.php");}

	include_once(INCL_PATH."/thumbnail_index_start.php");

	if ( !defined('THUMBNAIL_POPUP_FOOTER_INCLUDED') ) {include(GALLI_PATH."/thumbnail_popup_footer.php");}
?>