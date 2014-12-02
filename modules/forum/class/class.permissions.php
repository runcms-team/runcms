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

$g_cache_permissions = array();

class Permissions {
    var $can_post = 0;
    var $can_view = 0;
    var $can_reply = 0;
    var $can_edit = 0;
    var $can_delete = 0;
    var $can_addpoll = 0;
    var $can_vote = 0;
    var $can_attach = 0;
    var $autoapprove_post = 0;
    var $autoapprove_attach = 0;

    function Permissions($forum_id)
    {
        global $g_cache_permissions;

        if (!$this->loadPermissionsFromCache($forum_id)) {
            $this->loadPermissions($forum_id);
            $g_cache_permissions[$forum_id] = $this;
        }
    }

    function loadPermissionsFromCache($forum_id)
    {
        global $g_cache_permissions;
        $fromCache = false;
        if (isset($g_cache_permissions[$forum_id])) {
            $this->can_post = $g_cache_permissions[$forum_id]->can_post;
            $this->can_view = $g_cache_permissions[$forum_id]->can_view;
            $this->can_reply = $g_cache_permissions[$forum_id]->can_reply;
            $this->can_edit = $g_cache_permissions[$forum_id]->can_edit;
            $this->can_delete = $g_cache_permissions[$forum_id]->can_delete;
            $this->can_addpoll = $g_cache_permissions[$forum_id]->can_addpoll;
            $this->can_vote = $g_cache_permissions[$forum_id]->can_vote;
            $this->can_attach = $g_cache_permissions[$forum_id]->can_attach;
            $this->autoapprove_post = $g_cache_permissions[$forum_id]->autoapprove_post;
            $this->autoapprove_attach = $g_cache_permissions[$forum_id]->autoapprove_attach;
            $fromCache = true;
        }
        return $fromCache;
    }

    function loadPermissions($forum_id)
    {
        global $db, $bbTable, $rcxUser, $rcxModule, $modsarray;
        // Get the user id
        $user_id = ($rcxUser) ? $rcxUser->getvar('uid') : 0;
        // Get the module id
        if ($rcxModule && $rcxModule->dirname() == 'foru,') {
            $module = $rcxModule;
        } else {
            $module = RcxModule::getByDirName('forum');
        }

        $mid = ($module) ? $module->mid() : 0;
        // If Admin or moderator set all permissions to true.
        // if ($rcxUser && ($rcxUser->isAdmin($mid) || is_moderator($forum_id, $user_id))) {
        if ($rcxUser && ($rcxUser->isAdmin($mid) || ($modsarray && in_array($forum_id, $modsarray)))) {
            $this->can_post = 1;
            $this->can_view = 1;
            $this->can_reply = 1;
            $this->can_edit = 1;
            $this->can_delete = 1;
            $this->can_addpoll = 1;
            $this->can_vote = 1;
            $this->can_attach = 1;
            $this->autoapprove_post = 1;
            $this->autoapprove_attach = 1;
            return;
        }
        // If we are a user, check for a specific set of permissions for this user
        // for this forum
        // Couldn't find permissions specific for this user so now we check the groups.
        // $groups = ($rcxUser) ? $rcxUser->groups() : RcxGroup::getByType('Anonymous');
        if ($rcxUser) {
            $groups = $rcxUser->groups();
        } else {
            $groups[] = 3;
        }

  //      $sql = "SELECT * FROM " . $bbTable['forum_group_access'] . " WHERE forum_id=".sql_safe($forum_id)";
        $sql = "SELECT * FROM " . $bbTable['forum_group_access'] . " WHERE forum_id=".intval($forum_id);

		$result = $db->query($sql);
        while ($accessRow = $db->fetch_object($result)) {
            for ($g = 0; $g < count($groups); $g++) {
                if ($accessRow->group_id == $groups[$g]) {
                    $this->can_post |= $accessRow->can_post;
                    $this->can_view |= $accessRow->can_view;
                    $this->can_reply |= $accessRow->can_reply;
                    $this->can_edit |= $accessRow->can_edit;
                    $this->can_delete |= $accessRow->can_delete;
                    $this->can_addpoll |= $accessRow->can_addpoll;
                    $this->can_vote |= $accessRow->can_vote;
                    $this->can_attach |= $accessRow->can_attach;
                    $this->autoapprove_post |= $accessRow->autoapprove_post;
                    $this->autoapprove_attach |= $accessRow->autoapprove_attach;
                }
            }
        }
    }
}

?>
