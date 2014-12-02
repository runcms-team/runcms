<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

echo "
<form method='get' action='"._PHP_SELF."'>
<table width='100%' border='0'  align='center' cellspacing='0' cellpadding='0'>
<tr valign='bottom'>";

echo "
<td align='left' valign='bottom'>
<b>"._MD_VIEW."</b>&nbsp;
<select class='select' name='viewmode'>
<option value='flat' ";
if ($viewmode == 'flat') {
	echo "selected='selected'";
}
echo ">"._FLAT."<option value='thread' ";
if ( !isset($viewmode) || $viewmode=='thread' || $viewmode=="" ) {
	echo "selected='selected'";
}
echo ">"._THREADED."</select>

<select class='select' name='order'>
<option value='0' ";
if ( !$order ) {
	echo "selected='selected'";
}
echo ">"._OLDESTFIRST."

<option value='1' ";
if ($order==1) {
	echo "selected='selected'";
}
$post_id = !empty($post_id) ? intval($post_id) : "";
echo ">". _NEWESTFIRST ."</select>

<input type='hidden' name='topic_id' value='".intval($topic_id)."' />
<input type='hidden' name='forum' value='".intval($forum)."' />
<input type='hidden' name='post_id' value='".$post_id."' />
<input type='submit' class='button' name='refresh' value='"._GO."' />
</td>";

// Goto Page
$start = intval($start);
if ( $viewmode == "flat" ) {
	if ( $total > $forumdata['posts_per_page'] ) {
		$times = 1;
		echo "<td align='right'><b>"._MD_GOTOPAGE." ( ";
		$last_page = $start - $forumdata['posts_per_page'];
		if ( $start > 0 ) {
			echo "<a href='"._PHP_SELF."?topic_id=".intval($topic_id)."&amp;forum=".intval($forum)."&amp;start=".intval($last_page)."&amp;viewmode=$viewmode&amp;order=".intval($order)."'>"._MD_PREVPAGE."</a> ";
		}
		for ( $x = 0; $x < $total; $x += $forumdata['posts_per_page'] ) {
			if ( $times != 1 ) {
				echo " | ";
			}
			if ( $start && ($start == $x) ) {
				echo $times;
			} elseif ( $start == 0 && $x == 0 ) {
				echo "1";
			} else {
				echo "<a href='"._PHP_SELF."?mode=viewtopic&amp;topic_id=".intval($topic_id)."&amp;forum=".intval($forum)."&amp;start=$x&amp;viewmode=$viewmode&amp;order=".intval($order)."'>$times</a>";
			}
			$times++;
		}

		if ( ($start + $forumdata['posts_per_page']) < $total ) {
			$next_page = $start + $forumdata['posts_per_page'];
			echo " <a href='"._PHP_SELF."?topic_id=".intval($topic_id)."&amp;forum=".intval($forum)."&amp;start=$next_page&amp;viewmode=$viewmode&amp;order=".intval($order)."'>"._MD_NEXTPAGE."</a>";
		}
		echo " )</b></td>";
	}
}

echo "</tr></table></form>";
?>
