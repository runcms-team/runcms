<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

/**
* Diplays the block
*
* @param array $options Contains array of options passed to block
* @return array Returns the contents of the block
*/
function b_partners_show($options) {
global $db, $myts;

include(RCX_ROOT_PATH ."/modules/partners/cache/config.php");

$sql = "SELECT id, url, image, title FROM ".$db->prefix("partners")." WHERE status=1 ORDER BY";

if ( !empty($partners_brandomize) ) {
	$sql .= " RAND(),";
	}

$sql .= " $partners_border $partners_borderd";

if ( !empty($partners_blimit) ) {
	$sql .= " LIMIT $partners_blimit";
	}

$result = $db->query($sql);

$block = array();
$block['title']   = _MB_PARTNERS_TITLE;
$block['content'] = '<div align="'.$options[1].'">';

if ( empty($options[2]) || !is_numeric($options[2]) ) {
	$options[2] = 19;
	}

while (list($id, $url, $image, $title) = $db->fetch_row($result)) {
	$url   = $myts->makeTboxData4Show($url);
	$title = $myts->makeTboxData4Show($title);
	if ( strlen($title) > $options[2] ) {
		$title = substr($title, 0, $options[2])."..";
		}

	$block['content'] .= '<a href="'.RCX_URL.'/modules/partners/index.php?op=visit_partner&amp;id='.$id.'" target="_blank">';

	if ( !empty($image) && ($partners_bshow == 1 || $partners_bshow == 3) ) {
		$block['content'] .= '<img src="'.formatURL(RCX_URL . "/modules/partners/cache/images/", $image).'" border="0" alt="'.$url.'" />';
		}
	if ( $partners_bshow == 3 ) {
		$block['content'] .= '<br />';
		}
	if ( empty($image) || $partners_bshow == 2 || $partners_bshow == 3 ) {
		$block['content'] .= $title;
		}

	$block['content'] .= '</a><br />';

	if ($options[0] == 1) {
		$block['content'] .= '<br />';
		}

	}
	$block['content'] .= '</div>';

return $block;
}

/**
* Configures the blocks different options
*
* @param array $options Array of current options set for the block
* @return string The form needed to edit the with options preset.
*/
function b_partners_edit($options) {

$form  = "<table border='0'>";

// SPACES
$form .= "<tr><td>"._MB_PARTNERS_PSPACE."</td><td>";

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

// ALIGN
$form .= "
<tr>
<td>"._MB_PARTNERS_ALIGN."</td>
<td>
<select class='select' name='options[1]'>
<option value='".$options[1]."'>".$options[1]."</option>
<option value='left'>"._LEFT."</option>
<option value='right'>"._RIGHT."</option>
<option value='center'>"._CENTER."</option>
</select></td></tr>";

// TRIM
$form .= "
<tr><td>"._MB_PARTNERS_TRIM."</td>
<td><input type='text' class='text' size='3' maxlength='2' name='options[2]' value='".$options[2]."'></td>
</tr>";

$form .= "</table>";

return $form;
}
?>
