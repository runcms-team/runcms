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
if ( preg_match("/linkformat\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
	}

echo "<table width='100%' cellspacing='0' cellpadding='5' border='0'><tr><td align='center' valign='top'>";

if ($linksConfig['useshots']) {
	if ($logourl) {
		$logourl = formatURL(RCX_URL.'/modules/links/cache/shots/', $logourl);
		echo "
		<a href='".RCX_URL."/modules/links/visit.php?lid=$lid' target='_blank'><img src='$logourl' border='0' alt='' width='".$linksConfig['shotwidth']."' /></a>
		</td><td align='center' valign='top' width='100%'>";
	}
}

$path = $mytree->getNicePathFromId($cid, "title", "viewcat.php?");
$path = substr($path, 0, -2);
$path = str_replace(":", "<img src='".RCX_URL."/modules/links/images/arrow.gif' board='0' alt=''>", $path);

echo "
<table width='100%' border='0' cellspacing='1' cellpadding='0' class='bg2'><tr>
<td>
<table width='100%' border='0' cellspacing='1' cellpadding='4' class='bg1'><tr>
<td colspan='2' class='bg2'>
<b>"._MD_CATEGORYC."</b>".$path."
</td>

</tr><tr>

<td class='bg3'>
<a href='".RCX_URL."/modules/links/visit.php?lid=$lid' target='_blank'><img src='images/home.gif' border='0' alt='".$url."'></a>
<a href='".RCX_URL."/modules/links/visit.php?lid=$lid' target='_blank'><b>$ltitle</b></a>";

newlinkgraphic($time, $status);
popgraphic($hits);

echo "
</td>
<td class='bg3' align='right' valign='bottom'>
<b>"._MD_HITSC."</b>$hits&nbsp;&nbsp;
<img src='".RCX_URL."/modules/links/images/time.gif' border='0' alt='"._MD_LASTUPDATEC."'>
".$datetime."
</td>

</tr><tr>

<td colspan='2' class='bg1' style='border-bottom:solid 1px;border-top:solid 1px;'>
<img src='".RCX_URL."/modules/links/images/decs.gif' border='0' align='buttom' alt='"._MD_DESCRIPTION."' />&nbsp;:&nbsp; $description
</td>

</tr><tr>
<td colspan='2' class='bg2' align='center'>";

if ($rating != "0" || $rating != "0.0") {
	if ($votes == 1) {
		$votestring = _MD_ONEVOTE;
		} else {
			$votestring = sprintf(_MD_NUMVOTES, $votes);
		}
	echo "<b>"._MD_RATINGC."</b>$rating ($votestring)";
}

global $rcxUser, $meta;
echo " <a href='".RCX_URL."/modules/links/ratelink.php?lid=$lid'>"._MD_RATETHISSITE."</a>";
if ($rcxUser) {
	echo " | <a href='".RCX_URL."/modules/links/modlink.php?lid=$lid'>"._MD_MODIFY."</a>";
}
echo " | <a href='".RCX_URL."/modules/links/brokenlink.php?lid=$lid'>"._MD_REPORTBROKEN."</a>";
echo " | <a target='_top' href='mailto:?subject=".rawurlencode(sprintf(_MD_INTRESTLINK, $meta['title']))."&body=".rawurlencode(sprintf(_MD_INTLINKFOUND,$meta['title']).":\r\n".RCX_URL."/modules/links/singlelink.php?lid=$lid")."'>"._MD_TELLAFRIEND."</a>";
if ($rcxUser) {
	if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
		echo "&nbsp; &nbsp; <a href='".RCX_URL."/modules/links/admin/index.php?lid=$lid&fct=links&op=modLink'><img src='".RCX_URL."/modules/links/images/editicon.gif' border='0' alt='"._MD_EDITTHISLINK."' /></a>";
	}
}

echo "</td></tr></table></td></tr></table></td></tr></table>";
?>
