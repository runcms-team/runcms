<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$rcxOption['pagetype'] = "search";

include_once("mainfile.php");
include_once(RCX_ROOT_PATH."/class/rcxformloader.php");

$action = isset($_POST['action']) ? trim($_POST['action'])  : "search";
$query  = isset($_POST['query'])  ? trim($_POST['query'])   : "";
$andor  = isset($_POST['andor'])  ? trim($_POST['andor'])   : "AND";
$start  = isset($_POST['start'])  ? intval($_POST['start']) : 0;
$mids   = isset($_POST['mids'])   ? $_POST['mids']          : array();
$mid    = isset($_POST['mid'])    ? intval($_POST['mid'])   : 0;
$uid    = isset($_POST['uid'])    ? intval($_POST['uid'])   : 0;

if (empty($uid)) {
	if ( $action == "results" && $query == "" ) {
		redirect_header("search.php", 1, _SR_PLZENTER);
		exit();
	}
	if ( $action == "showall" && ($query == "" || empty($mid)) ) {
		redirect_header("search.php", 1, _SR_PLZENTER);
		exit();
	}
}

if ( $andor != "OR" && $andor != "exact" && $andor != "AND" ) {
	$andor = "AND";
}

if ($action == "results") {


	if ( !is_array($mids) || count($mids) == 0 ) {
		$mids = array();
		$mids =& RcxModule::getHasSearchModulesList(false);
	}
	if ( $andor != "exact" ) {
		$queries = split(" ", $myts->oopsAddSlashesGPC($query));
		} else {
			$queries = array($myts->oopsAddSlashesGPC($query));
		}
	include_once(RCX_ROOT_PATH."/header.php");
	OpenTable();
	echo "<h3>"._SR_SEARCHRESULTS."</h3>";
	foreach ( $mids as $mid ) {
		$mid     = intval($mid);
		$module  = new RcxModule($mid);
		$results = array();
		$results = $module->search($queries, $andor, 5, 0, $uid);
		echo "<h4>".$module->name()."</h4>";
		$count = count($results);
		if ( !is_array($results) || ($count == 0) ) {
			echo _SR_NOMATCH."</p>";
			} else {
			for ($i=0; $i<$count; $i++) {
				if ( isset($results[$i]['image']) || $results[$i]['image'] != "" ) {
					echo "<img vspace='2' src='modules/".$module->dirname()."/".$results[$i]['image']."' alt='".$module->name()."' />&nbsp;";
					} else {
						echo "<img vspace='2' src='images/icons/posticon.gif' alt='".$module->name()."' />&nbsp;";
					}
				echo "<b><a href='modules/".$module->dirname()."/".$results[$i]['link']."'>".$myts->makeTboxData4Show($results[$i]['title'])."</a></b><br />\n";
				if ($results[$i]['content']) {
					echo '<small>&nbsp;&nbsp;&nbsp;&nbsp;'.strip_tags($myts->makeTareaData4Show(strip_tags($results[$i]['content']),2,1,1)).'</small><br />';
				}
				echo "<small>&nbsp;&nbsp;&nbsp;&nbsp;";
				$results[$i]['uid'] = intval($results[$i]['uid']);
				if ( !empty($results[$i]['uid']) ) {
					$uname = RcxUser::getUnameFromId($results[$i]['uid']);
					echo "<a href='".RCX_URL."/userinfo.php?uid=".$results[$i]['uid']."'>".$uname."</a>\n";
					}
				echo $results[$i]['time'] ? " (". formatTimestamp(intval($results[$i]['time'])).")" : "";
				echo "</small><br />";
			}
			if ($count == 5) {
				echo "
				<br />
				<form action='search.php' method='post' id='showall".$mid."' name='showall".$mid."'>
				<input type='hidden' value='".$myts->makeTboxData4PreviewInForm($query)."' name='query' />
				<input type='hidden' name='mid' value='".$mid."' />
				<input type='hidden' name='uid' value='".$uid."' />
				<input type='hidden' name='action' value='showall' />
				<input type='hidden' name='andor' value='".$andor."' />
				<img src='".RCX_URL."/images/pixel.gif' />
				<a href='#"._ALL."' onclick='rcxGetElementById(\"showall".$mid."\").submit();'>"._SR_SHOWALLR."</a>
				</form>";
			}
		}
	}
	CloseTable();
}

