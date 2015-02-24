<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('./admin_header.php');
include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');

$days    = !empty($_POST['days']) ? intval($_POST['days']) : intval($_GET['days']);
$days    = empty($days) ? 365 : $days;
$ddays   = (time() - (86400 * $days));

$sticky  = !empty($_POST['sticky'])  ? intval($_POST['sticky'])  : intval($_GET['sticky']);
$locked  = !empty($_POST['locked'])  ? intval($_POST['locked'])  : intval($_GET['locked']);
$show    = !empty($_POST['show'])    ? intval($_POST['show'])    : intval($_GET['show']);

$limit   = !empty($_POST['limit'])   ? intval($_POST['limit'])   : intval($_GET['limit']);
$limit   = !empty($limit) ? $limit : 5;

if ($sticky == 1) {
	$schk1 = " selected='selected'";
	} elseif ($sticky == 2) {
		$schk2 = " selected='selected'";
	}

if ($locked == 1) {
	$lchk1 = " selected='selected'";
	} elseif ($locked == 2) {
		$lchk2 = " selected='selected'";
	}

        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_A_PRUNE.'</div>
            <br />
            <br />';

        
echo "
<div style='text-align: center;' class='KPmellem' >"._MD_A_PLIST.":</div>
<form method='post'>
<table align='center' cellpadding='0' cellspacing='5' border='0'><tr>
<td align='right' nowrap>
"._MD_A_PSTICKY.":
<select class='select' name='sticky'>
<option value='0'>"._ANY."</option>
<option value='1'$schk1>"._YES."</option>
<option value='2'$schk2>"._NO."</option>
</select>
</td>
<td align='right' nowrap>
"._MD_A_PLOCKED.":
<select class='select' name='locked'>
<option value='0'>"._ANY."</option>
<option value='1'$lchk1>"._YES."</option>
<option value='2'$lchk2>"._NO."</option>
</select>
</td>
</tr><tr>
<td align='left'>"._MD_A_PLAST.": <input type='text' class='text' size='3' maxlength='3' name='days' value='$days' /></td>
<td align='center' colspan='2'>"._MD_A_PLIMIT.": <input type='text' class='text' size='2' maxlength='2' name='limit' value='$limit' /></td>
<td align='right'>
<input type='hidden' name='show' value='$show' />
<input type='submit' class='button' name='submit' value='"._SEARCH."' />
</td>
</tr></table></form>";

// ------------------------------------------------------------------------- //
if ( !empty($_POST['submit']) && !empty($_POST['topicid']) ) {
	foreach ($_POST['topicid'] as $value) {
		$sql2 = "
			SELECT
			post_id,
			topic_id,
			subject
			FROM
			".$bbTable['posts']."
			WHERE
			topic_id = $value
			ORDER BY topic_id DESC";

			$result2 = $db->query($sql2);
			while ( list($post_id, $topic_id, $subject) = $db->fetch_row($result2) ) {
				$db->query("DELETE FROM ".$bbTable['posts']." WHERE post_id=$post_id");
				$db->query("DELETE FROM ".$bbTable['topics']." WHERE topic_id=$topic_id");

				$subject = $myts->makeTareaData4Show($subject);
				echo sprintf(_MD_A_PDELETED, $subject)."<br />";
			}
	}
	echo "<br /><br />";
}

// ------------------------------------------------------------------------- //
$extra_sql = '';

if ($sticky == 1) {
	$extra_sql .= " AND t.topic_sticky = 1";
	} elseif ($sticky == 2) {
		$extra_sql .= " AND t.topic_sticky = 0";
	}

if ($locked == 1) {
	$extra_sql .= " AND t.topic_status = 1";
	} elseif ($locked == 2) {
		$extra_sql .= " AND t.topic_status = 0";
	}

