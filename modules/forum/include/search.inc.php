<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

function forum_search($queryarray, $andor, $limit, $offset, $userid) {
global $db, $bbTable;
include_once(RCX_ROOT_PATH.'/modules/forum/config.php');
include_once(RCX_ROOT_PATH.'/modules/forum/functions.php');
include_once(RCX_ROOT_PATH.'/modules/forum/class/class.permissions.php');

$sql = "
        SELECT
        f.forum_id,
        p.post_id,
        p.topic_id,
        p.post_time,
        p.uid,
        p.subject,
        LEFT(p.post_text, 95) AS content
        FROM ".$bbTable['posts']." p
        INNER JOIN ".$bbTable['forums']." f ON f.forum_id = p.forum_id";

if ( $userid != 0 ) {
        $sql .= " AND p.uid=".$userid." ";
}

// because count() returns 1 even if a supplied variable
// is not an array, we must check if $querryarray is really an array
$count = count($queryarray);
if ( $count > 0 && is_array($queryarray) ) {
        $sql .= " AND ((p.subject LIKE '%$queryarray[0]%' OR p.post_text LIKE '%$queryarray[0]%')";
        for ($i=1; $i<$count; $i++) {
                $sql .= " $andor ";
                $sql .= "(p.subject LIKE '%$queryarray[$i]%' OR p.post_text LIKE '%$queryarray[$i]%')";
        }
        $sql .= ") ";
}

$sql   .= " ORDER BY p.post_time DESC";
$result = $db->query($sql, $limit, $offset);

$i = 0;
if ($result)
{
        while ($myrow = $db->fetch_array($result))
        {
                $permissions = new Permissions($myrow['forum_id']);
                if($permissions->can_view == 1)
                {
                $ret[$i]['image']   = "images/info.gif";
                $ret[$i]['link']    = "viewtopic.php?topic_id=".$myrow['topic_id']."&amp;forum=".$myrow['forum_id']."#".$myrow['post_id']."";
                $ret[$i]['title']   = $myrow['subject'];
                $ret[$i]['content'] = $myrow['content'];
                $ret[$i]['time']    = $myrow['post_time'];
                $ret[$i]['uid']     = $myrow['uid'];
                $i++;
                }
        }
}
return $ret;
}
?>