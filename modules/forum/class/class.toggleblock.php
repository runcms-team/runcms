<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH')) {
	exit();
}
class ToggleBlockRenderer
{
	function render($id, $title, $link, $content)
	{
		echo ToggleBlockRenderer::renderHTML($id, $title, $link, $content);
	}

	function renderHTML($id, $title, $link, $content)
	{
		global $_COOKIE;
		
		$bShow = true;
		if (isset($_COOKIE['forum_collapse']))
		{
			$arrCollapse = split(',',$_COOKIE['forum_collapse']);
			$bShow = (in_array($id, $arrCollapse)) ? true : false;
		}

		$show = ($bShow) ? 'block;' : 'none;';
		$img  = ($bShow) ? 'images/minus.gif' : 'images/plus.gif';
		
		$href = (!empty($link)) ? "<a href='$link'>" : '';

		$retHTML = "
<!-- START: ToggleBlockRenderer -->
<table border='0' width='100%' cellpadding='0' cellspacing='0' align='center' valign='top'>
<tr><td class='bg2'>
<table border='0' cellpadding='1' cellspacing='1' width='100%'>
	<tr align='left' valign='top'>
		<td class='bg4'>
			<table width='100%'><tr>
			<td>$href<b>$title</b></a></td>
			<td class='bg4'align='right'><img src='$img' onclick=\"toggle_block('$id', this)\" alt='#' /></td>
			</tr></table>
		</td>
	</tr>
</table>
<div id='$id' style='display: $show'>
$content
</div>
</td></tr>
</table>
<!-- END: ToggleBlockRenderer -->
		";

		return $retHTML;
	}
}

?>