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
$g_userlink_cache = array();

class Linker
{
    static function user_link($uid, $anon_uname='')
        {
                global $rcxConfig, $g_userlink_cache;

                $userlink = $rcxConfig['anonymous'];
                if ( $uid != 0 )
                {
                    if(isset($g_userlink_cache[$uid]))
                    {
                        $userlink = $g_userlink_cache[$uid];
                    }
                    else
                    {
                        $user = new RcxUser($uid);
                        $userlink = "<a href='".RCX_URL."/userinfo.php?uid=".$uid."'>".$user->getvar('uname')."</a>";
                        $g_userlink_cache[$uid] = $userlink;
                    }
                }
                                else
                                {
                                        if (!empty($anon_uname))
                                        {
                                $userlink = $anon_uname;
                                        }
                                }
                return $userlink;
        }

        static function topic_link($topic_id, $forum_id, $topic_title)
        {
                global $myts;

                $topic_title = $myts->makeTboxData4Show($topic_title);

                $topiclink  = "<a href='";
                $topiclink .= "viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum_id;
                $topiclink .= "'>$topic_title</a>";

                return $topiclink;
        }

        static function forum_link_href($forum_id)
                {
                        return "viewforum.php?forum=".$forum_id;
                }

                static function post_link_href($post_id, $topic_id, $forum_id)
                {
                        $postlink = "viewtopic.php?post_id=".$post_id."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id."#".$post_id;
                        return $postlink;
                }

                static function mailto_topic_href($topic_id, $forum_id)
                {
                        global $meta;

                        $mailto_link = "mailto:?subject=".rawurlencode(sprintf(_MD_MAIL_TOPIC_SUBJECT, $meta['title']))."&body=".rawurlencode(sprintf(_MD_MAIL_TOPIC_BODY, $meta['title']).":\r\n".RCX_URL."/modules/forum/viewtopic.php?topic_id=$topic_id&amp;forum=$forum_id");
                        return $mailto_link;
                }
}
?>