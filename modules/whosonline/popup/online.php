<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("../../../mainfile.php");
rcx_header();
$isadmin = 0;

echo "
<table width='100%'>
<tr class='bg2'><td colspan='2' align='center'><b><u>"._WHOSONLINE."</u></b></td></tr>
<tr><td colspan='2'>&nbsp;</td></tr>";

if ($rcxUser) {
	if ($rcxUser->isAdmin()) {
		$sql = "SELECT uid, username, ip FROM ".$db->prefix("lastseen")." WHERE online=1 ORDER BY time DESC";
		$isadmin = 1;
		} else {
			$sql = "SELECT uid, username FROM ".$db->prefix("lastseen")." WHERE uid>0 AND online=1 ORDER BY time DESC";
		}
	} else {
		$sql = "SELECT uid, username FROM ".$db->prefix("lastseen")." WHERE uid>0 AND online=1 ORDER BY time DESC";
	}

$result = $db->query($sql);

if (!$db->num_rows($result)) {
	echo "<tr class='bg3'><td colspan='2'>"._NOUSRONLINE."</td></tr>";
	} else {
		if ($isadmin == 1) {
			while ( list($uid, $username, $ip) = $db->fetch_row($result) ) {
				echo "<tr class='bg3'><td>";
				if ($uid > 0) {
					echo "<a href='javascript:window.opener.location=\"".RCX_URL."/userinfo.php?uid=".$uid."\";window.close();'>$username</a>";
					} else {
						echo $rcxConfig['anonymous'];
					}
	// testing geo ip 
		//	echo "</td><td><a href='http://www.geoiptool.com/en/?IP=$ip' target='_blank'>$ip</a></td></tr>";
		//	echo "</td><td><a href='http://www.samspade.org/whois/$ip' target='_blank'>$ip</a></td></tr>";
        // test Ny geo ip
			echo "</td><td><a href='http://www.geoip.co.uk/?IP=$ip' target='_blank'>$ip</a></td></tr>";


			}
		} else {
			while ( list($uid, $username) = $db->fetch_row($result) ) {
				echo "<tr class='bg3'><td colspan='2'><a href='javascript:window.opener.location=\"".RCX_URL."/userinfo.php?uid=".$uid."\";window.close();'>$username</a></td></tr>";
			}
		}
	}

echo "<tr><td colspan='2' align='center'><br /><input value='"._CLOSE."' type='button' class='button' onclick='javascript:window.close();' /></td></tr></table>";

rcx_footer(0);
?>
