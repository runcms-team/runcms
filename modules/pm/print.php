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
include_once(RCX_ROOT_PATH.'/include/functions.php');

if (!$rcxUser) {
        $errormessage = _PM_SORRY.'<br />'._PM_PLZREG;
        redirect_header('user.php', 2, $errormessage);

exit();
}
// if GET/POST is set, change $op
if ( isset($_POST['op']) ) {
        $op =  $_POST['op'];
        } elseif ( isset($_GET['op']) ) {
                $op =  $_GET['op'];
}

if ( isset($_POST['msg_id']) ) {
        $msg =  (int)$_POST['msg_id'];
        } elseif ( isset($_GET['msg_id']) ) {
                $msg =  (int)$_GET['msg_id'];
}

if (empty($msg)) {
        redirect_header("index.php", 2, _PM_NOPNTOPRINT);
        exit();
}

if ($op == "print_pn") {
     $sql = "SELECT msg_id, subject, from_userid, to_userid, msg_time, msg_text FROM ".$db->prefix("pm_msgs")." WHERE msg_id=".$msg." ";
}

if ($op == 'print_sent_pn') {
     $sql = "SELECT msg_id, subject, from_userid, to_userid, msg_time, msg_text FROM ".$db->prefix("pm_msgs_sent")." WHERE msg_id=".$msg."";
}


if ( !$result = $db->query($sql) ) {
     $error = "<h4>"._MD_ERROROCCURED."</h4><hr />"._MD_COULDNOTQUERY;
     redirect_header("index.php", 2, $error);
     exit();
} else {
     list($msg_id, $subject, $from_userid, $to_userid, $msg_time, $msg_text) = $db->fetch_row($result);
}

if ( !headers_sent() ) {
        if ( !empty($meta['p3p']) ) {
                header("P3P: CP='".$meta['p3p']."'");
        }
        if ( $rcxUser || ($meta['pragma'] == 1) ) {
                header("Expires: Sat, 18 Aug 2002 05:30:00 GMT");
                header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
                header("Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0");
        }
}
?>
<html>
<head>
<title><?php echo $meta['title'];?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo _CHARSET;?>">
<meta http-equiv="content-language" content="<?php echo _LANGCODE;?>">
<meta name="rating" content="<?php echo $meta['rating'];?>">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta name="generator" content="<?php echo RCX_VERSION;?>">
<meta name="author" content="<?php echo $meta['author'];?>">
<meta name="copyright" content="<?php echo $meta['copyright'];?>">
<?php include_once(RCX_ROOT_PATH ."/include/rcxjs.php");?>
<link href="<?php echo RCX_URL;?>/include/style.css" rel="stylesheet" type="text/css" />
<?php

$themecss = getcss(getTheme());
if ($themecss) {
        echo "
        <style type='text/css' media='all'>
        <!-- @import url($themecss); -->
        </style>";
}

$pm_from = RcxUser::getUnameFromId($from_userid);
$pm_to = RcxUser::getUnameFromId($to_userid);

$subject = $myts->makeTareaData4Show($subject,1,1,1);

$msg_text = $myts->makeTareaData4Show($msg_text,1,1,1);

$msg_time = formatTimestamp($msg_time);

echo "</head><body >";

if (@file_exists(RCX_URL."/themes/".$rcxConfig['default_theme']."/images/logo.gif")) {
	echo "<img src='".RCX_URL."/themes/".$rcxConfig['default_theme']."/images/logo.gif' border='0' alt='".$myts->makeTboxData4Show($meta['slogan'])."' />";
	} else {
		echo "<img src='".RCX_URL."/images/logo.gif' border='0' alt='".$myts->makeTboxData4Show($meta['slogan'])."' />";
	}
echo"<table border='0' width='640' cellpadding='10' cellspacing='0' bgcolor='#FFFFFF'><tr><td>";
echo "<font size='+1'><b>"._PM_MESSAGEC."</b></font><br /><br />";
echo "<font size='2'><b>"._PM_FROM.":</b> ".$pm_from."</font><br><br>";
echo "<font size='2'><b>"._PM_AN.":</b> ".$pm_to."</font><br><br>";
echo "<font size='2'><b>"._PM_DATE."</b> ".$msg_time."</font><br><br>";
echo "<font size='2'><b>"._PM_SUBJECTC." ".$subject."</b></font><br /><br />";
echo"<hr />";
echo "<br><br> ".$msg_text."<br><br>";
echo"<tr><td><br />
<i><b>".$meta['']."<br />
<br />
</b></i>
<form><center><input type='button' value='"._PM_PRINT."' onClick='window.print()'></input>&nbsp;&nbsp;&nbsp;
<input type='button' value='"._CLOSE."' onClick='window.close()'></input>
</form></center></td></tr>";
echo "</table></body></html>";
?>