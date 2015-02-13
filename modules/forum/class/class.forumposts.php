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
include_once(RCX_ROOT_PATH."/class/module.errorhandler.php");
include_once(RCX_ROOT_PATH."/class/rcxtree.php");
include_once($bbPath['path'].'/include/user_level.php');
include_once('class.attachment.php');

class ForumPosts {
        var $post_id;
        var $topic_id;
        var $forum_id;
        var $post_time;
        var $poster_ip;
        var $order;
        var $subject;
        var $post_text;
        var $pid;
        var $allow_html    = 0;
        var $allow_smileys = 1;
        var $allow_bbcode  = 1;
        var $type          = 'user';
        var $uid;
        var $icon;
        var $notify;
        var $attachsig;
        var $upload;
        var $attachment = array();
        var $prefix;
        var $db;
        var $istopic = 0;
        var $has_attachment = 0;
        var $is_approved = 1;
        var $anon_uname = '';

        function ForumPosts($id=-1) {
        if ( is_array($id) ) {
                $this->makePost($id);
                } elseif ( $id != -1 ) {
                        $this->getPost(intval($id));
                }
        }

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setTopicId($value) {
        $this->topic_id = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setOrder($value) {
        $this->order = $value;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getTopPosts() {
global $db, $bbTable;

$sql = "
        SELECT * FROM ".$bbTable['posts']."
        WHERE
        topic_id = ".$this->topic_id."
        AND
        pid = ".$this->pid."
        ORDER BY
        ".$this->order."";

$ret     = array();
$result  = $db->query($sql);
$numrows = $db->num_rows($result);

if ( $numrows == 0 ) {
        return $ret;
}

while ( $myrow = $db->fetch_array($result) ) {
        $ret[] = new ForumPosts($myrow);
}

return $ret;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getPostTree($pid) {
global $db, $bbTable;

$mytree = new RcxTree($bbTable['posts'], "post_id", "pid");
$parray = array();
$parray = $mytree->getChildTreeArray($pid, "post_id");
$ret = array();

foreach ( $parray as $post ) {
        $ret[] = new ForumPosts($post);
}

return $ret;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getAllPosts($perpage=0, $start=0) {
global $db, $bbTable;

$sql = "
        SELECT * FROM ".$bbTable['posts']."
        WHERE
        topic_id = ".$this->topic_id."
        ORDER BY
        ".$this->order."";

$result  = $db->query($sql, $perpage, $start);
$numrows = $db->num_rows($result);
$ret     = array();

if ( $numrows == 0 ) {
        return $ret;
}

while ( $myrow = $db->fetch_array($result) ) {
        $ret[] = new ForumPosts($myrow);
}

return $ret;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setParent($value) {
        $this->pid = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setSubject($value) {
        $this->subject = $value;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setText($value) {
        $this->post_text = $value;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setUid($value) {
        $this->uid = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setForum($value) {
        $this->forum_id = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setIp($value) {
        $this->poster_ip = $value;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setHtml($value=0) {
        $this->allow_html = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setSmileys($value=0) {
        $this->allow_smileys = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setBBcode($value=0) {
        $this->allow_bbcode = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setIcon($value) {
        $this->icon = $value;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setNotify($value) {
        $this->notify = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setAttachsig($value) {
        $this->attachsig = intval($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setAttachment($value) {
        $this->attachment[] = $value;
}

function setAnonUname($value)
{
        $this->anon_uname = $value;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function setType($value='user') {
global $myts;

        $this->type = $value;
        $myts->setType($value);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
global $db, $myts, $upload, $bbPath, $bbTable;

$subject   = $myts->makeTboxData4Save($this->subject);
$post_text = $myts->makeTboxData4Save($this->post_text);
$anon_uname = $myts->makeTboxData4Save($this->anon_uname);

        $permissions = new Permissions($this->forum_id);
        $attachments = array();

        if ($this->attachment)
        {
                $attach_errors = '';
                $upload = new fileupload();
                for ($i = 0; $i<5; $i++)
                {
                        $upload->set_upload_dir('cache/attachments', "attachment_$i");
                        $upload->set_basename($this->uid.'_'.(time()+$i), "attachment_$i");
                }
                $result = $upload->upload();
                for ($i = 0; $i<5; $i++)
                {
                        if (!empty($result["attachment_$i"]['realname']))
                        {
                                $attach = new Attachment();
                                $attach->file_name = $result["attachment_$i"]['realname'];
                                $attach->file_pseudoname = $result["attachment_$i"]['basename'].$result["attachment_$i"]['extension'];
                                $attach->file_size=$result["attachment_$i"]['size'];
                                $attach->is_approved = $permissions->autoapprove_attach;
                                $attachments[] = $attach;
                                $this->has_attachment = true;
                        }
                         $attach_errors .= $upload->errors(0);
                }
                if ($attach_errors != "" && !strpos($attach_errors, _ULC_FILE))
                {
                        redirect_header("javascript:history.go(-1)", 5, "<b>Error</b>: ".$attach_errors."<br />");
                        exit();
                }
        }

if ( empty($this->post_id) ) {
        if ( empty($this->topic_id) ) {
                $this->topic_id = $db->genId($bbTable['topics']."_topic_id_seq");
                $datetime = time();
                if ( isset($this->notify) && $this->uid != 0 ) {
                        $notify  = 1;
                        } else {
                                $notify = 0;
                        }
                $sql = "
                        INSERT INTO ".$bbTable['topics']." SET
                        topic_id=".$this->topic_id.",
                        topic_title='$subject',
                        topic_poster=".$this->uid.",
                        forum_id=".$this->forum_id.",
                        topic_time=$datetime,
                        topic_notify=$notify";

                if ( !$result = $db->query($sql) ) {
                        foreach ($attachments as $attach)
                        {
                                $attach->deletePseudoFile();
                        }
                        ErrorHandler::show('0022');
                }
                if ( $this->topic_id == 0 ) {
                        $this->topic_id = $db->insert_id();
                }
        }
        if ( !isset($this->attachsig) || $this->attachsig != 1 ) {
                $this->attachsig = 0;
        }
        $this->post_id = $db->genId($bbTable['posts']."_post_id_seq");
        $datetime = time();

        // Auto-Approve post?
        $this->is_approved = $permissions->autoapprove_post;

        $sql = "
                INSERT INTO ".$bbTable['posts']." SET
                post_id=".$this->post_id.",
                pid=".$this->pid.",
                topic_id=".$this->topic_id.",
                forum_id=".$this->forum_id.",
                post_time=$datetime,
                uid=".$this->uid.",
                poster_ip='".$this->poster_ip."',
                subject='".$subject."',
                post_text='".$post_text."',
                allow_html=".intval($this->allow_html).",
                allow_smileys=".intval($this->allow_smileys).",
                allow_bbcode=".intval($this->allow_bbcode).",
                type='".$this->type."',
                icon='".$this->icon."',
                has_attachment=".intval($this->has_attachment).",
                is_approved=".intval($this->is_approved).",
                anon_uname='".$this->anon_uname."',
                attachsig=".$this->attachsig."";

        if ( !$result = $db->query($sql) ) {
                foreach ($attachments as $attach)
                {
                        $attach->deletePseudoFile();
                }
                ErrorHandler::show('0022');
                } elseif ($this->post_id == 0) {
                        $this->post_id = $db->insert_id();

                }
        foreach ($attachments as $attach)
        {
                $attach->post_id = $this->post_id;
                $attach->store();
        }

        if ( $this->uid != 0 ) {
                RcxUser::incrementPost($this->uid);
        }
        if ($this->pid == 0) {
                $sql = "UPDATE ".$bbTable['topics']." SET topic_last_post_id=".$this->post_id.", topic_time=$datetime WHERE topic_id=".$this->topic_id."";
                if ( !$result = $db->query($sql) ) {
                        ErrorHandler::show('0022');
                }
                $sql = "UPDATE ".$bbTable['forums']." SET forum_posts=forum_posts+1, forum_topics = forum_topics+1, forum_last_post_id=".$this->post_id." WHERE forum_id=".$this->forum_id."";
                if ( !$result = $db->query($sql) ) {
                        //ErrorHandler::show('0022');
                }
                } else {
                        $sql = "UPDATE ".$bbTable['topics']." SET topic_replies=topic_replies+1, topic_last_post_id=".$this->post_id.", topic_time=$datetime WHERE topic_id=".$this->topic_id."";
                        if ( !$result = $db->query($sql) ) {
                                //ErrorHandler::show('0022');
                        }
                        $sql = "UPDATE ".$bbTable['forums']." SET forum_posts=forum_posts+1, forum_last_post_id=".$this->post_id." WHERE forum_id = ".$this->forum_id."";
                        $result = $db->query($sql);
                        if ( !$result ) {
                                //ErrorHandler::show('0022');
                        }
                }
        } else {
                if ( $this->istopic() && isset($this->notify) && $this->notify != "" ) {
                        $sql = "UPDATE ".$bbTable['topics']." SET topic_title='$subject', topic_notify=".$this->notify." WHERE topic_id=".$this->topic_id."";
                        if ( !$result = $db->query($sql) ) {
                                ErrorHandler::show('0022');
                        }
                }
                if ( !isset($this->attachsig) || $this->attachsig != 1 ) {
                        $this->attachsig = 0;
                }
                $sql = "
                        UPDATE ".$bbTable['posts']." SET
                        subject='".$subject."',
                        post_text='".$post_text."',
                        allow_html=".intval($this->allow_html).",
                        allow_smileys=".intval($this->allow_smileys).",
                        allow_bbcode=".intval($this->allow_bbcode).",
                        icon='".$this->icon."',
                        attachsig=".$this->attachsig.",
                        anon_uname='".$this->anon_uname."',
                        has_attachment=".intval($this->has_attachment)."
                        WHERE
                        post_id=".$this->post_id."";

                $result = $db->query($sql);
                if ( !$result ) {
                        ErrorHandler::show('0022');
                }
        }

// Update the RSS Feed
build_rss();

return $this->post_id;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function getPost($id) {
global $db, $bbTable;

$sql   = "SELECT * FROM ".$bbTable['posts']." WHERE post_id=$id";
$array = $db->fetch_array($db->query($sql));

$this->post_id       = $array['post_id'];
$this->pid           = $array['pid'];
$this->topic_id      = $array['topic_id'];
$this->forum_id      = $array['forum_id'];
$this->post_time     = $array['post_time'];
$this->uid           = $array['uid'];
$this->poster_ip     = $array['poster_ip'];
$this->subject       = $array['subject'];
$this->allow_html    = $array['allow_html'];
$this->allow_smileys = $array['allow_smileys'];
$this->allow_bbcode  = $array['allow_bbcode'];
$this->type          = $array['type'];
$this->icon          = $array['icon'];
$this->attachsig     = $array['attachsig'];
$this->post_text     = $array['post_text'];
$this->has_attachment = $array['has_attachment'];
$this->is_approved         = $array['is_approved'];

if ( $this->pid == 0 ) {
        $sql   = "SELECT * FROM ".$bbTable['topics']." WHERE topic_id=".$this->topic_id."";
        $array = $db->fetch_array($db->query($sql));
        $this->notify  = $array['topic_notify'];
        $this->istopic = 1;
        }
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function makePost($array) {

foreach($array as $key=>$value) {
        $this->$key = $value;
        }
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db, $bbTable;

$sql = "SELECT * FROM ".$bbTable['posts']." WHERE post_id=".$this->post_id."";
if ( !$result = $db->query($sql) ) {
        ErrorHandler::show('0022');
}
while ($o_attach = $db->fetch_object($result)) {
                        if ($o_attach->attachment) {
                                $attachment_csvdat = explode("|",$o_attach->attachment);
                                unlink($bbPath['path'].'cache/attachments/'.$attachment_csvdat[1]);
                        }
                }

$sql = "DELETE FROM ".$bbTable['posts']." WHERE post_id=".$this->post_id."";
if ( !$result = $db->query($sql) ) {
        ErrorHandler::show('0022');
}

if ( !empty($this->uid) ) {
        $sql = "UPDATE ".$db->prefix("users")." SET posts=posts-1 WHERE uid=".$this->uid."";
        if ( !$result = $db->query($sql) ) {
                //        echo "Could not update user posts.";
        }
}

if ( $this->istopic ) {
        $sql = "DELETE FROM ".$bbTable['topics']." WHERE topic_id =".$this->topic_id."";
        if ( !$result = $db->query($sql) ) {
                echo "Could not delete topic.";
        }
}

if ( $this->istopic ) {
        $sql = "DELETE FROM ".$bbTable['topics_mail']." WHERE topic_id =".$this->topic_id."";
        if ( !$result = $db->query($sql) ) {
                echo "Could not delete mail notification.";
        }
}

$mytree = new RcxTree($bbTable['posts'], "post_id", "pid");
$arr    = $mytree->getAllChild($this->post_id);

$size = count($arr);
/* Delete Post & Child Posts
if ( $size > 0 ) {
        for ( $i = 0; $i < $size; $i++ ) {
                $sql = "SELECT * FROM ".$bbTable['posts']." WHERE post_id=".$arr[$i]['post_id']."";
                if ($result = $db->query($sql) ) {
                        while ($o_attach = $db->fetch_object($result)) {
                                if ($o_attach->attachment) {
                                        $attachment_csvdat = explode("|",$o_attach->attachment);
                                        unlink($bbPath['path'].'cache/attachments/'.$attachment_csvdat[1]);
                                }
                        }
                }

                $sql = "DELETE FROM ".$bbTable['posts']." WHERE post_id=".$arr[$i]['post_id']."";
                if ( !$result = $db->query($sql) ) {
                        echo "Could not delete post ".$arr[$i]['post_id']."";
                }
                if ( !empty($arr[$i]['uid']) ) {
                        $sql = "UPDATE ".$db->prefix("users")." SET posts=posts-1 WHERE uid=".$arr[$i]['uid']."";
                        if ( !$result = $db->query($sql) ) {
                                //        echo "Could not update user posts.";
                        }
                }
        }
}
*/
// Start: Delete Post Only
                if ( intval($this->uid) > 0 ){
                        $sql = "UPDATE ".$db->prefix("users")." SET posts=posts-1 WHERE uid=".$this->uid."";
                        if ( !$result = $db->query($sql) ) {
                        //        echo "Could not update user posts.";
                        }
                }
                if ( $size > 0 ) {
                        for ( $i = 0; $i < $size; $i++ ) {
                                $sql = "UPDATE ".$bbTable['posts']." SET pid=pid-1 WHERE post_id = ".$arr[$i]['post_id']." && pid=".$this->post_id."";;
                                if ( !$result = $db->query($sql) ) {
                                        echo "Could not delete post ".$arr[$i]['post_id']."";
                                }
                        }
                }
// End: Delete Post Only

}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function subject($format="Show") {
global $myts;

$allow_smileys = intval($this->allow_smileys());

switch ( $format ) {
        case "Show":
                $subject= $myts->makeTboxData4Show($this->subject, $allow_smileys);
                break;

        case "Edit":
                $subject = $myts->makeTboxData4Edit($this->subject);
                break;

        case "Preview":
                $subject = $myts->makeTboxData4Preview($this->subject, $allow_smileys);
                break;

        case "InForm":
                $subject = $myts->makeTboxData4PreviewInForm($this->subject);
                break;
}

return $subject;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function text($format="Show") {
global $myts;

$allow_html    = intval($this->allow_html());
$allow_smileys = intval($this->allow_smileys());
$allow_bbcode  = intval($this->allow_bbcode());

$myts->setType($this->type);

switch ( $format ) {
        case "Show":
                $text = $myts->makeTareaData4Show($this->post_text, $allow_html, $allow_smileys, $allow_bbcode);
                break;

        case "Edit":
                $text = $myts->makeTboxData4Edit($this->post_text);
                break;

        case "Quotes":
                $text = $myts->makeTboxData4Edit($this->post_text);
                break;

        case "Preview":
                $text = $myts->makeTareaData4Preview($this->post_text, $allow_html, $allow_smileys, $allow_bbcode);
                break;

        case "InForm":
                $text = $myts->makeTboxData4PreviewInForm($this->post_text);
                break;
}

return $text;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function postid() {
        return intval($this->post_id);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function posttime() {
        return $this->post_time;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function uid() {
        return intval($this->uid);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function uname() {
        return RcxUser::getUnameFromId($this->uid);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function posterip() {
        return $this->poster_ip;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function parent() {
        return intval($this->pid);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function topic() {
        return intval($this->topic_id);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function allow_html() {
        return intval($this->allow_html);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function allow_smileys() {
        return intval($this->allow_smileys);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function allow_bbcode() {
        return intval($this->allow_bbcode);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function icon() {
        return $this->icon;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function forum() {
        return intval($this->forum_id);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function notify() {
        return intval($this->notify);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function attachsig() {
        return intval($this->attachsig);
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function attachment() {
        return $this->attachment;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function prefix() {
        return $this->prefix;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function istopic() {

if ( $this->istopic ) {
        return TRUE;
        }

return FALSE;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function is_topic() {
global $db, $bbTable;

$sql = "SELECT pid FROM ".$bbTable['posts']." WHERE post_id = ".$this->post_id."";
$r   = $db->query($sql);

list($pid)=$db->fetch_row($r);
if ( $pid == 0 ) {
        return true;
        } else {
                return false;
        }
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function showPost($viewmode, $order, $permissions, $topic_status, $allow_sig, $adminview=0, $color_num=1, $allow_attachments = 0) {
global $rcxConfig, $rcxUser, $myts, $bbImage, $bbPath, $forumConfig;

if (!$adminview && !$this->is_approved && !($rcxUser && $this->uid() == $rcxUser->getVar("uid")))
{
        return;
}

$edit_image   = "";
$reply_image  = "";
$delete_image = "";
$post_date    = formatTimestamp($this->posttime(), "m");

if ( $this->uid != 0 ) {
        $poster = new RcxUser($this->uid());
        if ( !$poster->isActive() ) {
                $poster = 0;
        }
        } else {
                $poster = 0;
        }
//        Attachments
if ($this->has_attachment)
{
        if ($adminview || ($rcxUser && $this->uid() == $rcxUser->getVar("uid")))
        {
                $attachments = Attachment::getAllByPost($this->post_id, 1);
        }
        else
        {
                $attachments = Attachment::getAllByPost($this->post_id);
        }

        if (count($attachments) > 0)
        {
                $att_text  ='<hr size="1" noshade="noshade">';
                $att_text .='<b>'._MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST.':<br /></b>';

                foreach($attachments as $attach)
                {
                        $att_text .= $attach->showAttachment()."<br />";
                }
        }
}
//

if ( isset($this->icon) && $this->icon != "" ) {
        $subject_image = "<a name='".$this->postid()."' id='".$this->postid()."'><img src='".RCX_URL."/images/subject/".$this->icon."' alt='#' /></a>";
        } else {
                $subject_image =  "<a name='".$this->postid()."' id='".$this->postid()."'><img src='".$bbImage['posticon']."' alt='#' /></a>";
        }

$ip_image = '';
if ($adminview)
{
        if($this->is_approved)
        {
                $ip_image .= "<a href='topicmanager.php?topic_id=".$this->topic()."&amp;forum=".$this->forum()."&post_id=".$this->postid()."&mode=unapprove_post'><img src='".$bbImage['unapprove']."' alt='"._MD_UNAPPROVE."' title='"._MD_UNAPPROVE."' /></a>&nbsp;";
        }
        else
        {
                $ip_image .= "<a href='topicmanager.php?topic_id=".$this->topic()."&amp;forum=".$this->forum()."&post_id=".$this->postid()."&mode=approve_post'><img src='".$bbImage['approve']."' alt='"._MD_APPROVE."' title='"._MD_APPROVE."'/></a>&nbsp;";
        }

}

if ($allow_attachments && ($adminview || ($rcxUser && $this->uid() == $rcxUser->getVar("uid") && $permissions->can_attach)))
{
        $ip_image .= "<a href='attachmanager.php?post_id=".$this->postid()."'><img src='".$bbImage['attachmgr']."' alt='"._MD_ATTACH_MANAGER."' title='"._MD_ATTACH_MANAGER."' /></a>&nbsp;";
}

if ($adminview) {
        $ip_image .= "<a href='".RCX_URL."/modules/system/admin.php?fct=filter&op=ips&add_ip=".$this->posterip()."'><img src='".$bbImage['ip']."' alt='".$this->posterip()."' title='".$this->posterip()."' border='0' /></a>";
}

// if this topic is not locked, show reply/edit link
if ( $topic_status != 1 )
{
        if ( $adminview || ($rcxUser && $this->uid() == $rcxUser->getVar("uid") && $permissions->can_edit) )
        {
                $edit_image = "<a href='edit.php?forum=".$this->forum()."&amp;post_id=".$this->postid()."&amp;topic_id=".$this->topic()."&amp;viewmode=".$viewmode."&amp;order=".$order."'><img src='".$bbImage['edit']."' alt='"._MD_EDITTHISPOST."' title='"._MD_EDITTHISPOST."'/></a>";
        }
        if ( $permissions->can_reply )
        {
                $reply_image = "<a href='reply.php?forum=".$this->forum()."&amp;post_id=".$this->postid()."&amp;topic_id=".$this->topic()."&amp;viewmode=".$viewmode."&amp;order=".$order."'><img src='".$bbImage['reply_mini']."' alt='"._MD_REPLY."' title='"._MD_REPLY."' /></a>";
        }
}

if ($adminview || ($rcxUser && $this->uid() == $rcxUser->getVar("uid") && $permissions->can_delete))
{
        $delete_image = "<a href='delete.php?forum=".$this->forum()."&amp;topic_id=".$this->topic()."&amp;post_id=".$this->postid()."&amp;viewmode=".$viewmode."&amp;order=".$order."'><img src='".$bbImage['delpost']."' alt='"._MD_DELETEPOST."' title='"._MD_DELETEPOST."'/></a>";
}



$text = $this->text().$att_text;


if ($poster) {
        if ($allow_sig == 1)
		{
			if($this->attachsig == 1 || $poster->attachsig() == 1)
			{
                $text .= "<br /><br />--<br />";
                if ($rcxConfig['no_bbcode_user_sig']) {
                    $text .= $myts->makeTboxData4Show($poster->getVar("user_sig", "N"));
                } else {
                	$text .= $myts->makeTareaData4Show($poster->getVar("user_sig", "N"), 0, 1, 1);
                }
			}
        }
        $reg_date   = _JOINED;
        $reg_date  .= formatTimestamp($poster->user_regdate(), "s");
        $posts      = _POSTS;
        $posts     .= $poster->posts();
        $user_from  = _FROM;
        $user_from .= $poster->user_from();
        $rank       = $poster->rank();

        if ($rank['image'] != "") {
                $rank['image'] = "<img src='".RCX_URL."/images/ranks/".$rank['image']."' alt='#' vspace='2' />";
        }

        $avatar_image = $poster->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$poster->getVar("user_avatar")."' alt='#' />" : '';

        if ( $poster->isOnline() ) {
                $online_image = "<span style='font-weight:bold;'>"._ONLINE."</span>";
        }

        // DISPLAY USER LEVELS
        // Append the display onto the 'online_image' field for display in the post.
        if ($forumConfig['levels_enabled'])
        {
                $level = get_user_level($this->uid);

                $online_image .= '
                <!-- [BEGIN LEVEL MOD] -->
                <br /><br />
                <span>&nbsp;'._MD_LEVEL.': <strong>'.$level['LEVEL'].'</strong></span>
                <table width="143" border="0" cellpadding="0" cellspacing="0" style="background-image:url('.$bbPath['images_levels'].'lm_bkg.gif)">
                <tr>
                <td><img src="images/spacer.gif" alt="#" width="31" height="49" /></td>
                <td width="100%">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td><img src="images/spacer.gif" alt="#" width="20" height="6" /></td></tr>
                <tr><td align="left"><img src="'.$bbPath['images_levels'].'lm_hp_bar.gif" alt="'.$level['HP'].'" title="'.$level['HP'].'" width="'.$level['HP_WIDTH'].'" height="9" /><img src="'.$bbPath['images_levels'].'lm_hp_bar_end.gif" alt="#" width="4" height="9" /></td></tr>
                <tr><td><img src="images/spacer.gif" alt="#" width="20" height="4" /></td></tr>
                <tr><td align="left"><img src="'.$bbPath['images_levels'].'lm_mp_bar.gif" alt="'.$level['MP'].'" title="'.$level['MP'].'" width="'.$level['MP_WIDTH'].'" height="9" /><img src="'.$bbPath['images_levels'].'lm_mp_bar_end.gif" alt="#" width="4" height="9" /></td></tr>
                <tr><td><img src="images/spacer.gif" alt="#" width="20" height="4" /></td></tr>
                <tr><td align="left"><img src="'.$bbPath['images_levels'].'lm_exp_bar.gif" alt="'.$level['EXP'].'" title="'.$level['EXP'].'" width="'.$level['EXP_WIDTH'].'" height="9" /><img src="'.$bbPath['images_levels'].'lm_exp_bar_end.gif" alt="#" width="4" height="9" /></td></tr>
                <tr><td><img src="images/spacer.gif" alt="#" width="20" height="8" /></td></tr>
                </table>
                </td>
                </tr>
                </table>
                <!-- [END LEVEL MOD] -->';

                // END DISPLAY USER LEVELS
        }

        $profile_image = "<a href='".RCX_URL."/userinfo.php?uid=".$poster->uid()."'><img src='".$bbImage['profile']."' alt='"._PROFILE."' /></a>";
	$module = RcxModule::getByDirname('pm');
		if ( $rcxUser  && RcxModule::moduleExists('pm') && $module->isActivated() && RcxGroup::checkRight('module', $module->mid(), $rcxUser->groups()) && RcxGroup::checkRight('module', $module->mid(), $poster->groups())) {
//			$pm_image =  "<a href=\"".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$poster->uid()."\"><img src='".RCX_URL."/images/icons/pm.gif' alt='".sprintf(_SENDPMTO, $poster->uname())."' /></a>";

		$pm_image =  "<a href=\"".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$poster->uid()."\"><img src='".$bbImage['pm']."' alt='".sprintf(_SENDPMTO, $poster->uname())."' /></a>";

		}

        if ( $adminview || ($rcxUser && $poster->user_viewemail()) ) {
                $email_image = "<a href='mailto:".$poster->email()."'><img src='".$bbImage['email']."' alt='".sprintf(_SENDEMAILTO, $poster->uname('E'))."' /></a>";
        }

       if ($poster->url() != '') {
                if ($rcxConfig['hide_external_links']) {
                    $www_image = $myts->checkGoodUrl($poster->url(), "<img src='".$bbImage['www']."' alt='"._VISITWEBSITE."' target='_blank' />", false);
                } else {
                    $www_image = "<a href='".$poster->url()."' target='_blank'><img src='".$bbImage['www']."' alt='"._VISITWEBSITE."' target='_blank' /></a>";
                }
        }

        if ( $rcxUser && ($poster->user_icq() != '') ) {
                $icq_image = "<a href='http://wwp.icq.com/scripts/search.dll?to=".$poster->user_icq()."'><img src='".$bbImage['icq']."' alt='"._ADDTOLIST."' /></a>";
        }

        if ( $rcxUser && ($poster->user_aim() != '') ) {
                $aim_image = "<a href='aim:goim?screenname=".$poster->user_aim('E')."&message=Hi+".$poster->user_aim()."+Are+you+there?'><img src='".$bbImage['aim']."' alt='aim' /></a>";
        }

        if ( $rcxUser && ($poster->user_yim() != '') ) {
                $yim_image = "<a href='http://edit.yahoo.com/config/send_webmesg?.target=".$poster->user_yim()."&.src=pg'><img src='".$bbImage['yim']."' alt='yim' /></a>";
        }

        if ( $rcxUser && ($poster->user_msnm() != '') ) {
                $msnm_image = "<a href='".RCX_URL."/userinfo.php?uid=".$poster->uid()."'><img src='".$bbImage['msnm']."' alt='msnm' /></a>";
        }



        $poster_name = "<a href='".RCX_URL."/userinfo.php?uid=".$poster->uid()."'>".$poster->uname()."</a>";
        showThread($color_num, $subject_image, $this->subject(), $text, $post_date, $ip_image, $reply_image, $edit_image, $delete_image, $poster_name, $rank['title'], $rank['image'], $avatar_image, $reg_date, $posts, $user_from, $online_image, $profile_image, $pm_image, $email_image, $www_image, $icq_image,  $aim_image, $yim_image, $msnm_image);
        } else {

                $poster_name = (!empty($this->anon_uname)) ? $myts->makeTboxData4Show($this->anon_uname) : $rcxConfig['anonymous'];

                // Hack to make the width of the userinfo for anon users as for reg users when levels mod is enabled.
                $width_hack =  ($forumConfig['levels_enabled']) ? "<table width=143></table>" : "";
                showThread($color_num, $subject_image, $this->subject(), $text, $post_date, $ip_image, $reply_image, $edit_image, $delete_image, $poster_name, $width_hack);
        }
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function showTreeHead($width="100%") {

OpenTable();
echo "
        <table border='0' cellpadding='3' cellspacing='0' width='$width'>
        <tr class='bg2' align='left'>
        <td width='60%'>"._REPLIES."</td>
        <td width='20%'>"._POSTER."</td>
        <td>"._DATE."</td></tr>";
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function showTreeItem($viewmode, $order, $color_num) {
global $bbImage;

if ( $color_num == 1 ) {
        $bg1 = 'bg1';
        } else {
                $bg1 = 'bg3';
        }

$prefix = str_replace(".", "&nbsp; &nbsp;", $this->prefix());
$date   = formatTimestamp($this->posttime(), "m");

if ($this->icon() != "") {
        $icon = "<img src='".RCX_URL."/images/subject/".$this->icon()."' alt='#' />";
        } else {
                $icon = "<img src='".$bbImage['posticon']."' alt='#' />";
        }

echo "
        <tr class='$bg1' align='left'>
        <td>".$prefix.$icon."<a href='"._PHP_SELF."?forum=".$this->forum()."&amp;topic_id=".$this->topic()."&amp;post_id=".$this->postid()."&amp;viewmode=".$viewmode."&amp;order=".$order."#".$this->postid()."'>".$this->subject()."</a></td>
        <td><a href='".RCX_URL."/userinfo.php?uid=".$this->uid()."'>".$this->uname()."</a></td>
        <td>".$date."</td></tr>";
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function showTreeFoot() {
        echo "</table>";
        CloseTable();
}

//---------------------------------------------------------------------------------------//
function showPostForPrint($viewmode, $order, $can_post, $topic_status, $allow_sig, $adminview=0, $color_num=1) {
global $rcxConfig, $rcxUser, $myts, $bbImage;

$edit_image   = "";
$reply_image  = "";
$delete_image = "";
$post_date    = formatTimestamp($this->posttime(), "m");

if ( $this->uid != 0 ) {
        $poster = new RcxUser($this->uid());
        if ( !$poster->isActive() ) {
                $poster = 0;
        }
        } else {
                $poster = 0;
        }

if ( isset($this->icon) && $this->icon != "" ) {
        $subject_image = "<a name='".$this->postid()."' id='".$this->postid()."'><img src='".RCX_URL."/images/subject/".$this->icon."' alt='#' /></a>";
        } else {
                $subject_image =  "<a name='".$this->postid()."' id='".$this->postid()."'><img src='".$bbImage['posticon']."' alt='#' /></a>";
        }

$text = $this->text();

        $poster_name = ($poster) ? $poster->uname() : $rcxConfig['anonymous'];

echo"<table align='left' border='0' width='640' cellpadding='0' cellspacing='1' bgcolor='#000000'><tr><td>
<table border='0' width='640' cellpadding='5' cellspacing='1' bgcolor='#FFFFFF'>
<tr><td width='100%' align='left'>
<h3><img src='".$bbImage['folder']."' align='absmiddle' alt='#' />
&nbsp;$poster_name :</h3></td>
<td align='right' nowrap><i>$post_date</i></td></tr>
<tr><td width='100%' colspan='2' align='left'>
$subject_image&nbsp;".$text."</td></tr></table></td></tr></table>";

}

function getPageOffset($perPage)
{
	global $db, $bbTable;
	$pageOffest = 0;
$sql = "SELECT post_id FROM ".$bbTable['posts']."
        WHERE
        topic_id = ".$this->topic_id."
        ORDER BY
        ".$this->order."";

$result  = $db->query($sql);
if ($result)
{
	$postNum = 0;
	while($row = $db->fetch_array($result))
	{
		$iPost = $row[0];
		if ($iPost == $this->post_id)
			break;
		$postNum++;
	}

	$pageOffest = intval($postNum/$perPage) * $perPage;
}
	return $pageOffest;

}

}
?>