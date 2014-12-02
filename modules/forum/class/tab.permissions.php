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
class TabPermissions extends TabPage
{
	function TabPermissions($permissions)
	{
		$this->init($permissions);
	}

	function init($permissions)
	{
		$this->title = _MD_TAB_PERMISSIONS;

		$this->content  = "<table width='100%'><tr>";
		$this->content .= "<td align='left'>";
		$this->content .= $permissions->can_post ? _MD_CAN_POST : _MD_CANNOT_POST;
		$this->content .= $permissions->can_edit ? _MD_CAN_EDIT : _MD_CANNOT_EDIT;
		$this->content .= $permissions->can_addpoll ? _MD_CAN_ADDPOLL : _MD_CANNOT_ADDPOLL;
		$this->content .= $permissions->can_attach ? _MD_CAN_ATTACH : _MD_CANNOT_ATTACH;
		$this->content .= "</td>";
		$this->content .= "<td align='left'>";
		$this->content .= $permissions->can_reply ? _MD_CAN_REPLY : _MD_CANNOT_REPLY;
		$this->content .= $permissions->can_delete ? _MD_CAN_DELETE : _MD_CANNOT_DELETE;
		$this->content .= $permissions->can_vote ? _MD_CAN_VOTE : _MD_CANNOT_VOTE;
		$this->content .= "</td>";
		$this->content .= "</tr></table>";
	}
}
?>