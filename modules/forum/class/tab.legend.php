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

class TabLegend extends TabPage
{
	function TabLegend($type)
	{
		$this->title = _MD_TAB_LEGEND;
		switch($type)
		{
			case LEGEND_INDEX:
			{
				$this->init_index();
				break;
			}
			case LEGEND_FORUM:
			{
				$this->init_forum();
				break;
			}
		}
	}

	function init_index()
	{
		global $bbImage;

		$this->content  = '<table width="100%" align="left"><tr><td align="left">';
		$this->content .= '<img src="'.$bbImage['newposts'].'" alt="#" align="left" /> = '._MD_NEWPOSTS.'.<br /><br />';
		$this->content .= '<img src="'.$bbImage['folder'].'" alt="#" align="left" /> = '._MD_NONEWPOSTS;
		$this->content .= '</td></tr></table>';
	}

	function init_forum()
	{
		global $bbImage;

		$this->content  = '<table width="100%">';
		$this->content .= '<tr>';
        $this->content .= '<td align="left" ><img src="'.$bbImage['newposts'].'" alt="#" align="left" /> = '._MD_NEWPOSTS.'.</td>';
        $this->content .= '<td align="left"><img src="'.$bbImage['hot_newposts'].'" alt="#" align="left" /> = '._MD_MORETHAN.'.</td>';
        $this->content .= '</tr>';
        $this->content .= '<tr>';
        $this->content .= '<td align="left" ><img src="'.$bbImage['folder'].'" alt="#" align="left" /> = '._MD_NONEWPOSTS.'.</td>';
        $this->content .= '<td align="left"><img src="'.$bbImage['hot_folder'].'" alt="#" align="left" /> = '._MD_MORETHAN2.'.</td>';
        $this->content .= '</tr>';
		$this->content .= '<tr>';
		$this->content .= '<td align="left"><img src="'.$bbImage['locked'].'" alt="#" align="left" /> = '._MD_TOPICLOCKED.'.</td>';
		$this->content .= '<td align="left" ><img src="'.$bbImage['sticky'].'" alt="#" align="left" /> = '._MD_TOPICSTICKY.'.</td>';
		$this->content .= '</tr>';
		$this->content .= '</table>';
	}
}
?>