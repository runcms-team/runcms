
<?php
function slashbox ($rss, $num_items = 0)
{
	$content  = '';
	$content .= "<table cellpadding=2 cellspacing=0><tr>";
	$content .= "<td bgcolor='#006666'>";
	
	$content .= "<a href={$rss->get_permalink()}><font color=#FFFFFF><b>{$rss->get_title()}</b></font></a>";
	$content .= "</td></tr>";
	
	# foreach over each item in the array.
	# displaying simple links
	#
	# we could be doing all sorts of neat things with the dublin core
	# info, or the event info, or what not, but keeping it simple for now.
	#

	$items = $rss->get_items( 0, $rss->get_item_quantity($num_items) );

	foreach ($items as $item ) {
		$content .= "<tr><td bgcolor=#cccccc>";
		$content .= "<a href={$item->get_permalink()}>";
		$content .= $item->get_title();
		$content .= "</a></td></tr>";
	}		
	
	$content .= "</table><br />";

	return $content;
}

?>