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
class TabPage
{
	var $title;
	var $content;

	function getTitle()
	{
		return $this->title;
	}

	function getContent()
	{
		return $this->content;
	}
}

class TabPane
{
	var $tabs = array();

	function addTab($tab)
	{
		$this->tabs[] = $tab;
	}

	function render()
	{
		echo TabPane::renderHTML();
		echo "<script type='text/javascript'>setupAllTabs();</script>";
	}

	function renderHTML()
	{
		$content  = '';
		$content  .= '<div class="tab-pane" id="tabPane">';

		foreach ($this->tabs as $tab)
		{
			$content  .= '<div class="tab-page" id="'.$tab->getTitle().'">';
			$content  .= '<h2 class="tab">'.$tab->getTitle().'</h2>';
			$content  .= '<table width="100%"><tr><td>';
			$content  .= $tab->getContent();
			$content  .= '</td></tr></table>';
			$content  .= '</div>';
		}

		$content  .= '</div>';
		return $content;
	}
}
?>