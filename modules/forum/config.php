<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

include_once(RCX_ROOT_PATH.'/modules/forum/cache/config.php');

// You shouldn't have to change any of these
$bbPath['path']     = RCX_ROOT_PATH.'/modules/forum/';
$bbPath['url']     = RCX_URL.'/modules/forum/';
$bbPath['admin']   = $bbPath['url'].'admin';
$bbPath['images']  = $bbPath['url'].'images';
$bbPath['imagesets']  = $bbPath['url'].'images/imagesets';
$bbPath['images_levels']  = $bbPath['url'].'images/imagesets/'.$forumConfig['image_set'].'/levels/';

$bbWidth = '100%';

/* -- You shouldn't have to change anything after this point */

// Navigation Tree Images
$bbImage['f_open']       = $bbPath['images'].'/tree_open.gif';
$bbImage['f_close']      = $bbPath['images'].'/tree_close.gif';
$bbImage['f_content']    = $bbPath['images'].'/tree_content.gif';

// Global Images
$bbImage['editicon']     = $bbPath['images'].'/editicon.gif';
$bbImage['notifyon']     = $bbPath['images'].'/topic_notifyon.gif';
$bbImage['notifyoff']    = $bbPath['images'].'/topic_notifyoff.gif';


// Image Set Forum Images (Generic)
$bbImage['folder']       = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder.gif';
$bbImage['hot_folder']   = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder_hot.gif';
$bbImage['newposts']     = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder_new.gif';
$bbImage['hot_newposts'] = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder_new_hot.gif';
$bbImage['locked']       = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder_lock.gif';
$bbImage['sticky']       = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder_sticky.gif';
$bbImage['unsticky']     = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/folder_sticky_new.gif';

$bbImage['locktopic']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/topic_lock.gif';
$bbImage['deltopic']     = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/topic_delete.gif';
$bbImage['stickytopic']  = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/topic_sticky.gif';
$bbImage['unstickytopic']  = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/topic_unsticky.gif';
$bbImage['movetopic']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/topic_move.gif';
$bbImage['unlocktopic']  = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/topic_unlock.gif';
$bbImage['whosonline']   = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/whosonline.gif';
$bbImage['attachmgr']   = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/icon_attach.gif';

$bbImage['posticon']     = $bbPath['images'].'/posticon.gif';
$bbImage['attachment']   = $bbPath['images'].'/attachment.gif';

// Image Set Forum Images (Language)
$bbImage['newthread']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/post.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/post.gif'))
{
        $bbImage['newthread']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/post.gif';
}

$bbImage['newpoll']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/poll.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/poll.gif'))
{
        $bbImage['newpoll']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/poll.gif';
}

$bbImage['poll_mini']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/poll_mini.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/poll_mini.gif'))
{
        $bbImage['poll_mini']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/poll_mini.gif';
}

$bbImage['reply']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/reply.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply.gif'))
{
        $bbImage['reply']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply.gif';
}

$bbImage['topic_print']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/topic_print.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/topic_print.gif'))
{
        $bbImage['topic_print']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/topic_print.gif';
}

$bbImage['reply_mini']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/reply_mini.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply_mini.gif'))
{
        $bbImage['reply_mini']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply_mini.gif';
}

$bbImage['ip']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_ip.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_ip.gif'))
{
        $bbImage['ip']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_ip.gif';
}

$bbImage['edit']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_edit.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_edit.gif'))
{
        $bbImage['edit']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_edit.gif';
}

$bbImage['delpost']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_delete.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_delete.gif'))
{
        $bbImage['delpost']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_delete.gif';
}

$bbImage['profile']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_profile.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_profile.gif'))
{
        $bbImage['profile']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_profile.gif';
}

$bbImage['pm']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_pm.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_pm.gif'))
{
        $bbImage['pm']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_pm.gif';
}

$bbImage['email']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_email.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_email.gif'))
{
        $bbImage['email']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_email.gif';
}

$bbImage['www']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_www.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_www.gif'))
{
        $bbImage['www']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_www.gif';
}

$bbImage['icq']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_icq_add.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_icq.gif'))
{
        $bbImage['icq']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_icq.gif';
}

$bbImage['aim']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_aim.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_aim.gif'))
{
        $bbImage['aim']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_aim.gif';
}

$bbImage['yim']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_yim.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_yim.gif'))
{
        $bbImage['yim']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_yim.gif';
}

$bbImage['msnm']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_msnm.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_msnm.gif'))
{
        $bbImage['msnm']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_msnm.gif';
}
$bbImage['quick_reply']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/reply_quick.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply_quick.gif'))
{
        $bbImage['quick_reply']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply_quick.gif';
}

