<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( isset($_POST['action']) && ($_POST['action'] == 'upgrade' || $_POST['action'] == 'install') ) {
	header('Location: '.$_POST['action'].'.php');
	} else {
		include_once('include/functions.php');
		wiz_header();
		?>
		<div align="center">
		<h2><?php printf(_INSTALL_W_WELCOME, RCX_VERSION);?></h2>
		<br /><br />
		<h3><?php echo _INSTALL_W_CHOOSE;?></h3>
		<form method="post" action="index.php">
		<select class="select" name="action">
		<option  value="install" selected><?php echo _INSTALL_W;?></option>
                <option value="upgrade" ><?php echo _UPDATE;?></option>
	
		</select>
		<input type="submit" class="button" name="submit" value="<?php echo _SUBMIT;?>" />
		</form>
		</div>
		<br /><br />
		<?php
		wiz_footer();
	}
?>
