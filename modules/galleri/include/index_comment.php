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
	echo "<br><div align='center'><h4>"._NW_NEWCOMMENTS."</h4>";

	if ($galerieConfig['coment'] == 1){
		include (GALLI_PATH."/class/gallcomments.php");
		$artcomment = new GallComments($db->prefix("galli_comments"));
		$commentsArray = $artcomment->getAllComments(array(), true, "date DESC", 10, 0);
		if ($rcxUser->isAdmin()){$adminview = 1;}else{$adminview = 0;}
	    $count = 0;
	    foreach($commentsArray as $ele) {
            if ( !($count % 2) ) {
                $color_num = 1;
            }else{
                $color_num = 2;
            }
            $ele->showComPost($order, $mode, $adminview, $color_num);
            $count++;
	    }		
	}else{
		echo "<h4>"._NW_NOCOMMENTS."</h4>";
	}
	echo "</div>";
	CloseTable();

?>