$num_sql = "
		SELECT
		COUNT(*)
		FROM
		".$bbTable['posts']." p,
		".$bbTable['forums']." f
		INNER JOIN ".$bbTable['topics']." t
		ON (
		t.topic_last_post_id = p.post_id
		AND f.forum_id = t.forum_id
		AND p.post_time <= $ddays
		$extra_sql
		) ORDER BY t.topic_id DESC";

$num_result     = $db->query($num_sql);
list($num_rows) = $db->fetch_row($num_result);

// ------------------------------------------------------------------------- //
if ($num_rows > 0) {
	printf(_MD_A_PFOUND, $num_rows);

	$sql = "
		SELECT
		f.forum_name,
		t.topic_id,
		t.topic_title,
		t.forum_id,
		t.topic_sticky,
		t.topic_status,
		t.topic_time,
		t.topic_replies
		FROM
		".$bbTable['posts']." p,
		".$bbTable['forums']." f
		INNER JOIN ".$bbTable['topics']." t
		ON (
		t.topic_last_post_id = p.post_id
		AND f.forum_id = t.forum_id
		AND p.post_time <= $ddays
		$extra_sql
		) ORDER BY t.topic_id DESC";

	echo "
		<script type='text/javascript'>
		function toggleChecks() {
		var formdom = rcxGetElementById('topiclist');
		var i=0;
		var checked;
		len = formdom.elements.length;
		if (formdom.elements[i].checked == true) {
			checked = false;
			} else {
				checked = true;
			}
		for( i=0; i<len; i++) {
			formdom.elements[i].checked = !formdom.elements[i].checked;
		}
		}
		function confirmDelete() {
		var ok = confirm('"._MD_A_PCONFIRM."');
		if (!ok) {
			return(false);
		}
		}
		</script>
		<form id='topiclist' name='topiclist' method='post' onsubmit='return confirmDelete();'>
		<input type='hidden' name='days' value='$days' />
		<input type='hidden' name='sticky' value='$sticky' />
		<input type='hidden' name='locked' value='$locked' />
		<input type='hidden' name='show' value='$show' />
		<input type='hidden' name='limit' value='$limit' />
		<table cellpadding='0' cellspacing='0' border='0'>";

	$result = $db->query($sql, $limit, $show);
	while (list($f_fname, $t_id, $t_title, $t_forum, $t_sticky, $t_status, $t_time, $t_replies) = $db->fetch_row($result) ) {
		$f_fname = $myts->makeTareaData4Show($f_fname);
		$t_title = $myts->makeTareaData4Show($t_title);
		echo "
			<tr>
			<td><li><a href='".$bbPath['url']."viewforum.php?forum=$t_forum' target='_blank'>$f_fname</a> :: <a href='".$bbPath['url']."viewtopic.php?topic_id=$t_id&amp;forum=$t_forum' target='_blank'>$t_title</a> :: ".formatTimestamp($t_time, "s")." :: $t_replies "._MD_REPLIES."</li></td>
			<td><input type='checkbox' class='checkbox' name='topicid[]' value='$t_id' /></td>
			<td>&nbsp;";
			if ($t_sticky == 1) {
				echo " <img src='".$bbImage['sticky']."'>";
			}
			if ($t_status == 1) {
				echo " <img src='".$bbImage['locked']."'>";
			}
			echo "</td></tr>";
	}
	echo "<tr>
		<td colspan='2' align='right'><a href=javascript:toggleChecks();>"._MD_A_PCHECK."</a></td>
		</tr></table><br /><input type='submit' class='button' name='submit' value='"._DELETE."'></form>";

	$nav = new RcxPageNav($num_rows, $limit, $show, "show", "op=list_topics&amp;sticky=$sticky&amp;private=$private&amp;locked=$locked&amp;days=$days&amp;limit=$limit&amp;access=$access");
	echo '<br /><div align="center">'.$nav->renderNav().'</div>';
	} else {
		echo "<div style='text-align: center;' class='KPmellem' >" . _MD_A_PNFOUND . "</div>";
	}
echo "                        
        </td>
    </tr>
</table>";
CloseTable();
rcx_cp_footer();
exit();
?>
