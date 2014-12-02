
<?php
function slashbox ($rss, $num_items = 0)
{
	$content  = '';
	$content .= "<table cellpadding=2 cellspacing=0><tr>";
	$content .= "<td bgcolor=#006666>";
	
	# get the channel title and link properties off of the rss object
	#
	$title = $rss->channel['title'];
	$link = $rss->channel['link'];
	
	$content .= "<a href=$link><font color=#FFFFFF><b>$title</b></font></a>";
	$content .= "</td></tr>";
	
	# foreach over each item in the array.
	# displaying simple links
	#
	# we could be doing all sorts of neat things with the dublin core
	# info, or the event info, or what not, but keeping it simple for now.
	#

	$items = ($num_items > 0) ? array_slice($rss->items, 0, $num_items) : $rss->items;

	foreach ($items as $item ) {
		$content .= "<tr><td bgcolor=#cccccc>";
		$content .= "<a href=$item[link]>";
		$content .= $item['title'];
		$content .= "</a></td></tr>";
	}		
	
	$content .= "</table><br />";

	return $content;
}

?>
