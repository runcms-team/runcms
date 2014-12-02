<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
	function showTopTen(){
		global $myts, $db, $rcxConfig, $orderby, $galerieConfig, $artcomment, $show;
		global $votum, $popdruck, $imgversand;
        include_once(GALLI_PATH."/class/gall_img.php");
		include_once(GALLI_PATH."/class/gall_cat.php");
		include_once(GALLI_PATH."/class/galltree.php");
		$galltree = new GallTree($db->prefix("galli_category"),"cid","scid", "Offen' OR visit='Privat");
		
		if ( $galerieConfig['imgfree']==1 ){$ing_conf="free>'0'";}else{$ing_conf="free='1'";}
        $new_list = GallImg::getAllImg(array($ing_conf), true, $orderby, $galerieConfig['newimg'], 0);
		echo "<table width='100%' cellspacing='0' cellpadding='10' border='0'><tr><td>";
            if ($galerieConfig['temp_haupt_width'] > 0){ $dif = $galerieConfig['temp_haupt_width']; }else{ $dif = 1;}
            $br = intval(100/$dif);
	    	$x=0;
			$b=1;
            foreach ( $new_list as $img_Dat ) {
	            $coment = $myts->makeTareaData4Show($img_Dat->coment(), 1, 1 ,1);
				$img = $myts->makeTboxData4Show($img_Dat->img());
				if ($galerieConfig['template_haupt'] == ""){$galerieConfig['template_haupt'] = "mit_Details2.php";}
				include(GALLI_PATH."/template/haupt/".$galerieConfig['template_haupt']);
	        	$x++;
	    	}
		echo "</td></tr></table>";
		
	}
?>
