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
    include_once(GALLI_PATH."/class/gall_img.php");
    include_once(GALLI_PATH."/class/gall_cat.php");
	$id = $_GET['id'];
	if (isset($_GET['cid'])) {
		$cid = $_GET['cid'];
	}elseif(isset($_POST['cid'])) {
		$cid = $_POST['cid'];
	}else{
        if ($id == 0){
    		?>
    		<html><head>
    		<meta http-equiv='refresh' content='0;URL=thumbnail_index.php'>
    		</head></html>
    		<?;
    		exit();
        }else{
            $tempid = new GallImg($id);
            $cid = $tempid->cid();
        }
	}
	$cid_temp = $cid;
    if ( ($mode != "0") && ($mode != "thread") && ($mode != "flat") ) {
	    if ($rcxUser) {
		    $mode = $rcxUser->getVar("umode");
		} else {
			$mode = $rcxConfig['com_mode'];
		}
    }
	if ( !defined('THUMBNAIL_POPUP_HEADER_INCLUDED') ) {include(GALLI_PATH."/thumbnail_popup_header.php");}
	OpenTable();
	if ($_GET['show']!="") {
		$show = $_GET['show'];
	} else {
		$show = $gallgalerie_perpage;
	}
	if (!isset($_GET['min'])) {
		$min = 0;
	} else {
		$min = $_GET['min'];
	}
	if (!isset($max)) {
		$max = $min + $show;
	}
	if(isset($_GET['orderby'])) {
        $orderby = gall_function("convertorderbyin", array($_GET['orderby']));
	} else {
		$orderby = $galerieConfig['imgcat_sort'];
	}
	echo "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td align='center'>";
	echo "<table width='100%' cellspacing='1' cellpadding='2' border='0' class='bg3'><tr><td align='left' bgcolor='#".$galerieConfig['tb_view2_bgcol']."'>";
	$pathstring = "<a href='thumbnail_index.php'>"._MD_MAIN."</a>&nbsp;:&nbsp;";
	$nicepath = $galltree->getNicePathFromId($cid, "coment", "thumbnail_viewcat.php?target=".$target."&");
	$pathstring .= $nicepath;
	echo "<b>".$pathstring."</b>";
	echo "</td></tr></table><br>";
	$u_cat = 0;
	$arr=array();
	$arr=$galltree->getFirstChild($cid, "cname");
	if ( count($arr) > 0 ){
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		$u_cat = 1;
		$scount = 0;
	        echo "<table width='90%'><tr>";
			
	        foreach($arr as $ele){
			$coment = $myts->makeTboxData4Show($ele['coment']);
            $totalimg = gall_function("getTotalItems", array($ele['cid'], 1));
	               	echo "<td align='left'><b><a href=thumbnail_viewcat.php?target=".$target."&cid=".$ele['cid'].">".$coment."</a></b>&nbsp;(".$totalimg.")&nbsp;&nbsp;</td>";
	               	$scount++;
	               	if ( $scount == 4 ) {
	               		echo "</tr><tr>";
	                       	$scount = 0;
	               	}
	        }
	        echo "</tr></table><br />";
		echo "<hr /><br>";
	}
    $numrows = GallImg::countAllImg(array("i.cid=".$cid." ", "free > 0"));
	if($numrows>0){
	    $images_list = GallImg::getAllImg(array("cid=".$cid." ", "free > 0"), true, $orderby, $show, $min);
        if($numrows>1){
            $orderbyTrans = gall_function("convertorderbytrans", array($orderby));
	        echo "<br /><small><center>"._MD_SORTBY."&nbsp;&nbsp;
	        "._MD_TITLE." (<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=titreA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=titreD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
	        "._MD_DATE." (<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=dateA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=dateD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
	        "._MD_RATING." (<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=ratingA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href=thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=ratingD><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
	        "._MD_POPULARITY." (<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=clicA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&orderby=clicD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
	                  	";
	        echo "<br /><b><small>";
	     	printf(_MD_CURSORTBY,$orderbyTrans);
	     	echo "</small></b><br /><br /></center>";
		}else{
	     	echo "<br>";
	    }
	    echo "<table width='100%' cellspacing='0' cellpadding='10' border='0'>";
	    echo "<tr><td>";
	    $br = 100/$galerieConfig['perpage_width'];
	    $x=0;
	    $b=1;
	    $h=1;
        $orderby = gall_function("convertorderbyout", array($orderby));
        foreach ( $images_list as $img_Dat ) {
	     	$rating = number_format($rating, 2);
	        $cname = $myts->makeTboxData4Show($img_Dat->cname());
	        $nom = $myts->makeTboxData4Show($img_Dat->nom());
	        $titre = $myts->makeTboxData4Show($img_Dat->titre());
	        $email = $myts->makeTboxData4Show($img_Dat->email());
	        $clic = number_format($img_Dat->clic(), 0);
	        $vote = number_format($img_Dat->vote(), 0);
	        $img = $myts->makeTboxData4Show($img_Dat->img());
	        $datetime = formatTimestamp($img_Dat->date(),"s");
	        $coment = $myts->makeTareaData4Show($img_Dat->coment(), 1, 1, 1);

			if ($b == 1){
				echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
			}
			echo "<td width='".$br."%' align='center'>";
			$link = "<a title='"._ADD."' href='javascript:addImage(\"".$img."\"); self.close();'>";
			echo "<table width='100%' border='0' cellspacing='0' cellpadding='4'><tr><td align='center'>";
			
			$size = @getimagesize("./thumbnails/".$img_Dat->img());
   			echo "<table border='0' cellspacing='0' cellpadding='0'>";
   			echo "<tr><td style='background-image:url(./thumbnails/".$img_Dat->img().")'>";
   			echo $link."<img src='".RCX_URL."/modules/galleri/images/blank.gif' ".$size[3]." border='0'></a>";
   			echo "</td></tr></table>";

			echo "</td></tr><tr><td align='center'>".$link."";
			if ($titre){echo $titre;}else{echo $img;}
			echo "</a></td></tr></table>";
			echo "</td>";
			if ($b == $galerieConfig['perpage_width'] || $numrows == $min+$x+1 ){
				echo "</tr></table><br>";
				$b = 1;
			}else{
				$b++;
			}
			
	        $x++;
	    }
	    echo "</td></tr></table>";
?>

<script type="text/javascript">
<!--
function addImage(imgurl) {
var txtbox  = window.opener.rcxGetElementById("<?php echo $target;?>");
var align   = prompt("<?php echo _ENTERIMGPOS;?>\n<?php echo _IMGPOSRORL;?>", "");

while ( ( align != "" ) && ( align != "r" ) && ( align != "R" ) && ( align != "l" ) && ( align != "L" ) && ( align != null ) ) {
	align = prompt("<?php echo _ERRORIMGPOS;?>\n<?php echo _IMGPOSRORL;?>", "");
}

if ( align == "l" || align == "L" ) {
	align = " align=left";
	} else if ( align == "r" || align == "R" ) {
		align = " align=right";
		} else {
			align = "";
		}

txtbox.value += "[gal" + align + "]" + imgurl + "[/gal]";
return;
}
//-->
</script>

<?php    
		
		$cid= $cid_temp;
	   	$imgpages = ceil($numrows / $show);
		echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='40' align='center'>";
	   	if ($numrows % $show == 0) {
	   		$imgpages = $imgpages - 1;
	   	}
	   	if ($imgpages!=1 && $imgpages!=0) {
	       	$prev = $min - $show;
	       	if ($prev>=0) {
	       		echo "<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&min=$prev&orderby=$orderby&show=$show'>";
	            echo "<img src='".IMG_URL."/left.gif' align='center' valign='absmiddle' border='0' alt='"._MD_PREVIOUS."'></a>";
	       	}else{
				echo "&nbsp;";
			}
			echo "</td><td>";
	       	$counter = 1;
	       	$currentpage = ($max / $show);
	       	while ( $counter<=$imgpages ) {
	            $mintemp = ($show * $counter) - $show;
	            if ($counter == $currentpage) {
					echo "<b>$counter</b>&nbsp;";
				}else{
					echo "<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&min=$mintemp&orderby=$orderby&show=$show'>$counter</a>&nbsp;";
				}
	            $counter++;
	       	}
			echo "</td><td width='40' align='center'>";
	       	if ( $numrows>$max ) {
	       		echo "<a href='thumbnail_viewcat.php?target=".$target."&cid=$cid&min=$max&orderby=$orderby&show=$show'>";
	            echo "<img src='".IMG_URL."/right.gif' border='0' alt='"._MD_NEXT."'></a>";
	       	}else{
				echo "&nbsp;";
			}
	   	}
		echo "</td></tr></table>";
	}else{
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
		echo "<td class='bg1' width='100%' align='center'>";
		if ( $u_cat == 0 && $galerieConfig['hase_yn'] == 1){
            gall_function("makeRahmen", array($link, "./images/hase_cat.jpg", "./images/hase_cat.jpg"));
		}elseif ( $u_cat > 0){
			echo "<br><br><b>"._U_CAT."</b><br><br>";
		}else{
			echo "<br><br><b>V tej kategoriji še ni slik.</b><br><br>";
		}
		echo "</td></tr></table>";
	}
	echo "</td></tr></table>";
	
	CloseTable();
	
	if ( !defined('THUMBNAIL_POPUP_FOOTER_INCLUDED') ) {include(GALLI_PATH."/thumbnail_popup_footer.php");}
?>