$bbImage['reply_locked']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/reply-locked.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply-locked.gif'))
{
        $bbImage['reply_locked']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/reply-locked.gif';
}

$bbImage['approve']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_approve.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_approve.gif'))
{
        $bbImage['approve']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_approve.gif';
}

$bbImage['unapprove']      = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_english/icon_unapprove.gif';
if ( @file_exists($bbPath['root'].'images/imagesets/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_unapprove.gif'))
{
        $bbImage['unapprove']    = $bbPath['imagesets'].'/'.$forumConfig['image_set'].'/lang_'.$rcxConfig['language'].'/icon_unapprove.gif';
}

// Admin Images
$bbImage['up_white']         = $bbPath['images'].'/admin/up_white.gif';
$bbImage['down_white']   = $bbPath['images'].'/admin/down_white.gif';
$bbImage['up_red']                 = $bbPath['images'].'/admin/up_red.gif';
$bbImage['down_red']            = $bbPath['images'].'/admin/down_red.gif';
$bbImage['up_blue']                 = $bbPath['images'].'/admin/up_blue.gif';
$bbImage['down_blue']    = $bbPath['images'].'/admin/down_blue.gif';
$bbImage['new_forum']    = $bbPath['images'].'/admin/new_forum.gif';
$bbImage['new_subforum'] = $bbPath['images'].'/admin/new_subforum.gif';
$bbImage['private']      = $bbPath['images'].'/admin/private.gif';
$bbImage['move']                 = $bbPath['images'].'/admin/move.gif';
$bbImage['delete']       = $bbPath['images'].'/admin/delete.gif';



$bbTablePrefix = 'forum_';
$bbTable['categories']                        = $db->prefix($bbTablePrefix.'categories');
$bbTable['forum_access']                = $db->prefix($bbTablePrefix.'forum_access');
$bbTable['forum_mods']                        = $db->prefix($bbTablePrefix.'forum_mods');
$bbTable['forums']                        = $db->prefix($bbTablePrefix.'forums');
$bbTable['posts']                        = $db->prefix($bbTablePrefix.'posts');
$bbTable['topics']                        = $db->prefix($bbTablePrefix.'topics');
$bbTable['forum_group_access']          = $db->prefix($bbTablePrefix.'forum_group_access');
$bbTable['whosonline']                        = $db->prefix($bbTablePrefix.'whosonline');
$bbTable['poll_desc']                        = $db->prefix($bbTablePrefix.'poll_desc');
$bbTable['poll_log']                        = $db->prefix($bbTablePrefix.'poll_log');
$bbTable['poll_option']                        = $db->prefix($bbTablePrefix.'poll_option');
$bbTable['topics_mail']                        = $db->prefix($bbTablePrefix.'topics_mail');
$bbTable['attachments']                        = $db->prefix($bbTablePrefix.'attachments');


/* -- Cookie settings (lastvisit) -- */
// Most likely you can leave this be, however if you have problems
// logging into the forum set this to your domain name, without
// the http://
// For example, if your forum is at http://www.mysite.com/phpBB then
// set this value to
// $bbCookie['domain'] = "www.mysite.com";
$bbCookie['domain'] = "";

// It should be safe to leave these alone as well.
$bbCookie['path'] = str_replace(basename($_SERVER['PHP_SELF']),"",$_SERVER['PHP_SELF']);
$bbCookie['secure'] = false;

// set expire dates: one for a year, one for 15 minutes
$bbCookie['exp_year'] = time() + 3600 * 24 * 365;
$bbCookie['exp_15min'] = time() + 900;

// update LastVisit cookie. This cookie is updated each time
setcookie("FORumLastVisit", time(), $bbCookie['exp_year'],  $bbCookie['path'], $bbCookie['domain'], $bbCookie['secure']);

// set LastVisitTemp cookie, which only gets the time from the LastVisit
// cookie if it does not exist yet
// otherwise, it gets the time from the LastVisitTemp cookie
if (!isset($_COOKIE["FORumLastVisitTemp"]))
{
        if(isset($_COOKIE["FORumLastVisit"]))
        {
                $temptime = intval($_COOKIE["FORumLastVisit"]);
        }
        else
        {
                $temptime = 0;
        }
}
else
{
        $temptime = intval($_COOKIE["FORumLastVisitTemp"]);
}

// set cookie.
setcookie("FORumLastVisitTemp", $temptime ,$bbCookie['exp_15min'], $bbCookie['path'], $bbCookie['domain'], $bbCookie['secure']);

// set vars for all scripts
$last_visit = $temptime;

?>