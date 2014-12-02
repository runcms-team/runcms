<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$rcxOption['nocache'] = 1;
include_once('../../mainfile.php');

if ($rcxUser) {
	$rcxModule = RcxModule::getByDirname('system');
	if ( !$rcxUser->isAdmin($rcxModule->mid()) ) {
		redirect_header(RCX_URL.'/', 3, _NOPERM);
		exit();
	}
	} else {
		redirect_header(RCX_URL.'/', 3, _NOPERM);
		exit();
	}

if ( !empty($_GET['file']) && @file_exists($_GET['file']) ) {
	echo '<html><head><title>'._DBG_OUTPUT.': '.$file.'</title>
		<script type="text/javascript">
		<!--
		self.moveTo(0,0);
		self.resizeTo(screen.availWidth,screen.availHeight);
		self.focus();
		// -->
		</script></head><body>';

	echo ex_highlight($_GET['file'], $_GET['line']);
	echo '</body></html>';
	} else {
		redirect_header(RCX_URL.'/', 1, _TAKINGBACK);
		exit();
	}

/**
* Description
*
* @param type $var description
* @return type description
*/
function ex_highlight($file, $line=0) {

ob_start();
highlight_file($file);
$content = ob_get_contents();
ob_end_clean();

$content = explode('<br />', $content);
$size    = count($content);

if (!empty($size)) {
	$size = ($size-1);
}

for ($i=0; $i<$size; $i++) {
	if ( $line && ($line == ($i+1)) ) {
		$content[$i] = '<span style="background-color: #F8F8FF;"><span style="color:#999999">'.($i+1).'&nbsp;</span><a name="'.($i+1).'" />'.$content[$i].'</span>';
		} else {
			$content[$i] = '<span style="color:#999999">'.($i+1).'&nbsp;</span><a name="'.($i+1).'" />'.$content[$i].'';
		}
}

$content = implode('<br />', $content);

return $content;
}
?>
