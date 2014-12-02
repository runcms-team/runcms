<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_faq_show($options) {
global $db, $myts;

$block  = array();
$block['content'] = "<small>";

$sql    = "
		SELECT
		contents_id, category_id, contents_title, contents_time
		FROM
		".$db->prefix("faq_contents")."
		WHERE
		contents_visible=1
		ORDER BY
		contents_time DESC";

if ( empty($options[2]) || !is_numeric($options[2]) ) {
	$options[2] = 5;
	}

if ( empty($options[1]) || !is_numeric($options[1]) ) {
	$options[1] = 19;
	}

$result = $db->query($sql, $options[2], 0);
while ( list($id, $cid, $title, $date) = $db->fetch_row($result) ) {
	$title = $myts->makeTboxData4Show($title);
	if ( strlen($title) > $options[1] ) {
		$title = substr($title, 0, $options[1])."..";
		}

	$block['content'] .= "
			&nbsp;<strong><big>&middot;</big></strong>
			<a href='".RCX_URL."/modules/faq/index.php?cat_id=".$cid."#".$id."'>".$title."</a>";

		$block['title'] = _MB_FAQ_TITLE;
		if ($options[0] == 1) {
			$block['content'] .= " (".formatTimestamp($date, "s").")";
			}
		$block['content'] .= "<br />";
	}
$block['content'] .= "</small>";

return $block;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function b_faq_edit($options) {

$form  = "<table border='0'>";

// SHOW DATE?
$form .= "<tr><td>"._MB_FAQ_SHOW.":</td><td>";

$chk   = "";
if ($options[0] == 0) {
	$chk = " checked='checked'";
	}
$form .= "<input type='radio' class='radio' name='options[0]' value='0'".$chk." />"._NO."";

$chk   = "";
if ($options[0] == 1) {
	$chk = " checked='checked'";
	}
$form .= "<input type='radio' class='radio' name='options[0]' value='1'".$chk." />"._YES."</td></tr>";

// TRIM
$form .= "
<tr><td>"._MB_FAQ_TRIM."</td>
<td><input type='text' class='text' size='3' maxlength='2' name='options[1]' value='".$options[1]."'></td>
</tr>";


// LIMIT TO
$form .= "
<tr><td>"._MB_FAQ_LIMIT."</td>
<td><input type='text' class='text' name='options[2]' value='".$options[2]."' size='3' maxlength='2' /></td>
</tr>";

$form .= "</table>";

return $form;
}
?>
