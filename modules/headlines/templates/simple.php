<?php
function simple ($rss, $num_items = 0)
{
	$title = $rss->channel['title'];
	$link = $rss->channel['link'];
	
	$content = '';
	$content .= "<a href=$link><b>$title</b></a><p>";
	$content .= "<ul>";
	$items = ($num_items > 0) ? array_slice($rss->items, 0, $num_items) : $rss->items;
	foreach ($items as $item ) {
		$href = $item['link'];
		$title = $item['title'];	
		$content .= "<li><a href=$href>$title</a></li>";
	}
	$content .= "</ul>";

	return $content;
}
?>