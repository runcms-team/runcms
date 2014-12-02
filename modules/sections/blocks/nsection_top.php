<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_nsection_top_show($options) {
global $db, $myts;

$block  = array();
$block['content'] = "";

$sql    = "
		SELECT artid, title, date, counter
		FROM ".$db->prefix("nseccont")."
		WHERE date<".time()." ORDER BY ".$options[0]." DESC";

if ( empty($options[3]) || !is_numeric($options[3]) ) {
	$options[3] = 5;
	}

if ( empty($options[2]) || !is_numeric($options[2]) ) {
	$options[2] = 19;
	}

$result = $db->query($sql, $options[3], 0);
while ( list($artid, $title, $date, $counter) = $db->fetch_row($result) ) {
	$title = $myts->makeTboxData4Show($title);
	if ( strlen($title) > $options[2] ) {
		$title = substr($title, 0, $options[2])."..";
		}

	$block['content'] .= "
			&nbsp;<strong><big>&middot;</big></strong>
			<a href='".RCX_URL."/modules/sections/index.php?op=viewarticle&artid=".$artid."'>".$title."</a>";

	if ($options[0] == "date") {
		$block['title'] = _MB_NSECTIONS_TITLE1;
		if ($options[1] == 1) {
			$block['content'] .= " (".formatTimestamp($date, "s").")";
			}
		$block['content'] .= "<br />";

		} elseif ($options[0] == "counter") {
			$block['title'] = _MB_NSECTIONS_TITLE2;
			if ($options[1] == 1) {
				$block['content'] .= " (".$counter.")";
				}
			$block['content'] .= "<br />";
		}
	}
$block['content'] .= "";

return $block;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function b_nsection_top_edit($options) {

$form  = "<input type='hidden' name='options[0]' value='".$options[0]."' />";
$form .= "<table border='0'>";

// SHOW DATE/HITS?
$form .= "<tr><td>"._MB_NSECTIONS_SHOW." ".$options[0].":</td><td>";

$chk   = "";
if ($options[1] == 0) {
	$chk = " checked='checked'";
	}
$form .= "<input type='radio' class='radio' name='options[1]' value='0'".$chk." />"._NO."";

$chk   = "";
if ($options[1] == 1) {
	$chk = " checked='checked'";
	}
$form .= "<input type='radio' class='radio' name='options[1]' value='1'".$chk." />"._YES."</td></tr>";

// TRIM
$form .= "
<tr><td>"._MB_NSECTIONS_TRIM."</td>
<td><input type='text' class='text' size='3' maxlength='2' name='options[2]' value='".$options[2]."'></td>
</tr>";


// LIMIT TO
$form .= "
<tr><td>"._MB_NSECTIONS_LIMIT."</td>
<td><input type='text' class='text' name='options[3]' value='".$options[3]."' size='3' maxlength='2' /></td>
</tr>";

$form .= "</table>";

return $form;
}
?>
