<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("./header.php");
include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
include_once("./cache/config.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function listsections() {
global $rcxConfig, $rcxModule, $sectionsConfig, $db, $myts, $meta;

include_once("../../header.php");

if ($rcxConfig['startpage'] == _MI_DIR_NAME) {
	$rcxOption['show_rblock'] = 1;
	make_cblock();
	echo "<br />";
	} else {
		$rcxOption['show_rblock'] = 0;
		echo "<br />";
	}

OpenTable();
$intro = join('', file("./cache/intro.php"));
$myts->setType('admin');
echo $myts->makeTareaData4Show($intro, 1, 1, 1)."<br /><br />";
CloseTable();
echo "<br />";
OpenTable();

if ($sectionsConfig['rss_enable']) {
	echo "<div align='right'><a href='./cache/sections.xml'><img src='./images/xml.gif' border='0' alt='' /></a></div><br />";
}
echo "<table width = 90%>";
$i=0;
$result = $db->query("SELECT secid, secname, image, secdesc FROM ".$db->prefix(_MI_NSECTIONS_TABLE));
while (list($secid, $secname, $image, $secdesc) = $db->fetch_row($result)) {
$secname = $myts->makeTboxData4Show($secname);
$secdesc = $myts->makeTboxData4Show($secdesc);
$i++;
if ($i == 1){
	echo "<tr>";
	}
	
if ( !empty($image) ) {
	echo "<td width = 50%><a href='./index.php?op=listarticles&amp;secid=$secid'><img src='".formatURL(RCX_URL. "/modules/".$rcxModule->dirname()."/cache/images/", $image)."' border='0' alt='$secname' /></a><br />";
}

echo "
<font class='title'><a href='./index.php?op=listarticles&amp;secid=$secid'>$secname:</a></font><br />
<i>".wordwrap($secdesc, 95, '<br />')."</i><br /><br /></td>";
if ($i == 2){
	echo "</tr>";
	$i=0;
}

} // END WHILE
if ($i == 0){
	echo "</table>";
}else{
	echo "<td width = 50%>&nbsp;</td></tr></table>";
}
CloseTable();
include_once("../../footer.php");
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function listarticles($secid) {
global  $rcxConfig, $rcxUser, $rcxModule, $sectionsConfig, $db, $myts, $_GET;

$access = new groupAccess('listarticles');
$access->loadGroups($secid, 'secid', _MI_NSECTIONS_TABLE);
if ( !$access->checkGroups(1) ) {
	redirect_header("javascript:history.go(-1)", 3, _NOPERM);
	exit();
}

$result = $db->query("SELECT secname, image FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid=$secid");
list($secname, $image) = $db->fetch_row($result);
$secname = $myts->makeTboxData4Show($secname);

include_once("../../header.php");
OpenTable();

echo "<center>";

if ( !empty($image) ) {
	echo "<img src='".formatURL(RCX_URL. "/modules/".$rcxModule->dirname()."/cache/images/", $image)."' border='0' alt='$secname' /><br />";
}

printf(_MD_THISISSECTION, $secname);

echo
"<br /><br />"._MD_THEFOLLOWING."<br /><br />
<table border='0' width='100%' class='bg4' cellspacing='1' cellpadding='3'><tr>
<td nowrap='nowrap'>"._MD_ARTICLE."</td>
<td nowrap='nowrap'>"._MD_BY."</td>
<td nowrap='nowrap'>"._MD_ON."</td>
<td nowrap='nowrap'>"._MD_READS."</td>
<td>&nbsp;</td>
</tr>";

$result        = $db->query("SELECT COUNT(*) FROM ".$db->prefix(_MI_NSECCONT_TABLE));
list($numrows) = $db->fetch_row($result);

if ($numrows > 0) {
$_GET['show'] ? $show = $_GET['show'] : $show = 0;
$limit  = $sectionsConfig['article_limit'];

$result = $db->query("SELECT artid, title, byline, author, content, counter, date FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE secid=$secid", $limit, $show);
while (list($artid, $title, $byline, $author, $content, $counter, $date) = $db->fetch_row($result)) {
$title    = $myts->makeTboxData4Show($title);
$byline   = $myts->makeTboxData4Show($byline);
$content  = $myts->makeTareaData4Show($content);
$thisUser = new RcxUser($author);
if (!$thisUser->isActive()) { $name = _MD_UNKNOWN; } else { $name = $thisUser->uname(); }

echo "
<tr>

<td class='bg3' valign='top'>
<li>&nbsp;<a href='./index.php?op=viewarticle&artid=$artid'>$title</a></li>";
if ($byline) {
	echo "<br />$byline";
}
echo "</td>

<td class='bg2' nowrap='nowrap' align='center' valign='top'>
<a href='".RCX_URL."/userinfo.php?uid=$author'>$name</a>
</td>
<td class='bg3' nowrap='nowrap' align='center' valign='top'>". date("j/n/Y", $date)."</td>
<td class='bg2' nowrap='nowrap' align='center' valign='top'>$counter</td>


<td class='bg4' align='center' valign='top'>
<a href='./index.php?op=printpage&artid=$artid'><img src='./images/print.gif' border='0' alt='" . _MD_PRINTERPAGE."' /></a>
</td>

</tr>";
} // END WHILE
} // END NUMROWS

if ($numrows > 0) {
	$nav = new RcxPageNav($numrows, $limit, $show, "show", "op=listarticles&amp;secid=$secid");
	if ( $nav->renderNav() ) {
		$navbar = "| ".$nav->renderNav();
	}
}

echo "
</table><br />
[ <a href='./index.php'>"._MD_RETURN2INDEX."</a> $navbar ]
</center>";

CloseTable();
include_once("../../footer.php");
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function viewarticle($artid, $page) {
global $rcxUser, $rcxModule, $db, $myts, $rcxConfig, $meta, $page;

$access = new groupAccess('viewarticle');
$access->loadGroups($artid, 'artid', _MI_NSECCONT_TABLE);
if ( !$access->checkGroups(1) ) {
	redirect_header("javascript:history.go(-1)", 3, _NOACTION);
	exit();
}

if ( !isset($page) ) {
	$db->query("UPDATE ".$db->prefix(_MI_NSECCONT_TABLE)." SET counter=counter+1 WHERE artid='$artid'");
}

$result = $db->query("SELECT artid, secid, title, author, date, content, allow_html, allow_smileys, allow_bbcode, counter FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE artid=$artid");
list($artid, $secid, $title, $author, $date, $content, $allow_html, $allow_smileys, $allow_bbcode, $counter) = $db->fetch_row($result);
$title    = $myts->makeTboxData4Show($title);

$myts->setType('admin');
$content  = $myts->makeTareaData4Show($content, $allow_html, $allow_smileys, $allow_bbcode);
$thisUser = new RcxUser($author);

if (!$thisUser->isActive()) {
	$name = _MD_UNKNOWN;
	} else {
		$name = $thisUser->uname();
	}

$result2 = $db->query("SELECT secid, secname FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid=$secid");

list($secid, $secname) = $db->fetch_row($result2);
$secname      = $myts->makeTboxData4Show($secname);
$contentpages = explode( "[pagebreak]", $content );
$pages        = count($contentpages);

if ( !isset($page) || !is_numeric($page) ) {
	$page = "0";
	}

if ($page > $pages) {
	$page = $pages;
	}

$nav = new RcxPageNav($pages, 1, $page, "page", "op=viewarticle&artid=$artid");

include_once("../../header.php");

OpenTable();

echo "
<b>$title</b><br />

"._MD_PUBLISHED." <a href='".RCX_URL."/userinfo.php?uid=$author'>$name</a>
, "._MD_ON." ".date("j/n/Y", $date);

if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
	echo " [ <a href='./admin/index.php?op=secartedit&artid=$artid'>"._EDIT."</a> | <a href='./admin/index.php?op=sections&secid=$secid'>"._MD_DOADDARTICLE."</a> ]";
}

echo "

<br /><br />";

echo trim($contentpages[$page]);

echo "
<table align='center' width='100%' border='0' cellspacing='0' cellpadding='5'>
<tr>
<td align='center' colspan='2'><big>".$nav->renderNav()."</big></td>
</tr><tr>
<td colspan='2' align='center'>
[ <a href='./index.php?op=listarticles&secid=$secid'>".sprintf(_MD_BACK2SEC, $secname)."</a> | <a href='./index.php'>"._MD_RETURN2INDEX."</a> ]";
echo "
<a href='./index.php?op=printpage&artid=$artid' target=_BLANK><img src='./images/print.gif' border='0' alt='" . _MD_PRINTERPAGE."' /></a>
<a target='_top' href='mailto:?subject=".rawurlencode(sprintf(_MD_INTARTICLE, $meta['title']))."&body=".rawurlencode(sprintf(_MD_INTARTFOUND, $meta['title']).":\r\n".RCX_URL."/modules/".$rcxModule->dirname()."/index.php?op=viewarticle&artid=".$artid)."'><img src='images/friend.gif' border='0' alt='"._MD_SENDARTICLE."' /></a>
</td>
</tr></table>";

CloseTable();
include_once("../../footer.php");
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function PrintSecPage($artid) {
global $rcxConfig, $db, $myts, $meta;

$access = new groupAccess('printsecpage');
$access->loadGroups($artid, 'artid', _MI_NSECCONT_TABLE);
if ( !$access->checkGroups(1) ) {
	redirect_header("javascript:history.go(-1)", 3, _NOACTION);
	exit();
}

$result = $db->query("SELECT title, author, date, content, allow_html, allow_smileys, allow_bbcode FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE artid=$artid");
list($title, $author, $date, $content, $allow_html, $allow_smileys, $allow_bbcode) = $db->fetch_row($result);
$title    = $myts->makeTboxData4Show($title);

$myts->setType('admin');
$content  = $myts->makeTareaData4Show($content,$allow_html,$allow_smileys,$allow_bbcode);
$thisUser = new RcxUser($author);
if (!$thisUser->isActive()) { $name = _MD_UNKNOWN; } else { $name=$thisUser->uname(); }
?>
<?php echo '<?xml version="1.0" encoding="'._CHARSET.'"?>';?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $meta['langcode'];?>" lang="<?php echo $meta['langcode'];?>">
<head>
<title><?php echo $meta['title'];?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo _CHARSET;?>">
<meta http-equiv="content-language" content="<?php echo $meta['langcode'];?>">
<?php if ($meta['pragma']) { ?>
<meta http-equiv="pragma" content="no-cache">
<?php } ?>
<meta name="rating" content="<?php echo $meta['rating'];?>">
<meta name="robots" content="<?php echo $meta['index'];?>, <?php echo $meta['follow'];?>">
<meta name="generator" content="<?php echo RCX_VERSION;?>">
<meta name="keywords" content="<?php echo $meta['keywords'];?>">
<meta name="description" content="<?php echo $meta['description'];?>">
<meta name="author" content="<?php echo $meta['author'];?>">
<meta name="copyright" content="<?php echo $meta['copyright'];?>">
<?php readfile(RCX_ROOT_PATH . "/modules/system/cache/header.php");?>
<link rel="shortcut icon" href="<?php echo $meta['icon'];?>">
</head>
<body bgcolor='#ffffff' text='#000000'>
<table align='center' border='0' width='640' cellpadding='0' cellspacing='1' bgcolor='#000000'><tr><td>
<table border='0' width='640' cellpadding='20' cellspacing='1' bgcolor='#FFFFFF'><tr><td>
<div align='center'>
<?php

if (@file_exists(RCX_URL."/themes/".$rcxConfig['default_theme']."/images/logo.gif")) {
	echo "<img src='".RCX_URL."/themes/".$rcxConfig['default_theme']."/images/logo.gif' border='0' alt='".$myts->makeTboxData4Show($meta['slogan'])."' />";
	} else {
	echo "<img src='".RCX_URL."/images/logo.gif' border='0' alt='".$myts->makeTboxData4Show($meta['slogan'])."' />";
	}

echo "
</div>
<br /><br />
<font size='+2'><b>$title</b></font><br />
<font size='2'>
"._MD_PUBLISHED." <a href='".RCX_URL."/userinfo.php?uid=$author'>$name</a>
, "._MD_ON." ".formatTimestamp($date, "j/n/Y")."
<br /><br />
".str_replace("[pagebreak]","",$content)."
<br /><br />
<hr size='1' noshade='noshade' />";
echo sprintf(_MD_COMESFROM, $meta['title'])."
<br /><a href=".RCX_URL.">".RCX_URL."</a>
<br /><br />
"._MD_URLFORTHIS."
<br />
<a href='".RCX_URL."/modules/"._MI_DIR_NAME."/index.php?op=viewarticle&artid=$artid'>".RCX_URL."/modules/"._MI_DIR_NAME."/index.php?op=viewarticle&artid=$artid</a>
</font>
</td></tr></table>
</td></tr></table>
</body>
</html>";
}

switch($op) {
	case "viewarticle":
		viewarticle((int)$artid, (int)$page);
		break;
	case "listarticles":
		listarticles((int)$secid);
		break;
	case "printpage":
		PrintSecPage((int)$artid);
		break;
	default:
		listsections();
		break;
}
?>
