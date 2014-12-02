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
$lid = intval($_GET['lid']);

$db->query("UPDATE ".$db->prefix("links_links")." SET hits=hits+1 WHERE lid=$lid AND status>0");
$result = $db->query("SELECT url FROM ".$db->prefix("links_links")." WHERE lid=$lid AND status>0");
list($url) = $db->fetch_row($result);

header("Location: $url");
echo "<html><head><meta http-equiv='Refresh' content='0; URL=$url'></meta></head><body></body></html>";
exit();
?>
