<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("../mainfile.php");
include_once(RCX_ROOT_PATH."/themes/".getTheme()."/theme.php");
include_once(RCX_ROOT_PATH."/class/rcxmailer.php");
$rcxMailer = unserialize(urldecode($_POST['mail']));
if (!strtolower(get_class($rcxMailer)) == 'rcxmailer') {
	exit();
}
rcx_header();
$user_count  = count($rcxMailer->toUsers);
$email_count = count($rcxMailer->toEmails);
echo "<br /><div align='center'><h5>".sprintf(_XM_LEFT, ($user_count+$email_count))."</h5></div>";
OpenTable();
if ( $user_count > 0 ) {
	$i=0;
	$toUsers = $rcxMailer->toUsers;
	foreach ($toUsers as $key => $value) {
		$i++;
		unset($rcxMailer->errors);
		unset($rcxMailer->success);
		unset($rcxMailer->toUsers);
		$rcxMailer->toUsers[$key] = $value;
		$rcxMailer->send();
		echo $rcxMailer->getSuccess();
		echo $rcxMailer->getErrors();
		unset($toUsers[$key]);
		if ($i == 3) {
			break;
		}
	}
	$rcxMailer->toUsers = $toUsers;
	} elseif ($email_count > 0) {
		$i=0;
		$toEmails = $rcxMailer->toEmails;
		foreach ($toEmails as $key => $value) {
			$i++;
			unset($rcxMailer->errors);
			unset($rcxMailer->success);
			unset($rcxMailer->toEmails);
			$rcxMailer->toEmails[$key] = $value;
			$rcxMailer->send();
			echo $rcxMailer->getSuccess();
			echo $rcxMailer->getErrors();
			unset($toEmails[$key]);
			if ($i == 3) {
				break;
			}
		}
		$rcxMailer->toEmails = $toEmails;
	}
CloseTable();
if ( !empty($rcxMailer->toUsers) || !empty($rcxMailer->toEmails) ) {
	$rcxMailer = urlencode(serialize($rcxMailer));
	?>
	<form action="<?php echo RCX_URL;?>/include/mailtoggle.php" method="post" id="toggle" name="toggle" target="_self">
	<input type="hidden" name="mail" value="<?php echo $rcxMailer;?>" />
	<input type="image" class="image" src="<?php echo RCX_URL;?>/images/pixel.gif" />
	</form>
	<script type="text/javascript">
		rcxGetElementById("toggle").submit();
	</script>
	<?php
	} else {
		echo "<br /><div align='center'><input type='button' class='button' value='"._DONE."' onclick='self.close();' /></div>";
	}
rcx_footer(0);
?>
