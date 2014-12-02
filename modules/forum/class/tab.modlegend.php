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
define('LEGEND_INDEX', 1);
define('LEGEND_FORUM', 2);

class TabModLegend extends TabPage
{
	function TabModLegend()
	{
		$this->title = _MD_TAB_MODLEGEND;
		$this->init();
	}

	function init()
	{
		$this->content  = '<table width="100%" align="left" ><tr><td align="left" >';

		$this->content .= '<table><tr><td align="left" style="BACKGROUND-COLOR: #daaaaa">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>'._MD_TAB_UNAPPR_POSTS.'</td></table>';
		$this->content .= '<table><tr><td align="left" style="BACKGROUND-COLOR: #aadaaa">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>'._MD_TAB_UNAPPR_ATTACH.'</td></table>';
		$this->content .= '<table><tr><td align="left" style="BACKGROUND-COLOR: #6495ED">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>'._MD_TAB_UNAPPR_BOTH.'</td></table>';

		$this->content .= '</td></tr></table>';
	}
}

?>