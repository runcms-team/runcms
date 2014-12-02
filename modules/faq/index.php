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
if (@file_exists('./language/'.RC_ULANG.'/main.php'))
  include_once('./language/'.RC_ULANG.'/main.php');
else
  include_once('./language/english/main.php');

if ($rcxConfig['startpage'] == "faq") {
	$rcxOption['show_rblock'] = 1;
	include_once(RCX_ROOT_PATH."/header.php");
	make_cblock();
	} else {
		$rcxOption['show_rblock'] = 0;
		include_once(RCX_ROOT_PATH."/header.php");
	}

include_once("./cache/config.php");
OpenTable();
$cat_id = intval($_GET['cat_id']);

if ( empty($cat_id) ) {
	echo "
	<table width='100%' border='0'><tr>
	<td><h4 style='text-align:left;'>"._XD_DOCS."</h4></td>
	<td align='right' valign='top'>";

	if ($faqConfig['rss_enable'] == 1) {
		echo "<a href='./cache/faq.xml' target='_blank'><img src='./images/xml.gif' border='0' alt=''></a>";
		} else {
			echo "&nbsp;";
		}

	echo "</td></tr></table>";

	echo "<table width='100%' cellpadding='4' cellspacing='0' border='0'><tr><td><b>" ._XD_CATEGORIES."</b></td></tr><tr><td>";
	$result = $db->query("SELECT category_id, category_title FROM ".$db->prefix("faq_categories")." ORDER BY category_order ASC");
	while ( list($cat_id, $category) = $db->fetch_row($result) ) {
		echo "&nbsp;&nbsp;<img src='".RCX_URL."/modules/faq/images/folder.gif' width='14' height='14' border='0' />&nbsp;<a href='index.php?cat_id=".$cat_id."'>".$category."</a>";
		$category = $myts->makeTboxData4Show($category);
		$sql      = "SELECT contents_id, contents_title FROM ".$db->prefix("faq_contents")." WHERE contents_visible=1 AND category_id='".$cat_id."' ORDER BY contents_order ASC";
		$result2  = $db->query($sql);
		$list     = "";
		$count    = 0;
		while ( $myrow = $db->fetch_array($result2) ) {
			$list  .= "<li><a href='index.php?cat_id=".$cat_id."#".$myrow['contents_id']."'>".$myts->makeTboxData4Show($myrow['contents_title'])."</a></li>";
			$count += 1;
		}
		if ($count > 0) {
			echo "<ul style='list-style-image:url(images/question.gif);'>".$list."</ul>";
			} else {
				echo "<br />";
			}
	}
	echo"</td></tr></table>";

	} else {
		$result = $db->query("SELECT category_title FROM ".$db->prefix("faq_categories")." WHERE category_id='".$cat_id."'");
		list($category) = $db->fetch_row($result);
		$category = $myts->makeTboxData4Show($category);
		echo "<h4 style='text-align:left;'>"._XD_DOCS."</h4><a id='top' name='top'><a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;<b>".$category."</b><br /><br />";
		$filename = RCX_ROOT_PATH."/modules/faq/cache/doc".$cat_id.".php";
		if (@file_exists($filename)) {
			include_once($filename);
		}
		echo "<br /><br /><b>[ <a href='index.php'>" ._XD_BACKTOINDEX."</a> ]</b>";
	}

CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
