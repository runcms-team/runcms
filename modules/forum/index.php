<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('header.php');
$myts->setType("admin");

// Sanitize request variables
$viewcat = intval($viewcat);
$showver = intval($showver);

// Mark Read
$mark_read = '';
if( isset($_GET['mark']) || isset($_POST['mark']) )
{
        $mark_read = ( isset($_POST['mark']) ) ? $_POST['mark'] : $_GET['mark'];
}

if( $mark_read == 'forums' )
{
        setcookie('forum_read_f_all', time(), $bbCookie['exp_year'], $bbCookie['path'], $bbCookie['domain'], $bbCookie['secure']);
        redirect_header('index.php', 2, _MD_MSG_MARK_READ_ALL);
        die();

}

// Get the category data (this redirects if the access to the DB fails)
$categories = getCategories();
forum_page_header();
include_once('class/class.forumtable.php');
include_once('class/class.toggleblock.php');
include_once('class/class.permissions.php');

OpenTable();
renderForumHeader();


// Display the categories and their forums taking into account forum permissions
foreach($categories as $category)
{
        renderCategory($category);
}
echo "<div align='right'><a href='index.php?mark=forums' >"._MD_MARK_READ_ALL."</a></div>";
echo '<br />';

include_once("class/class.tabpane.php");
$tabPane = new TabPane();

if ($forumConfig['wol_enabled'])
{
        include_once("class/tab.whosonline.php");
        $wolTab = new TabWhosOnline(0);
        $tabPane->addTab($wolTab);
}

include_once("class/tab.legend.php");
$legend = new TabLegend(LEGEND_INDEX);
$tabPane->addTab($legend);
include_once("class/tab.search.php");
$search = new TabSearch();
$tabPane->addTab($search);
$tabPane->render();

if ($forumConfig['rss_enable'] == 1)
{
        echo "<div align='right'><a href='./cache/forum.xml' target='_blank'><img src='./images/xml.gif' border='0' vspace='2' alt='XML' /></a></div>";
}
if ($showver == 1)
{
        echo "<div align='right'>Forum Plus ".get_current_version()."</div>";
}

CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
die();
?>


<?php
///////////////////////////////////////////////////////////////////////////////
// Local functions
///////////////////////////////////////////////////////////////////////////////
function getCategories()
{
        global $db, $bbTable, $viewcat;
        $retArray = array();

        $where_viewcat = ($viewcat>0) ? "AND c.cat_id=$viewcat" : "";
        $sql = "SELECT c.* FROM ".$bbTable['categories']." c, ".$bbTable['forums']." f
        WHERE f.cat_id=c.cat_id $where_viewcat GROUP BY c.cat_id, c.cat_title, c.cat_order
        ORDER BY c.cat_order";

        if (!$result = $db->query($sql))
        {
                redirect_header("../../index.php", 2, _MD_COULDNOTQUERY);
                exit();
        }

        while ($cat_row = $db->fetch_array($result))
        {
                $retArray[] = $cat_row;
        }
        return $retArray;
}

function renderForumHeader()
{
        global $bbWidth, $meta, $last_visit;
?>
<table cellpadding="2" cellspacing="0" border="0" width="<?php echo $bbWidth?>"  align="center">
<tr>
        <td colspan="2">
                <b><?php printf(_MD_WELCOME, $meta['title']);?></b><br />
                <small><?php echo _MD_TOSTART;?></small><hr />
        </td>
</tr>
<tr valign="bottom">
        <td>
                <small><?php echo _MD_TOTALTOPICSC;?><b><?php echo get_total_topics();?></b> | <?php echo _MD_TOTALPOSTSC;?><b><?php echo get_total_posts("0", "all");?></b></small>
        </td>
        <td align="right">
                <small>
<?php
                        $currenttime = formatTimestamp(time(), "m");
                        printf(_MD_TIMENOW, $currenttime);
                        echo "<br />";
                                                if ($last_visit > 0)
                                                {
                                $yourlastvisit = formatTimestamp($last_visit, "m");
                                printf(_MD_LASTVISIT, $yourlastvisit);
                                                }
?>
                </small>
        </td>
</tr>
</table>
<?php
}

function renderCategory($category)
{
        global $myts;

        $forum_data = getForumData();

        $forum_count = 0;
        $forum_table = new ForumTable();
        for ($x=0; $x<count($forum_data); $x++)
    {
            if ($forum_data[$x]->cat_id == $category['cat_id'])
        {
                        $permissions = new Permissions($forum_data[$x]->forum_id);
            if ($permissions->can_view == 0)
            {
                    continue;
            }
                    $forum_table->addForum($forum_data[$x]);
                        $forum_count++;
        }
    }

    // Display inside a collapsible block
        if($forum_count > 0)
        {
                $id = 'cat_'.$category['cat_id'];
                $title = $myts->makeTboxData4Show($category['cat_title']);
                $link = 'index.php?viewcat='.$category['cat_id'];
                ToggleBlockRenderer::render($id, $title, $link, $forum_table->getHTML());
        }
}

function getForumData()
{
        global $db, $bbTable;

        $retData = array();

        $sql = "
                SELECT f.*, u.uname, u.uid, p.topic_id, p.post_time, p.subject, p.icon
                FROM ".$bbTable['forums']." f
                LEFT JOIN ".$bbTable['posts']." p
                ON p.post_id = f.forum_last_post_id
                LEFT JOIN ".$db->prefix("users")." u
                ON u.uid = p.uid WHERE f.parent_forum = 0
                ORDER BY f.cat_id, f.forum_order";

        if (!$f_res = $db->query($sql)) {
                die("Error <br />$sql<br>$db->error()</br>");
        }

        while ($forum_data = $db->fetch_object($f_res)) {
                $retData[] = $forum_data;
        }

        return $retData;
}

function get_total_topics($forum_id="")
{
	global $db, $bbTable;

	if ($forum_id)
	{
		$sql = "SELECT COUNT(*) AS total FROM ".$bbTable['topics']." WHERE forum_id = '$forum_id'";
	}
	else
	{
		$sql = "SELECT COUNT(*) AS total FROM ".$bbTable['topics'];
	}

	if (!$result = $db->query($sql))
	{
		return(_ERROR);
	}

	if (!$myrow = $db->fetch_array($result))
	{
		return(_ERROR);
	}

	return($myrow['total']);
}

function get_current_version()
{
	global $db;
	$rcxModule = RcxModule::getByDirname('forum');

	$sql = 'select version from '.$db->prefix('modules').' WHERE mid='.$rcxModule->mid();
	if($result = $db->query($sql))
	{
		if($db->num_rows($result) == 1)
		{
			$row = $db->fetch_object($result);
			return $row->version;
		}
	}
	return '';
}
?>