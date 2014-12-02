<?php
//***********************************************************/
//*                             RUNCMS                      */
//*              Simplicity & ease off use                  */
//*             < http://www.runcms.org >                   */
//***********************************************************/
/**
 * @package     modules
 * @subpackage  newbb_plus
 */
include_once("header.php");

forum_page_header();
include_once("class/class.toolbar.php");
include_once('class/class.toggleblock.php');
include_once('class/class.forumtable.php');
include_once('class/class.topictable.php');
include_once("class/class.mypagenav.php");

global $db, $myts, $spxConfig, $spxUser, $spxModule;

$uid = $spxUser ? $spxUser->uid() : 0;
$groupid = ($spxUser) ? $spxUser->groups() : 3;

$extra = '';
$extra .= " g.can_view=1";
if (is_array($groupid)) {
        $extra .= " AND (g.group_id=" . intval($groupid[0]) . "";
        
        $size = count($groupid);
        if ($size > 1) {
            for ($i = 1; $i < $size; $i++) {
            	
                $extra .= " OR g.group_id=" . intval($groupid[$i]) . "";
            }
        }
        $extra .= ")";
    } else {
        $extra .= " AND g.group_id=".($groupid)."";
    }

$last_visit = $_COOKIE["ForumLastVisitTemp"];

if (!$last_visit) {
    $last_visit = 0;
}

OpenTable();

echo "<h3>"._MD_FORUM_LAST."</h3>("._MD_DONT_FORGET.")<br /><br />";
//OpenTable();
print_navigation();

global $db, $bbTable, $forum_data, $forum, $sort_by, $sort_order, $start, $modsarray;

$sql = "SELECT
    DISTINCT p.uid,
    p.topic_id,
    p.forum_id,
    p.post_time,
    f.posts_per_page,
    p.icon,
    t.topic_title,
    t.topic_views,
    t.topic_replies,
    t.topic_poster,
    f.forum_name,
    u.uname,
    u.uid
    FROM  " . $db->prefix('forum_forum_group_access') . " AS g
    LEFT JOIN " . $db->prefix('forum_forums') . " AS f
    ON (f.forum_id = g.forum_id)
    LEFT JOIN " . $db->prefix('forum_topics') . " AS t
    ON (t.forum_id = f.forum_id)
    LEFT JOIN " . $db->prefix('forum_posts') . " AS p
    ON (p.post_id = t.topic_last_post_id)
    LEFT JOIN  " . $db->prefix('users') . " AS u
    ON (u.uid = p.uid)
    WHERE p.post_time > $last_visit
    AND $extra
    		GROUP BY p.topic_id
    		ORDER BY t.topic_time DESC";

$result = $db->query($sql, 20, $start);
$topic_table = new TopicTable($forum_data->hot_threshold, 20, false);
//$topic_table->UnaprovedArray();
if ($spxUser) {
    $modsarray = fModsArray($spxUser->getvar('uid'));
} else {
    $modsarray = false;
}
$bg = "bg3";
while($row = $db->fetch_object($result))
{
    $bg = ($bg == 'bg3') ? 'bb1' : 'bg3';
    $topic_table->addTopic($row, $last_post, $bg);
}
$topic_table->render();

print_navigation();
make_jumpbox();

include_once("class/class.tabpane.php");
$tabPane = new TabPane();

if ($forumConfig['wol_enabled']) {
    include_once("class/tab.whosonline.php");
    $wolTab = new TabWhosOnline(0);
    $tabPane->addTab($wolTab);
}

include_once("class/tab.legend.php");
$legend = new TabLegend(LEGEND_FORUM);
$tabPane->addTab($legend);
include_once("class/tab.search.php");
$search = new TabSearch();
$tabPane->addTab($search);
$tabPane->render();

//make_rss();
CloseTable();

//CloseTable();
include_once('../../footer.php');


function print_navigation(){
    global $bbPath;
    echo "<div style='float:right;'><a href='" . $bbPath['url'] . "index.php?mark=forums'><b>" . _MD_MARK_READ_ALL . "</b></a></div>";
    echo "<a href='" . $bbPath['url'] . "'><b>" . _MD_RETURNTOTHEFORUM . "</b></a><br /><br />";
}

?>