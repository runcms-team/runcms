<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("header.php");

if ($_POST[submit]) {
	if (!$rcxUser) {
		$sender = 0;
		} else {
			$sender = $rcxUser->uid();
		}

$lid = intval($_POST['lid']);
$ip  = _REMOTE_ADDR;

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_broken")." WHERE lid=$lid");
list($count) = $db->fetch_row($result);
if ($count > 0) {
	redirect_header("index.php", 2, _MD_ALREADYREPORTED);
	exit();
}

$newid = $db->genId($db->prefix("links_broken")."_reportid_seq");
$query = "INSERT INTO ".$db->prefix("links_broken")." SET reportid=$newid, lid=$lid, sender=$sender, ip='$ip'";

$db->query($query);
redirect_header("index.php", 2, _MD_THANKSFORINFO);
exit();

} else {
include_once(RCX_ROOT_PATH."/header.php");

$lid = intval($_GET['lid']);
OpenTable();
mainheader();

echo "
<h4>"._MD_REPORTBROKEN."</h4>
<form action='brokenlink.php' method='POST'>
<input type='hidden' name='lid' value='$lid' />
"._MD_THANKSFORHELP."
<br />"._MD_FORSECURITY."<br /><br />
<input type='submit' class='button' name='submit' value='"._MD_REPORTBROKEN."' />
<input type='button' class='button' value='"._CANCEL."' onclick='javascript:history.go(-1)' />
</form>";

CloseTable();
}

include_once("footer.php");
?>
