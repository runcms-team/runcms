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
if ( empty($storyid) ) {
	redirect_header("index.php");
	} else {
		$storyid = intval($storyid);
	}
include_once(RCX_ROOT_PATH."/modules/".$rcxModule->dirname()."/class/class.newsstory.php");
/**
* Description
*
* @param type $var description
* @return type description
*/
function PrintPage($storyid) {
global $rcxModule, $rcxConfig, $meta, $myts;
?>
<?php echo '<?xml version="1.0" encoding="'._CHARSET.'"?>';?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $meta['langcode'];?>" lang="<?php echo $meta['langcode'];?>">
<head>
<title><?php echo $meta['title'];?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo _CHARSET;?>"/>
<meta http-equiv="content-language" content="<?php echo $meta['langcode'];?>"/>
<?php if ($meta['pragma']) { ?>
<meta http-equiv="pragma" content="no-cache"/>
<?php } ?>
<meta name="rating" content="<?php echo $meta['rating'];?>"/>
<meta name="robots" content="<?php echo $meta['index'];?>, <?php echo $meta['follow'];?>"/>
<meta name="generator" content="<?php echo RCX_VERSION;?>"/>
<meta name="keywords" content="<?php echo $meta['keywords'];?>"/>
<meta name="description" content="<?php echo $meta['description'];?>"/>
<meta name="author" content="<?php echo $meta['author'];?>"/>
<meta name="copyright" content="<?php echo $meta['copyright'];?>"/>
<?php readfile(RCX_ROOT_PATH . "/modules/system/cache/header.php");?>
<link rel="shortcut icon" href="<?php echo $meta['icon'];?>"/>
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
$story    = new NewsStory($storyid);
$datetime = formatTimestamp($story->published(), 's');
echo "</div>
<br /><br />
<font size='+2'><b>".$story->title()."</b></font><br />
<font size='2'><b>"._NW_TOPICC."</b>&nbsp;".$story->topic_title()." <b>"._NW_DATE.":</b>&nbsp;".$datetime."</font>
<br /><br />".$story->hometext();
if ($bodytext = $story->bodytext()) {
	$bodytext = str_replace("[pagebreak]", "", trim($story->bodytext()));
	echo $bodytext."<br /><br />";
}
echo "
<br /><br />
<hr size='1' noshade='noshade' />";
echo sprintf(_NW_THISCOMESFROM, $meta['title'])."
<br /><a href=".RCX_URL.">".RCX_URL."</a>
<br /><br />"._NW_URLFORSTORY."<br />
<a href='".RCX_URL."/modules/".$rcxModule->dirname()."/article.php?storyid=".$story->storyid()."'>".RCX_URL."/article.php?storyid=".$story->storyid()."</a>
</td></tr></table>
</td></tr></table>
</body>
</html>";
}
PrintPage($storyid);
?>
