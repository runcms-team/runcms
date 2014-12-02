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
class TabSearch extends TabPage
{
	function TabSearch()
	{
		$this->title = _SEARCH;
		$this->init_search_form();
	}

	function init_search_form()
	{
		global $bbPath;

		$this->content  = '';
		$this->content .= '<form name="search" action="search.php" method="post">';
		$this->content .= '<b>'._MD_KEYWORDS.'</b>&nbsp;&nbsp;';
		$this->content .= '<input type="text" class="text" name="term"  size="40">';
		$this->content .= '<input type="hidden" name="forum" value="all">';
		$this->content .= '<input type="hidden" name="sortby" value="p.post_time desc">';
		$this->content .= '<input type="hidden" name="searchboth" value="both">';
		$this->content .= '&nbsp;&nbsp;<input type="submit" class="button" name="submit" value="'._MD_SEARCH.'"><br />';
		$this->content .= '[ <a href="'.$bbPath['url'].'search.php">'._MD_ADVSEARCH.'</a> ]';
		$this->content .= '</form>';
	}
}
?>