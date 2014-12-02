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
    $count_images = GallImg::countAllImg(array("free>'0'"));
	$numrows = GallImg::countAllImg(array("free>'0' "));
    $cat_list = GallCat::getAllCat(array("scid = 0"), true, "coment");
    if ($numrows > 0){
      if ($galerieConfig['haupt_perpage_width'] == 1){
            echo "<table border='0' cellspacing='0' cellpadding='5' width='100%'>\n";
            foreach ( $cat_list as $cat_Dat ) {
            $cname = $gallts->makeTboxData4Show($cat_Dat->cname());
              echo "<tr><td valign='middle' align='center' width='50%'>";       
            if ($cat_Dat->img() != ""){
              if ($galerieConfig['safe_mode'] == 0){
                  $imgurl = THUMB_URL."/".$cat_Dat->img();
                $link = "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>";
                gall_function("makeRahmen", array($link, $imgurl, "./thumbnails/".$cat_Dat->img(), $coment));
              }else{
                $img_pfad = "./galerie/".$cat_Dat->img();
                gall_function("makeRahmenFrame", array($img_pfad));
                }
              }else{
                    gall_function("makeRahmen", array("", IMG_URL."/nogalli.gif", IMG_PATH."/nogalli.gif", _MD_ALT_NOCAT));
              }
                $totaldownload = gall_function("getTotalItems", array($cat_Dat->cid(), 1));
              echo "</td><td valign='top' width='50%'>";
            if ( $cat_Dat->button() == "no_button.gif" ){
              if ($cat_Dat->coment() == ""){
                echo "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>".$cat_Dat->cname()."</a>&nbsp;(".$totaldownload.")<br>";
              }else{
                echo "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>".$cat_Dat->coment()."</a>&nbsp;(".$totaldownload.")<br>";
              }
            }else{
              echo "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'><img src='".IMG_URL."/button/".$cat_Dat->button()."' border='0'></a>&nbsp;(".$totaldownload.")<br>";
            }
            $arr=array();
            $galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
            $arr = $galltree->getFirstChild($cat_Dat->cid(), "coment");
            $space = 0;
            $chcount = 0;
            foreach($arr as $ele){
              $chcname=$gallts->makeTboxData4Show($ele['coment']);
              if ($chcount>4){
                echo "<br>&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>"._MD_CAT_MOR."&nbsp;...</a>";
                break;
              }
              if ($space>0){
                    echo "<br>";
                  }
              $result1 = $db->query("SELECT button FROM ".$db->prefix("galli_category")." WHERE cid = '".$ele['cid']."'");
              list($button)=$db->fetch_row($result1);
              if ( $button == "no_button.gif" ){
                    echo "&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$ele['cid']."'>".$chcname."</a>";
              }else{
                echo "&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$ele['cid']."'><img src='".IMG_URL."/button/".$button."' border='0'></a>";
              }
                  $space++;
              $chcount++;
              $result2 = $db->query("SELECT cid FROM ".$db->prefix("galli_category")." WHERE scid = '".$ele['cid']."'");
              list($cid)=$db->fetch_row($result2);
              if ($cid > 0) {echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$ele['cid']."'>"._MD_CAT_MOR."&nbsp;...</a>";}
            }
              echo "</td></tr>";
          }
          echo "</table>";
        }else{
            echo "<table border='0' cellspacing='0' cellpadding='5' width='100%'><tr>\n";
          $count = 0;
            foreach ( $cat_list as $cat_Dat ) {
            $cname = $gallts->makeTboxData4Show($cat_Dat->cname());
              echo "<td valign='middle' align='center' width='30%'>";       
            if ($cat_Dat->img() != ""){
              if ($galerieConfig['safe_mode'] == 0){
$img = $cat_Dat->img();
$fileending = strtolower(substr($img, strrpos($img,"."))); 
echo $fieending;
if ($fileending == ".gif" or $fileending == ".jpeg" or $fileending == ".jpg" or $fileending == ".png" or $fileending == ".wbmp") {
			$imgfile = "./thumbnails/".$cat_Dat->img();
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
                  $imgurl = $imgfile;
                $link = "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>";
                gall_function("makeRahmen", array($link, $imgurl, $imgurl, _MD_CATEGORYC . $cat_Dat->coment() ));
              }else{
                $img_pfad = "./galerie/".$cat_Dat->img();
                gall_function("makeRahmenFrame", array($img_pfad));
                }
              }else{
                    gall_function("makeRahmen", array("", IMG_URL."/nogalli.gif", IMG_PATH."/nogalli.gif", _MD_ALT_NOCAT));
              }
                $totaldownload = gall_function("getTotalItems", array($cat_Dat->cid(), 1));
              echo "</td><td valign='top' width='20%'>";
            if ( $cat_Dat->button() == "no_button.gif" ){
              if ($cat_Dat->coment() == ""){
                echo "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>".$cat_Dat->cname()."</a>&nbsp;(".$totaldownload.")<br>";
              }else{
                echo "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>".$cat_Dat->coment()."</a>&nbsp;(".$totaldownload.")<br>";
              }
            }else{
              echo "<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'><img src='".IMG_URL."/button/".$cat_Dat->button()."' border='0'></a>&nbsp;(".$totaldownload.")<br>";
            }
            $arr=array();
            $galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
            $arr = $galltree->getFirstChild($cat_Dat->cid(), "coment");
            $space = 0;
            $chcount = 0;
            foreach($arr as $ele){
              $chcname=$gallts->makeTboxData4Show($ele['coment']);
              if ($chcount>4){
                echo "<br>&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$cat_Dat->cid()."'>"._MD_CAT_MOR."&nbsp;...</a>";
                break;
              }
              if ($space>0){
                    echo "<br>";
                  }
              $result1 = $db->query("SELECT button FROM ".$db->prefix("galli_category")." WHERE cid = '".$ele['cid']."'");
              list($button)=$db->fetch_row($result1);
              if ( $button == "no_button.gif" ){
                    echo "&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$ele['cid']."'>".$chcname."</a>";
              }else{
                echo "&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$ele['cid']."'><img src='".IMG_URL."/button/".$button."' border='0'></a>";
              }
                  $space++;
              $chcount++;
              $result2 = $db->query("SELECT cid FROM ".$db->prefix("galli_category")." WHERE scid = '".$ele['cid']."'");
              list($cid)=$db->fetch_row($result2);
              if ($cid > 0) {echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='".GALL_URL."/viewcat.php?cid=".$ele['cid']."'>"._MD_CAT_MOR."&nbsp;...</a>";}
            }
              if ($count<1) {echo "</td>";}
              $count++;
              if ($count==2) {echo "</td></tr><tr>";$count = 0;}
          }
          if ( $count == 1){echo "<td colspan='2'>&nbsp;</td></tr></table>";}else{echo "</tr></table>";}          
        }
  }
	echo "<br><br>";
	printf(_MD_THEREARE, $count_images);
	echo "</center>";
	
	 CloseTable(); 
  if ( $galerieConfig['newimg'] >= 1 && $numrows > 0){
      OpenTable();
     echo "<div align='center'><big><b>"._MD_LATESTLIST."</b></big><br>";
        if( $galerieConfig['newimg'] > 1 ){
              $orderbyTrans = gall_function("convertorderbytrans", array($orderby));
          }       
      gall_function("showNew");
      echo "</div>";
      CloseTable(); 
  }    
  
?>