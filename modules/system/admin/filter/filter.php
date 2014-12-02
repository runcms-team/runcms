<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {

/**
* Description
*
* @param type $var description
* @return type description
*/
function filterMain($type='menu') {
global $_POST, $_GET;

if ($_POST['submit'] == _SUBMIT) {
	filterSave($type);
}

rcx_cp_header();
OpenTable();
echo '<a href="admin.php?fct=filter"><h4>'._AM_FILTERSETTINGS.'</h4></a><br />';

include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
$form = new RcxThemeForm('', "filterform", "admin.php?fct=filter", "post", true);

switch ($type) {
	case 'unames':
		$badentries = file(RCX_ROOT_PATH.'/modules/system/cache/badunames.php');
		if ( !empty($badentries) ) {
			$value = '';
			foreach ($badentries as $bad) {
				$value .= trim($bad)."\n";
			}
			$value = trim($value);
		}
		$unames_tarea  = new RcxFormTextArea(_AM_BADUNAMES."</b><br /><br />"._AM_ENTERUNAMES."<b>", "unames", $value, 10);
		$form->addElement($unames_tarea);
		$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");
		$form->addElement($submit_button);

		$op   = new RcxFormHidden('op', 'unames');
		$form->addElement($op);
		$form->display();
		break;

	case 'emails':
		$badentries = file(RCX_ROOT_PATH.'/modules/system/cache/bademails.php');
		if ( !empty($badentries) ) {
			$value = '';
			foreach ($badentries as $bad) {
				$value .= trim($bad)."\n";
			}
			$value = trim($value);
		}
		$emails_tarea = new RcxFormTextArea(_AM_BADEMAILS."</b><br /><br />"._AM_ENTEREMAILS."<b>", "emails", $value, 10);
		$form->addElement($emails_tarea);
		$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");
		$form->addElement($submit_button);

		$op   = new RcxFormHidden('op', 'emails');
		$form->addElement($op);
		$form->display();
		break;

	case 'words':
		$badentries = file(RCX_ROOT_PATH.'/modules/system/cache/badwords.php');
		if ( !empty($badentries) ) {
			$value = '';
			foreach ($badentries as $bad) {
				$value .= trim($bad)."\n";
			}
			$value = trim($value);
		}
		$words_tarea   = new RcxFormTextArea(_AM_BADWORDS."<br /><br /></b>"._AM_ENTERWORDS."<b>", "words", $value, 10);
		$form->addElement($words_tarea);
		$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");
		$form->addElement($submit_button);

		$op = new RcxFormHidden('op', 'words');
		$form->addElement($op);
		$form->display();
		break;

	case 'ips':
		$value      = '';
		$badentries = file(RCX_ROOT_PATH.'/modules/system/cache/badips.php');

		if ( !empty($badentries) ) {
			foreach ($badentries as $bad) {
				$value .= trim($bad)."\n";
			}
		}

		$add_ip = $_GET['add_ip'];
		if (!empty($add_ip)) {
			$value .= "#".preg_quote(trim($add_ip))."#\n";
		}

		$value = trim($value);
		$ips_tarea = new RcxFormTextArea(_AM_BADIPS."</b><br /><br />"._AM_ENTERIPS."<br /><div class='rcxquote'>"._AM_BADIPSTART."<br />"._AM_BADIPEND."<br />"._AM_BADIPCONTAIN."<b></div>", "ips", $value, 10);
		$form->addElement($ips_tarea);
		$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");
		$form->addElement($submit_button);

		$op = new RcxFormHidden('op', 'ips');
		$form->addElement($op);
		$form->display();
		break;

	case 'agents':
		$badentries = file(RCX_ROOT_PATH.'/modules/system/cache/badagents.php');
		if ( !empty($badentries) ) {
			$value = '';
			foreach ($badentries as $bad) {
				$value .= trim($bad)."\n";
			}
			$value = trim($value);
		}
		$agents_tarea = new RcxFormTextArea(_AM_BADAGENTS."</b><br /><br />"._AM_ENTERAGENTS."<br /><div class='rcxquote'>"._AM_BADAGENTSSTART."<br />"._AM_BADAGENTSEND."<br />"._AM_BADAGENTSCONTAIN."<b></div>", "agents", $value, 10);
		$form->addElement($agents_tarea);
		$submit_button = new RcxFormButton("", "submit", _SUBMIT, "submit");
		$form->addElement($submit_button);

		$op   = new RcxFormHidden('op', 'agents');
		$form->addElement($op);
		$form->display();
		break;

	default:
	echo '<ul><li><a href="admin.php?fct=filter&op=unames">'._AM_BADUNAMES.'</a></li>';
	echo '<li><a href="admin.php?fct=filter&op=emails">'._AM_BADEMAILS.'</a></li>';
	echo '<li><a href="admin.php?fct=filter&op=words">'._AM_BADWORDS.'</a></li>';
	echo '<li><a href="admin.php?fct=filter&op=ips">'._AM_BADIPS.'</a></li>';
	echo '<li><a href="admin.php?fct=filter&op=agents">'._AM_BADAGENTS.'</a></li></ul>';
	break;
}
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function filterSave($name) {
global $myts;

$rcx_token = & RcxToken::getInstance();

if ( !$rcx_token->check() ) {
    redirect_header('admin.php?fct=filter&op=' . $name, 3, $rcx_token->getErrors(true));
    exit();
}

if (!@is_writable(RCX_ROOT_PATH."/modules/system/cache/bad".$name.".php")) {
	$errors[] = sprintf(_MUSTWABLE, RCX_ROOT_PATH."/modules/system/cache/bad$name.php");
	return false;
}

$errors   = array();
$filter   = array();
$filtered = $myts->oopsNl2Br($myts->oopsStripSlashesGPC(trim($myts->stripPHP($_POST[$name]))));
$filter   = explode("<br />", $filtered);

if (!$file = @fopen(RCX_ROOT_PATH."/modules/system/cache/bad$name.php", "w")) {
	$errors[] = sprintf(_MUSTWABLE, RCX_ROOT_PATH."/modules/system/cache/bad$name.php");
	} else {
		$output = "";
		foreach ($filter as $entry) {
			$output .= $entry."\n";
		}
		if (fwrite($file, $output) == -1) {
			$errors[] = sprintf(_NGWRITE, RCX_ROOT_PATH."/modules/system/cache/bad$name.php");
		}
		fclose($file);
	}

if (count($errors) > 0) {
	rcx_cp_header();
	OpenTable();
	echo '<a href="admin.php?fct=filter"><h4>'._AM_FILTERSETTINGS.'</h4></a><br />';
	foreach ($errors as $er) {
		echo $er."<br />";
	}
	} else {
		redirect_header("admin.php?fct=filter&op=$name", 1, _UPDATED);
		exit();
	}

}


/**
* Description
*
* @param type $var description
* @return type description
*/
$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch($op) {

case 'words':
	filterMain('words');
	break;

case 'ips':
case 'add_ip':
	filterMain('ips');
	break;

case 'unames':
	filterMain('unames');
	break;

case 'emails':
	filterMain('emails');
	break;

case 'agents':
	filterMain('agents');
	break;

default:
	filterMain();
}

CloseTable();
rcx_cp_footer();

}
?>
