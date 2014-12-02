<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
global $_SERVER;
if ( preg_match("/dlformat\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
	}
echo "<table width='100%' cellspacing='0' cellpadding='5' border='0'><tr><td align='center' valign='top'>";
$str_path = $mytree->getNicePathFromId($cid, "title", "viewcat.php?");
$str_path = substr($str_path, 0, -2);
$str_path = str_replace(":", "<img src='".RCX_URL."/modules/downloads/images/arrow.gif' border='0' alt=''>", $str_path);
echo "<table width='100%' border='0' cellspacing='1' cellpadding='0' class='bg2'><tr><td>
<table width='100%' border='0' cellspacing='1' cellpadding='4' class='bg1' ><tr>
<td colspan='3' class='bg2' align='left'>
<b>"._MD_CATEGORYC."</b>".$str_path."</td></tr><tr>
<td class='bg3' colspan='3' valign='top'><div style='float: left'>
<a href='".RCX_URL."/modules/downloads/visit.php?lid=$lid' target=''>
<img src='images/download.gif' style='vertical-align: top;' border='0' alt='"._MD_DLNOW."' title='"._MD_DLNOW."'></a>&nbsp;
<a href='".RCX_URL."/modules/downloads/visit.php?lid=$lid' target='' title='"._MD_DLNOW."'><b>".$dtitle."</b></a>";
newdownloadgraphic($time, $status);
popgraphic($hits);
echo "</div><div style='float: right'>";
if ( $rating != "0" || $rating != "0.0" ) {
	if ($votes == 1) {
		$votestring = _MD_ONEVOTE;
		} else {
			$votestring = sprintf(_MD_NUMVOTES, $votes);
		}
$a = $rating/2;
if ($a <= 1) {
$star = "10.gif"; 
} elseif ($a <= 1.5) {
$star = "20.gif";
} elseif ($a <= 2) {
$star = "20.gif";
} elseif ($a <= 2.5) {
$star = "25.gif";
} elseif ($a <= 3) {
$star = "30.gif";
} elseif ($a <= 3.5) {
$star = "35.gif";
} elseif ($a <= 4) {
$star = "40.gif";
} elseif ($a <= 4.5) {
$star = "45.gif"; 
} elseif ($a <= 5) {
$star = "50.gif"; 
}
$urlimg = "<a href='".RCX_URL."/modules/downloads/ratefile.php?lid=$lid'><img src='".RCX_URL."/modules/downloads/images/";
$urlimg .= $star;
$urlimg .= "' border='0' width='74' height='14' alt='"._MD_RATETHISFILE."' title='"._MD_RATETHISFILE."' /></a> ($votestring)";
} else {
$urlimg = "<a href='".RCX_URL."/modules/downloads/ratefile.php?lid=$lid' title='"._MD_RATETHISFILE."' >&nbsp;"._MD_RATETHISFILE."&nbsp;</a>"; }
// end rating	
$ratf = "<b>"._MD_RATINGC."</b> $urlimg";
echo " $ratf </div></td></tr>"; echo "</td>
</tr><tr>
<td colspan='3' align='left' class='bg1' style='border-bottom:solid 1px;border-top:solid 1px;'>
<img src='".RCX_URL."/modules/downloads/images/decs.gif' border='0' width='14' height='14' align='buttom' alt='"._MD_DESCRIPTION."' />&nbsp;:&nbsp; $description</td>";
echo "</tr><tr class='bg3'>
<td width='50%'>
<table width='100%' border='0' cellspacing='1' cellpadding='0' class='bg1' align='center'><tr><td>
<table width='100%' border='0' cellspacing='1' cellpadding='' class='bg3'>
<tr align='left'><td><div><small><b>"._MD_SUBMITTER."</b></small></div></td><td><div><small><a href='".RCX_URL."/userinfo.php?uid=".$uid."'>".$submitter."</a></small></div></td></tr>
<tr align='left'><td><div><small><b>"._MD_SUBMITDATE." :</b></small></div></td><td><div><small>".$datetime."</small></div></td></tr>
<tr align='left'><td><div><small><b>"._MD_HOMEPAGE." :</b></small></div></td><td><div><small><a href='".$homepage."' title='".$homepage."' target='_blank'>"._MD_VISITHOMEPAGE."</a></small></div></td></tr>
<tr align='left'><td><div><small><b>&nbsp;</b></small></div></td><td><div><small>&nbsp;</small></div></td></tr>
<tr align='left'><td><div><small><b>&nbsp;</b></small></div></td><td><div><small>&nbsp;</small></div></td></tr>
</table></td></tr></table></td>
<td width='50%'>
<table width='100%' border='0' cellspacing='1' cellpadding='0' class='bg1' align='center'><tr><td>
<table width='100%' border='0' cellspacing='1' cellpadding='' class='bg3'>
<tr align='left'><td><div><small><b>"._MD_VERSION." :</b></small></div></td><td><div><small>".$version."</small></div></td></tr>
<tr align='left'><td><div><small><b>"._AM_DOWNLOADS." :</b></small></div></td><td><div><small>".$hits."</small></div></td></tr>
<tr align='left'><td><div><small><b>"._MD_FILESIZE." :</b></small></div></td><td><div><small>".PrettySize($size)."</small></div></td></tr>
<tr align='left'><td><div><small><b></b></small></div></td><td><div>&nbsp;</div></td></tr>
<tr align='left'><td><div><small><b>"._MD_SUPPORTEDPLAT." :</b></small></div></td><td><div><small>".$platform."</small></div></td></tr>
</table></td></tr></table></td>
<td width='".$downloadsConfig['shotwidth']."'>
<table width='100%' border='0' cellspacing='1' cellpadding='0' class='bg3' align='center'><tr><td>
<table width='100%' border='0' cellspacing='1' cellpadding='' class='bg3'>
<td colspan=''><td width='".$downloadsConfig['shotwidth']."' class='bg3' border='0' align='right' valign='top' colspan='4' rowspan='3'>";
   if ($logourl && $downloadsConfig['useshots']) // screenshot
   {
      echo "<td width='".$downloadsConfig['shotwidth']."'>
			<table width='100%' border='1' cellspacing='1' cellpadding='0' class='bg3 center'><tr>			
			<td width='".$downloadsConfig['shotwidth']."' class='bg3 right' border='0' style='vertical-align: top;' >";
      $logo_img = $logourl;
      $logourl = formatURL(RCX_URL.'/modules/downloads/cache/shots/', $logourl);

      if(!stristr($logo_img,"://")) // locally placed image
      {
         		$logourl = formatURL(RCX_URL.'/modules/downloads/cache/shots/', $logourl);

		 $img_size = getimagesize(RCX_ROOT_PATH.'/modules/downloads/cache/shots/'.$logo_img);
         echo "<a href=\"javascript:openWithSelfMain('".$logourl."','view_img',".$img_size[0].",".$img_size[1].");\">
				<img src='$logourl' border='0' alt='' width='".$downloadsConfig['shotwidth']."' /></a>";
      }
      else
      {
         echo "<img src='$logourl' border='0' alt='' width='".$downloadsConfig['shotwidth']."' />";
      }

      echo "</td></tr></table></td>";
   }
echo "</div></td></table></td></tr></table></td></td></tr><tr><td colspan='3' class='bg2' align='center'>";
global $rcxUser, $meta;
if ($rcxUser) {
	echo "<a href='".RCX_URL."/modules/downloads/modfile.php?lid=$lid'>"._MD_MODIFY."</a>";
}
echo " | <a href='".RCX_URL."/modules/downloads/brokenfile.php?lid=$lid'>"._MD_REPORTBROKEN."</a>";
echo " | <a target='_top' href='mailto:?subject=".rawurlencode(sprintf(_MD_INTFILEAT, $meta['title']))."&body=".rawurlencode(sprintf(_MD_INTFILEFOUND, $meta['title']).":\r\n".RCX_URL."/modules/downloads/singlefile.php?lid=$lid")."'>"._MD_TELLAFRIEND." | </a>";
if ($rcxUser) {
	if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
		echo "&nbsp; &nbsp; <a href='".RCX_URL."/modules/downloads/admin/index.php?lid=$lid&fct=downloads&op=modDownload'><img src='".RCX_URL."/modules/downloads/images/editicon.gif' border='0' alt='"._MD_EDITTHISDL."' /></a>";
	}
}
echo "</td></tr></table></td></tr></table></td></tr></table>";
?>
