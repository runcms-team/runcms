<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
	if ($b == 1){
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
	}
	
  $fileending = strtolower(substr($img, strrpos($img,"."))); 
   $nameonly = str_replace($fileending, "", $img);   
   
if ($fileending == ".gif" or $fileending == ".jpeg" or $fileending == ".jpg" or $fileending == ".png" or $fileending == ".wbmp") {
			$imgfile = "./thumbnails/".$img_Dat->img();
		} elseif ($fileending==".rm") {
			$imgfile = RCX_URL."/modules/galleri/images/thumb/rm.gif";
		} elseif ($fileending == ".mov" or $fileending == ".mp4" or $fileending == ".m4v") {
			$imgfile = RCX_URL."/modules/galleri/images/thumb/mov.gif";
		} elseif ($fileending == ".swf") {
			$imgfile = RCX_URL."/modules/galleri/images/thumb/swf.gif";
		} elseif ($fileending == ".wmv" or $fileending == ".asf" or $fileending == ".avi") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/wmv.gif";
		} elseif ($fileending == ".wma") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/wma.gif";
		} elseif ($fileending == ".mp3") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/mp3.gif";
		} elseif ($fileending == ".m4a") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/m4a.gif";
		} elseif ($fileending == ".wav") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/wav.gif";
		} elseif ($fileending == ".mid") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/mid.gif";
		} elseif ($fileending == ".mpeg" or $fileending == ".mpg") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/mpg.gif";
		} elseif ($fileending == ".doc") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/doc.gif";
		} elseif ($fileending == ".rtf") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/rtf.gif";
		} elseif ($fileending == ".txt") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/txt.gif";
		} elseif ($fileending == ".pdf") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/pdf.gif";
		} elseif ($fileending == ".ppt") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/ppt.gif";
		} elseif ($fileending == ".xls") {
            $imgfile = RCX_URL."/modules/galleri/images/thumb/xls.gif";
		} else {
			$imgfile = RCX_URL."/modules/galleri/images/thumb/unknown.gif";
		}

	echo "<td width='".$br."%' align='center'>";
	$link = "<a href='".RCX_URL."/modules/galleri/viewcat.php?id=".$img_Dat->id()."&cid=$cid&min=$min&orderby=$orderby&show=$show'>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='4'><tr><td align='center'>";
	if ($galerieConfig['safe_mode'] == 0){
        gall_function("makeRahmen", array($link, $imgfile, $imgfile));
	}else{
        gall_function("makeRahmenFrame", array("./thumbnails/".$img_Dat->img()), explode("|",$img_Dat->size()));
   	}
	echo "</td></tr><tr><td align='center'>".$link."";
	if ($titre){echo $titre;}else{echo $img;}
	echo "</a></td></tr>";
    if ($galerieConfig['link_yn'] == 1){
        $ende  = strrpos($galerieConfig['link_url'],"=");
        $laenge = strlen($galerieConfig['link_url']); 
        if ( $ende == $laenge-1 ){$galerieConfig['link_url'] .= $img_Dat->id();}
        echo "<tr><td align='center'><a href='".$galerieConfig['link_url']."'>".$galerieConfig['link_text']."</a></td></tr>"; 
    }
    echo "</table>";
	echo "</td>";
	if ($b == $galerieConfig['perpage_width'] || $numrows == $min+$x+1 ){
		echo "</tr></table><br>";
		$b = 1;
	}else{
		$b++;
	}
?>