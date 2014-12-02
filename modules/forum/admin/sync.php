<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('./admin_header.php');
?>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="center"><td colspan=7><div style='text-align: center;' class='KPmellem' /><b><?php echo _MD_A_SYNCFORUM;?></b></td></tr>
</table>
</table>
<br><br>
<?php
if ($_POST['submit'])
{
		echo _MD_A_SYNCHING . "<br />";
		flush();
		sync(null, "all forums");
		flush();
		sync(null, "all topics");
		echo "<br />";
		echo _DONE;
} 
else
{
?>
		<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="75%"><tr>
		<td class="bg2">
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr class="bg3" align="left">
		<td><?php echo _MD_A_CLICKBELOWSYNC; ?></td>
		</tr><tr class="bg1" align="center">
		<td>
		<center><br /><form action="./sync.php" method="post">
		<input type="hidden" name="mode" value="sync">
		<input type="submit" class="button" name="submit" value="<?php echo _MD_A_START; ?>">
		</center></form>
		</td>
		</td></tr></table>
		</td></tr></table>
<?php
} 
?>
<br><br>
<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" width="75%"><tr><td class="bg2">
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr class="bg3" align="center"><td><br /><center><input type="button" value="<?php echo _MD_A_BACK_TO_FM;?>" class="button" onclick="javascript:window.location='forum_manager.php'"></center><br /></td></tr>
</table></table>
<?php
CloseTable();
rcx_cp_footer();
exit();

?>
