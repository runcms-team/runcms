<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    OpenTable();
    gall_function("mainheader2");
	echo "<hr /><br>";
	echo "<center>\n";
	if ($galerieConfig['coment'] == 1){
		if (!defined("RCX_SPXCOMMENTS_INCLUDED")) {include(RCX_ROOT_PATH . "/class/rcxcomments.php");}
		$artcomment = new RcxComments($db->prefix("galli_comments"));
    }
	$numrows = GallImg::countAllImg(array("free>'0'"));
	if ( $numrows > 0){
	    echo "<br>";
	    if ($numrows < 20) {$galerieConfig['newimg'] = $numrows;}else{$galerieConfig['newimg'] = 20;}
		if ($galerieConfig['temp_haupt_width'] > $numrows){$galerieConfig['temp_haupt_width'] = $numrows;}
	    echo "<div align='center'><big><b>".sprintf(_MD_LATEST10, $galerieConfig['newimg'])."</b></big><br>";
        $orderbyTrans = gall_function("convertorderbytrans", array($orderby));
        echo "<br /><small><center>"._MD_SORTBY."&nbsp;&nbsp;
        "._MD_RATING." (<a href='index.php?op=top_ten&orderby=ratingA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href=index.php?op=top_ten&orderby=ratingD><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
        "._MD_POPULARITY." (<a href='index.php?op=top_ten&orderby=clicA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='index.php?op=top_ten&orderby=clicD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)";
        echo "<br /><b><small>";
     	printf(_MD_CURSORTBY,$orderbyTrans);
     	echo "</small></b><br /><br /></center>";
	    gall_function("showTopTen");
	    echo "</div>";
	}else{
		echo "<br><br>";
		printf(_MD_THEREARE, $numrows);
		echo "</center>";
	}
    CloseTable();
?>