<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Function to display banners in all pages
*/
function show_banner($display="N") {
global $db, $myts, $rcxUser, $rcxConfig;

if ($rcxConfig["banners"]) {

$display = strtoupper($display);

switch($display) {
	case "N":
		$extra = "AND display='N'";
		break;

	case "A":
		$extra = "";
		break;

	case "BA":
		$extra = "AND display != 'N'";
		break;

	case "SR":
		$extra = "AND (display='SR' OR display='BA' OR display='A')";
		break;

	case "SL":
		$extra = "AND (display='SL' OR display='BA' OR display='A')";
		break;

	case "SLR":
		$extra = "AND (display='SL' OR display='SR' OR display='SLR' OR display='BA' OR display='A')";
		break;

	case "CL":
		$extra = "AND (display='CL' OR display='BA' OR display='A')";
		break;

	case "CR":
		$extra = "AND (display='CR' OR display='BA' OR display='A')";
		break;

	case "CLR":
		$extra = "AND (display='CL' OR display='CR' OR display='CLR' OR display='BA' OR display='A')";
		break;

	case "CC":
		$extra = "AND (display='CC' OR display='BA' OR display='A')";
		break;

	case "CA":
		$extra = "AND (display='CL' OR display='CR' OR display='CLR' OR display='CC' OR display='CA' OR display='BA' OR display='A')";
		break;

	default:
		$extra = "AND display='$display'";
		break;
}

// Bug in mysql? need to call query to a same table twice to get a rand()
$query = $db->query("SELECT COUNT(*) FROM ".$db->prefix("banner_items")." WHERE dateend<1 $extra ORDER BY RAND()");
list($numrows) = @$db->fetch_row($query);

if ($numrows > 0) {
	$query = $db->query("SELECT bid, imptotal, impmade, imageurl, imagealt, clickurl, display, custom FROM ".$db->prefix("banner_items")." WHERE dateend<1 $extra ORDER BY RAND()", 1);
	list ($bid, $imptotal, $impmade, $imageurl, $imagealt, $clickurl, $display, $custom) = $db->fetch_row($query);
	if ( ($imptotal != 0) && ($imptotal == $impmade) ) {
		$db->query("UPDATE ".$db->prefix("banner_items")." SET dateend=".time()." WHERE bid=$bid");
	}
	if ($custom) {
		echo $custom;
		} else {
			$imagealt = $myts->makeTboxData4Show($imagealt);
			echo "<a href='".RCX_URL."/modules/banners/click.php?op=click&amp;bid=$bid' target='_blank'><img class='banner' src='".formatURL(RCX_URL . "/modules/banners/cache/banners/", $imageurl)."' alt='$imagealt' /></a>";
		}
	if ( !$rcxUser || !$rcxUser->isAdmin() ) {
		$db->query("UPDATE ".$db->prefix("banner_items")." SET impmade=impmade+1 WHERE bid=$bid AND dateend<1");
	}
	}
}
}
?>
