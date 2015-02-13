<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("../../mainfile.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
/********************************************/
/* Function to let your client login to see */
/* the stats                                */
/********************************************/
function clientlogin() {
global $db;

$rcxOption['show_rblock'] = 1;
include_once("./header.php");
OpenTable();

echo "
<form action='index.php' method='POST'>
<table width='100%'><tr>

<td colspan='2' align='center' class='bg2'>
<b>"._BN_STATS."</b></td>

</tr><tr>

<td align='right'><b>"._BN_LOGIN.":</b></td>
<td><input type='text' class='text' name='login' size='11' maxlength='10' /></td>

</tr><tr>

<td align='right'><b>"._BN_PASS.":</b></td>
<td><input type='password' class='text' name='pass' size='11' maxlength='10' /></td>

</tr><tr>

<td align='center' colspan='2'><input class='text' type='hidden' name='op' value='bannerstats' />
<input type='submit' class='button' value='"._BN_LOGIN."'></td>

</tr><tr>
<td colspan='2' align='center' class='bg2'>"._BN_INFO."</td>
</tr></table></form>";

CloseTable();
include_once("footer.php");
}

/**
* Description
*
* @param type $var description
* @return type description
*/
/*********************************************/
/* Function to display the banners stats for */
/* each client                               */
/*********************************************/
function bannerstats($login, $pass) {
global $db, $myts, $rcxConfig, $meta;

$login = $myts->oopsAddSlashesGPC($login);

$sqlpass = md5($pass);
$result  = $db->query("SELECT cid, name, login, passwd  FROM ".$db->prefix("banner_clients")." WHERE login='$login' AND passwd='$sqlpass'");
list($cid, $name, $login, $passwd) = $db->fetch_row($result);

if ($sqlpass == $passwd) {
	$rcxOption['show_rblock'] = 0;
	include_once("./header.php");
	OpenTable();

echo "
<h4 style='text-align:center;'><b>".sprintf(_BN_ACTIVE, $name)."</b><br /></h4>
<table width='100%' border='0' cellpadding='3' cellspacing='0'><tr class='bg2'>
<td align='center'><b>"._BN_ID."</b></td>
<td align='center'><b>"._BN_MADE."</b></td>
<td align='center'><b>"._BN_TOTAL."</b></td>
<td align='center'><b>"._BN_LEFT."</b></td>
<td align='center'><b>"._BN_CLICKS."</b></td>
<td align='center'><b>% "._BN_CLICKS."</b></td>
<td align='center'><b>"._BN_FUNCTIONS."</b></td><tr>";

$result = $db->query("SELECT bid, imptotal, impmade, clicks, datestart FROM ".$db->prefix("banner_items")." WHERE cid=$cid");
while ( list($bid, $imptotal, $impmade, $clicks, $date) = $db->fetch_row($result) ) {
	if ( ($impmade == 0) || ($clicks == 0) ) {
		$percent = 0;
		} else {
			$percent = round(100 * ($clicks/$impmade), 2);
		}

if ( $imptotal == 0 ) {
	$left = _BN_UNLIMITED;
	} else {
		$left = ($imptotal-$impmade);
	}

echo "
<td align='center'>$bid</td>
<td align='center'>$impmade</td>
<td align='center'>$imptotal</td>
<td align='center'>$left</td>
<td align='center'>$clicks</td>
<td align='center'>$percent%</td>
<td align='center'><a href='index.php?op=EmailStats&amp;login=$login&amp;pass=$pass&amp;cid=$cid&amp;bid=$bid'>"._BN_MAIL."</a></td><tr>";
}

echo "</table><br /><br />".sprintf(_BN_RUNNING, $meta['title'])."<br /><br />";
$result = $db->query("SELECT bid, imageurl, imagealt, clickurl from ".$db->prefix("banner_items")." WHERE cid=$cid");

while ( list($bid, $imageurl, $imagealt, $clickurl) = $db->fetch_row($result) ) {
	$numrows = $db->num_rows($result);
	if ($numrows > 1) {
		echo "<hr /><br />";
	}

echo "
<a href='".$imageurl."' target='_blank'><img src='".formatURL(RCX_URL . "/modules/banners/cache/banners/", $imageurl)."' alt='".$myts->makeTboxData4Show($imagealt)."' class='banner' /></a><br />
"._BN_ID." $bid<br />

<a href='index.php?op=EmailStats&amp;login=$login&amp;cid=$cid&amp;bid=$bid&amp;pass=$pass'>"._BN_MAIL."</a><br />

<form action='index.php' method='post'>
<input type='text' class='text' name='url' size='50' maxlength='255' value='".$myts->makeTboxData4Edit($clickurl)."' /> :"._BN_URL."<br />
<input type='text' class='text' name='alt' size='50' maxlength='60' value='".$myts->makeTboxData4Edit($imagealt)."' /> :"._BN_ALT."
<input type='hidden' name='login' value='$login' />
<input type='hidden' name='bid' value='$bid' />
<input type='hidden' name='pass' value='$pass' />
<input type='hidden' name='cid' value='$cid' /><br /><br />
<input type='submit' class='button' name='op' value='Change' /></form>";
}

CloseTable();

/* Finnished Banners */
echo "<br />";
OpenTable();
echo "
<h4 style='text-align:center;'>".sprintf(_BN_FINISHED, $name)."</h4>
<table width='100%' border='0' cellpadding='3' cellspacing='0'><tr class='bg2'>
<td align='center'><b>"._BN_ID."</b></td>
<td align='center'><b>"._BN_IMPRESSIONS."</b></td>
<td align='center'><b>"._BN_CLICKS."</b></td>
<td align='center'><b>% "._BN_CLICKS."</b></td>
<td align='center'><b>"._BN_START."</b></td>
<td align='center'><b>"._BN_END."</b></td></tr>";

$result = $db->query("SELECT bid, impmade, clicks, datestart, dateend FROM ".$db->prefix("banner_items")." WHERE dateend > 1 AND cid=$cid");

while ( list($bid, $impmade, $clicks, $date, $dateend) = $db->fetch_row($result) ) {
	if ( ($impmade == 0) || ($clicks == 0) ) {
		$percent = 0;
		} else {
			$percent = round(100 * ($clicks/$impmade), 2);
		}

	echo "
	<tr>
	<td align='center'>$bid</td>
	<td align='center'>$impmade</td>
	<td align='center'>$clicks</td>
	<td align='center'>$percent%</td>
	<td align='center'>".formatTimestamp($date, 's')."</td>
	<td align='center'>".formatTimestamp($dateend, 's')."</td></tr>";
}

	echo '</table>';
	CloseTable();
	include_once("./footer.php");
	} else {
		redirect_header("index.php", 2, _BN_BADPASS);
		exit();
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
/*********************************************/
/* Function to let the client E-mail his     */
/* banner Stats                              */
/*********************************************/
function EmailStats($login, $cid, $bid, $pass) {
global $db, $rcxConfig, $meta;

$cid = intval($cid);
$bid = intval($bid);

$result2 = $db->query("SELECT name, email FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
list($name, $email) = $db->fetch_row($result2);

if ( !checkEmail($email) ) {
	redirect_header("index.php", 3, sprintf(_BN_NOEMAIL, $name));
	exit();
	} else {
		$result = $db->query("SELECT bid, imptotal, impmade, clicks, imageurl, clickurl FROM ".$db->prefix("banner_items")." WHERE bid=$bid AND cid=$cid");
		list($bid, $imptotal, $impmade, $clicks, $imageurl, $clickurl, $date) = $db->fetch_row($result);
		if ( ($impmade == 0) || ($clicks == 0) ) {
			$percent = 0;
			} else {
				$percent = round(100 * ($clicks/$impmade), 2);
			}

		if ($imptotal == 0) {
			$left     = _BN_UNLIMITED;
			$imptotal = _BN_UNLIMITED;
			} else {
				$left = ($imptotal-$impmade);
			}

		$rcxMailer =& getMailer();
		$rcxMailer->setTemplateDir(RCX_ROOT_PATH."/modules/banners/");
		$rcxMailer->setTemplate("bannerstats.tpl");
		$rcxMailer->assign("SITE_NAME", $meta['title']);
		$rcxMailer->assign("ADMIN_MAIL", $rcxConfig['adminmail']);
		$rcxMailer->assign("SITE_URL", RCX_URL."/");
		$rcxMailer->assign("CLIENT_NAME", $name);
		$rcxMailer->assign("BANNER_ID", $bid);
		$rcxMailer->assign("IMAGE_URL", $imageurl);
		$rcxMailer->assign("CLICK_URL", $clickurl);
		$rcxMailer->assign("IMP_TOTAL", $imptotal);
		$rcxMailer->assign("IMP_MADE", $impmade);
		$rcxMailer->assign("IMP_LEFT", $left);
		$rcxMailer->assign("CLICKS", $clicks);
		$rcxMailer->assign("PERCENT", $percent);
		$rcxMailer->assign("RPT_DATE", formatTimestamp(time(), 'm'));

		$rcxMailer->useMail();
		$rcxMailer->setToEmails($email);
		$rcxMailer->setFromEmail($rcxConfig['adminmail']);
		$rcxMailer->setFromName($meta['title']);
		$rcxMailer->setSubject(sprintf(_BN_STATSAT, $meta['title']));

		if (!$rcxMailer->send()) {
			$message = $rcxMailer->getErrors();
			} else {
				$message = _BN_STATSMAILED;
			}
		redirect_header("index.php?op=Ok&amp;login=$login&amp;pass=$pass", 3, $message);
		exit();
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
/*********************************************/
/* Function to let the client to change the  */
/* url for his banner                        */
/*********************************************/
function change_banner_url_by_client($login, $pass, $cid, $bid, $url, $alt) {
global $db, $myts;

$cid = intval($cid);
$bid = intval($bid);
$url = $myts->makeTboxData4Save($url);
$alt = $myts->makeTboxData4Save($alt);

$result = $db->query("SELECT passwd FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
list($passwd) = $db->fetch_row($result);

if (md5($pass) == $passwd) {
	$update = $db->query("UPDATE ".$db->prefix("banner_items")." SET clickurl='$url', imagealt='$alt' WHERE bid=$bid");
}

if ($update) {
	redirect_header("index.php?op=Ok&amp;login=$login&amp;pass=$pass", 3, _BN_URLCHANGED);
	} else {
		redirect_header("index.php?op=Ok&amp;login=$login&amp;pass=$pass", 1, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function clickbanner($bid) {
global $db;

$bid = intval($bid);

$bresult = $db->query("SELECT clickurl FROM ".$db->prefix("banner_items")." WHERE bid=$bid");

list($clickurl) = $db->fetch_row($bresult);
$db->query("UPDATE ".$db->prefix("banner_items")." SET clicks=clicks+1 WHERE bid=$bid");
echo "<html xmlns='http://www.w3.org/1999/xhtml'><head><title>$clickurl</title><meta http-equiv='Refresh' content='0; URL=".$clickurl."'></head><body></body></html>";
exit();
}

$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch ($op) {
	case "click":
		clickbanner($_GET['bid']);
		break;

	case "bannerstats":
		bannerstats($_POST['login'], $_POST['pass']);
		break;

	case "Ok":
		bannerstats($_GET['login'], $_GET['pass']);
		break;

	case "Change":
		change_banner_url_by_client($_POST['login'], $_POST['pass'], $_POST['cid'], $_POST['bid'], $_POST['url'], $_POST['alt']);
		break;

	case "EmailStats":
		EmailStats($_GET['login'], $_GET['cid'], $_GET['bid'], $_GET['pass']);
		break;

	default:
		clientlogin();
		break;
}
?>
