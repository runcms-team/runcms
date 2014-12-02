<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
ob_start();
include_once('include/functions.php');

if ( !empty($_POST['action']) ) {
	include_once('../mainfile.php');
	$package = $_POST['action'];

	if ( file_exists('upgrade/'.$package.'/language/'.$rcxConfig['language'].'/main.php') ) {
		include_once('upgrade/'.$package.'/language/'.$rcxConfig['language'].'/main.php');
		} elseif ( file_exists('upgrade/'.$package.'/language/english/main.php') ) {
			include_once('upgrade/'.$package.'/language/english/main.php');
		}

	wiz_header(_UPGRADE_TITLE);
	if ( file_exists('upgrade/'.$package.'/language/'.$rcxConfig['language'].'/readme.txt') ) {
		echo "<div align='center'>";
		printf(_INSTALL_U_README, 'upgrade/'.$package.'/language/'.$rcxConfig['language'].'/readme.txt');
		echo "</div><br /><br />";
		} elseif ( file_exists('upgrade/'.$package.'/language/english/readme.txt') ) {
			echo "<div align='center'>";
			printf(_INSTALL_U_README, 'upgrade/'.$package.'/language/english/readme.txt');
			echo "</div><br /><br />";
		}

	if ( empty($_POST['upgrade']) ) {
		if ( file_exists('upgrade/'.$package.'/language/'.$rcxConfig['language'].'/main.html') ) {
			readfile('upgrade/'.$package.'/language/'.$rcxConfig['language'].'/main.html');
			} elseif ( file_exists('upgrade/'.$package.'/language/english/main.html') ) {
				readfile('upgrade/'.$package.'/language/english/main.html');
			}

		?>
		<div align="center">
		<form method="post" action="upgrade.php">
		<input type="hidden" name="action" value="<?php echo $package;?>">
		<input type="hidden" name="upgrade" value="1">
		<input type="submit" class="button" name="submit" value="<?php echo _SUBMIT;?>">
		</form>
		</div>
		<?php

		} else {
			echo "<table width='75%' align='center'><tr><td>";
			if (defined('_UPGRADE_HEADER')) {
				echo _UPGRADE_HEADER;
			}
			include_once('upgrade/'.$package.'/sql.php');
			if (defined('_UPGRADE_FOOTER')) {
				echo _UPGRADE_FOOTER;
			}
			echo "</td></tr></table>";
		}

	} else {
		wiz_header(_UPDATE);
		include_once('../class/rcxlists.php');
		$upgrade_options = RcxLists::getDirListAsArray('upgrade/');
		?>
		<div align="center"><br />
		<?php echo _INSTALL_U_CHOOSE;?><br />
		<form method="post" action="upgrade.php">
		<select class="select" name="action">
		<?php
		foreach ($upgrade_options as $key) {
			echo "<option value='$key'>$key</option>";
		}
		?>
		</select>
		<input type="submit" class="button" name="submit" value="<?php echo _SUBMIT;?>">
		</form>
		(<?php echo _INSTALL_U_NOTE;?>)
		<br /><br />
		</div>
		<?php
	}

wiz_footer();
ob_end_flush();
?>