if ( ($action == "search") || ($action == "results") ) {
	if ( $action == "search" ) {
		include_once(RCX_ROOT_PATH."/header.php");
	}
	OpenTable();
	include_once("include/searchform.php");
	$search_form->display();
	CloseTable();
}

if ( $action == "showall" ) {
	if ( $andor != "exact" ) {
		$queries = split(" ", $myts->oopsAddSlashesGPC($query));
		} else {
			$queries = array($myts->oopsAddSlashesGPC($query));
		}
	include_once(RCX_ROOT_PATH."/header.php");
	$module  = new RcxModule($mid);
	$results = array();
	$results = $module->search($queries, $andor, 0, 0, $uid);
	$count   = count($results);
	if ( ($count-$start) > 20 ) {
		$limit = ($start + 20);
		} else {
			$limit = $count;
		}
	OpenTable();
	echo "<h3>"._SR_SEARCHRESULTS."</h3>";
	printf(_SR_FOUND, $count);
	echo "<br />";
	printf(_SR_SHOWING, ($start+1), $limit);
	echo "<p><h4>".$module->name()."</h4>";
	for ($i=$start; $i<$limit; $i++) {
		if ( isset($results[$i]['image']) && $results[$i]['image'] != "" ) {
			echo "<img vspace='2' src='modules/".$module->dirname()."/".$results[$i]['image']."' alt='".$module->name()."' />&nbsp;";
			} else {
				echo "<img vspace='2' src='images/icons/posticon.gif' alt='".$module->name()."' />&nbsp;";
			}
		echo "<b><a href='modules/".$module->dirname()."/".$results[$i]['link']."'>".$myts->makeTboxData4Show($results[$i]['title'])."</a></b><br />\n";
		if ($results[$i]['content']) {
			echo '<small>&nbsp;&nbsp;&nbsp;&nbsp;'.strip_tags($myts->makeTareaData4Show(strip_tags($results[$i]['content']),2,1,1)).'</small><br />';
		}
		echo "<small>&nbsp;&nbsp;&nbsp;&nbsp;";
		$results[$i]['uid'] = intval($results[$i]['uid']);
		if ( !empty($results[$i]['uid']) ) {
			$uname = RcxUser::getUnameFromId($results[$i]['uid']);
			echo "<a href='".RCX_URL."/userinfo.php?uid=".$results[$i]['uid']."'>".$uname."</a>\n";
			}
		echo $results[$i]['time'] ? " (". formatTimestamp(intval($results[$i]['time'])).")" : "";
		echo "</small><br />";
	}
	echo "</p><table><tr>";
	if ($start > 0) {
		$prev = ($start - 20);
		echo "
		<td align='left'>
		<form action='search.php' method='post' id='showprev' name='showprev'>
		<input type='hidden' value='".$myts->makeTboxData4PreviewInForm($query)."' name='query' />
		<input type='hidden' name='mid' value='".$mid."' />
		<input type='hidden' name='uid' value='".$uid."' />
		<input type='hidden' name='action' value='showall' />
		<input type='hidden' name='andor' value='".$andor."' />
		<input type='hidden' name='start' value='".$prev."' />
		<img src='".RCX_URL."/images/pixel.gif' />
		<a href='#$prev' onclick='rcxGetElementById(\"showprev\").submit();'>"._SR_PREVIOUS."</a></form></td>\n";
		}
	echo "<td>&nbsp;</td>";
	if ( ($count-$start) > 20 ) {
		$next = ($start + 20);
		echo "
		<td align='right'><form action='search.php' method='post' id='shownext' name='shownext'>
		<input type='hidden' value='".$myts->makeTboxData4PreviewInForm($query)."' name='query' />
		<input type='hidden' name='mid' value='".$mid."' />
		<input type='hidden' name='uid' value='".$uid."' />
		<input type='hidden' name='action' value='showall' />
		<input type='hidden' name='andor' value='".$andor."' />
		<input type='hidden' name='start' value='".$next."' />
		<img src='".RCX_URL."/images/pixel.gif' />
		<a href='#$next' onclick='rcxGetElementById(\"shownext\").submit();'>"._SR_NEXT."</a></form></td>\n";
	}
	echo "</tr></table><p>";
	include_once("include/searchform.php");
	$search_form->display();
	echo "</p>";
	CloseTable();
}

include_once(RCX_ROOT_PATH."/footer.php");
?>
